<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use frontend\models\UserSearch;
use frontend\models\AccessSearch;
use frontend\models\Access;
use frontend\models\ChangePasswordForm;
use frontend\models\ChangeRole;
use frontend\models\SignupForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','create','changerole','delete', 'access-update',
                        'create-permission','delete-permission', 'taxon-list'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view','update','changepassword'],
                        'matchCallback' => function ($rule, $action) {
                           // var_dump(Yii::$app->request->queryParams['id']);
                           // die();
                            return Yii::$app->user->can('canProfile', ['id'=>Yii::$app->request->queryParams['id']]);
                        }
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $searchModel = new AccessSearch();
        //show only 'deleted' records
        $param = Yii::$app->request->queryParams;
        $param["AccessSearch"]["user_id"] = $id;
        $dataProvider = $searchModel->search($param);
       // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    */
    public function actionCreate()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'User have been added');
            return $this->redirect(['user/index']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
            Yii::$app->session->setFlash('success', 'The user have been deleted.');
        }
        catch (yii\db\IntegrityException $e) {
            throw new NotFoundHttpException('The record has children.');
        }
        
        
        
    }

    public function actionChangerole($id, $name)
    {
         $model = new ChangeRole();
         $role=Yii::$app->user->identity->id;
        if($model->countAdmin($name,$id,$role))
        {
           
            Yii::$app->session->setFlash('warning', 'At least one admin must be in the system.'); 
        }
        else{
           
            $model->changeRole($id, $name);
        }

        return $this->redirect(['view','id'=>$id]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionChangepassword($id)
    {

        $model = new ChangePasswordForm();
        

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->changePassword($id)) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('change_password', [
            'model' => $model,
        ]);
    }

    public function actionCreatePermission($id)
    {
        $model = new Access();
        $model->user_id = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('create_permission', [
            'model' => $model,
        ]);
    }

    public function actionAccessUpdate($id)
    {
        $model = Access::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('access_update', [
            'model' => $model,
        ]);
    }

    public function actionDeletePermission($id, $user)
    {
        Access::findOne($id)->delete();

        return $this->redirect(['view', 'id' => $user]);;
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //return list of species for Select2

    public function actionTaxonList($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new yii\db\Query;
            $query->select('id, scientificName AS text')
                ->from('taxonomy')
                ->where(['like', 'scientificName', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Taxonomy::find($id)->scientificName];
        }
        return $out;
    }
}
