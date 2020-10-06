<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Locality;
use frontend\models\LocalitySearch;
use frontend\models\Service;
use frontend\models\ServiceLayer;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\IntegrityException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;


/**
 * LocalityController implements the CRUD actions for Locality model.
 */
class LocalityController extends Controller
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
                        'actions' => ['index','view'],
                        'allow' => true,
                        'roles' => ['admin','user', 'student', 'guest'],
                    ],
                    [
                        'actions' => ['create','update','delete','renderajax'],
                        'allow' => true,
                        'roles' => ['admin','user', 'student'],
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all Locality models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LocalitySearch();
        //remmember filter
        $param = ServiceLayer::setSession(Yii::$app->request->queryParams, 'LocalitySearch');

        $dataProvider = $searchModel->search($param);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Locality model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    
    public function actionRenderajax()
    {
        $model = new Locality();
        $lists = $this->setLists();
        $session = Yii::$app->session;
        if ($session['mem']) {
            $model = $session['mem'];
            return $this->renderAjax('_form', [
                'model' => $model,
                'lists' => $lists,
            ]);
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
                'lists' => $lists,
            ]);
        }
    }

    public function actionCreate()
    {
        $session = Yii::$app->session;
        $model = new Locality();
        $lists = $this->setLists();
        if (Yii::$app->request->isAjax) {
           
            if ($model->load(Yii::$app->request->post()) && $model->save()) {

                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                if ($session['mem']) {
                    $session->remove('mem');
                }
                return [
                    'res' => 1,

                ];
            } else {

                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $session['mem'] = $model;
                return [
                    'res' => 'error',




                ];
            }
        }
        else {
           
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['locality/index']);
            }
            
                return $this->render('create', [
                    'model' => $model, 
                    'lists' => $lists,          
                ]);
            
        }
    }

    /**
     * Updates an existing Locality model.
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
        
        $lists = $this->setLists();
        return $this->render('update', [
            'model' => $model,
            'lists' => $lists,
        ]);
    }

    /**
     * Deletes an existing Locality model.
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
        } catch (IntegrityException $e) {

            Yii::$app->session->setFlash('error','The record has not been deleted with the server since it is related to other elements.');
            return $this->redirect(['view','id'=>$id]);
        }
    }

    /**
     * Finds the Locality model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Locality the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Locality::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function setLists()
    {
        $province = ArrayHelper::map(Service::find()->where(['target' => 'province'])->andWhere(['_table' => 'locality'])->orderBy('value')->all(), 'id', 'value');
        $country = ArrayHelper::map(Service::find()->where(['target' => 'country'])->andWhere(['_table' => 'locality'])->orderBy('value')->all(), 'id', 'value');
        $island = ArrayHelper::map(Service::find()->where(['target' => 'island'])->andWhere(['_table' => 'locality'])->orderBy('value')->all(), 'id', 'value');
        $lists['province'] = $province;
        $lists['country'] = $country;
        $lists['island'] = $island;

        return $lists;
    }
}
