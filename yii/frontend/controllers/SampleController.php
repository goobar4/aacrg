<?php

namespace frontend\controllers;

use frontend\models\Container;
use Yii;
use frontend\models\Sample;
use frontend\models\SampleSearch;
use frontend\models\Collection;
use frontend\models\ServiceLayer;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use frontend\models\Taxonomy;
use yii\filters\AccessControl;
use common\models\User;
use frontend\models\Service;
use yii\web\ForbiddenHttpException;

/**
 * SampleController implements the CRUD actions for Sample model.
 */
class SampleController extends Controller
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
                    //'delete' => ['POST','AJAX'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['admin', 'user', 'student', 'guest'],
                    ],
                    [
                        'actions' => ['create', 'taxon-list', 'deleted-sample', 'add-collection', 'remove-collection', 'collection'],
                        'allow' => true,
                        'roles' => ['admin', 'user', 'student'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'delete', 'restore'],
                        'matchCallback' => function ($rule, $action) {
                            $id = Yii::$app->request->queryParams['id'];
                            $model = $this->findModel($id);
                            return Yii::$app->user->can('canEdit', ['id' => $model->scienName]);
                        }
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all Sample models.
     * @return mixed
     */
    public function actionIndex()
    {
       
       $searchModel = new SampleSearch();
       $param = ServiceLayer::setSession(Yii::$app->request->queryParams, 'SampleSearch');

        $dataProvider = $searchModel->search($param, 0);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single Sample model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
		$initial_name = $model->scienName;
        // Find host of this sample        
        $lists = $this->setLists();
        $post = Yii::$app->request->post();

        // process ajax from Detail View Kartik
        if (Yii::$app->request->isAjax && isset($post['kvdelete'])) {			
            if (Yii::$app->user->can('canEdit', ['id' => $initial_name])) {
                //code the same as for actionDelete
                if ($model->delation()) {
                    return $this->redirect(['container/view', 'id' => $model->parId]);
                } else {
                    Yii::$app->session->setFlash('error', 'The record has not been deleted with the server since it is related to other elements.');
                    return $this->redirect(['view', 'id' => $id]);
                }
            } else {
                Yii::$app->session->setFlash('error', 'You are not allowed to perform this action.');
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        //procces post from Detail View Kartik
        if ($post) {
            $model = $this->findModel($_GET['id']);
            //if model validated save post
            $model->load($post);

            if ($model->load($post)) {
                if ($model->validate()) {
                    //save if user have acces
					
                    if (Yii::$app->user->can('canEdit', ['id' => $initial_name])) {
                        $model->save(false);
                    } else {
                        throw new ForbiddenHttpException('You are not allowed to perform this action.');
                    }

                    //if model is not validated set error
                } else {

                    Yii::$app->session->setFlash('error', $model->getFirstErrors());
                }
            }
        }

        //get Host model ID (occurrenceID)
        $back = Container::findOne(['containerId' => $model->parId]);

        return $this->render('view', [
            'model' => $model,
            'lists' => $lists,
            'back' => $back->parId,
        ]);
    }



    /**
     * Creates a new Sample model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id, $back)
    {
        $model = new Sample();
        $model->parId = $id;
        $lists = $this->setLists();
        $cont_model = Container::findOne($id);
        $model->isDeleted = $cont_model->isDeleted;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['container/view', 'id' => $model->parId]);
        }

        return $this->render('create', [
            'model' => $model,
            'lists' => $lists,
            'back' => $back,
        ]);
    }

    /**
     * Updates an existing Sample model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $lists = $this->setLists();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        //get Host model ID (occurrenceID)
        $back = Container::findOne(['containerId' => $model->parId]);

        return $this->render('update', [
            'model' => $model,
            'lists' => $lists,
            'back' => $back->parId,
        ]);
    }

    /**
     * Deletes an existing Sample model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $back = $model->parId;
        $model->delation();
        return $this->redirect(['container/view', 'id' => $back]);
    }

    public function actionRestore($id)
    {
        $model = $this->findModel($id);
        $model->restore();
        return $this->redirect(['container/view', 'id' => $model->parId]);
    }

    public function actionDeletedSample()
    {

        $searchModel = new SampleSearch();
        //show only 'deleted' records
        $param = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($param, 1);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'contoller' => $this->id,
        ]);
    }

    public function actionTaxonList($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new yii\db\Query;
            $query->select('id, scientificName AS text')
                ->from('taxonomy')
                ->where(['like', 'scientificName', $q.'%', false])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Taxonomy::find($id)->scientificName];
        }
        return $out;
    }

    /**
     * Finds the Sample model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sample the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sample::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findCollection($id)
    {
        if (($model = Collection::find()->where(['sample_id' => $id])->andWhere(['user_id' => Yii::$app->user->id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionCollection()
    {

        $searchModel = new SampleSearch();
        $param = ServiceLayer::setSession(Yii::$app->request->queryParams, 'SampleSearch');
        $param['SampleSearch']["collection"] = 1;
        $dataProvider = $searchModel->search($param, 0);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'collection' => $this->id

        ]);
    }
   
    public function actionAddCollection($id)
    {

        $model = new Collection();
        $model->create($id);
        $this->redirect(['index']);
    }

    public function actionRemoveCollection($id)
    {

        $model = $this->findCollection($id);
        $model->delete();
        $this->redirect(['index']);
    }



    protected function setLists()
    {
        $identifiedBy = ArrayHelper::map(User::find()->all(), 'id', 'username');
        $site = ArrayHelper::map(Service::find()->where(['target' => 'site'])->andWhere(['_table' => 'sample'])->orderBy('value')->all(), 'id', 'value');
        $BasisOfRecord = ArrayHelper::map(Service::find()->where(['target' => 'basisOfRecord'])->andWhere(['_table' => 'sample'])->orderBy('value')->all(), 'id', 'value');
        $typeStatus = ArrayHelper::map(Service::find()->where(['target' => 'typeStatus'])->andWhere(['_table' => 'sample'])->orderBy('value')->all(), 'id', 'value');
        $lists['identifiedBy'] = $identifiedBy;
        $lists['site'] = $site;
        $lists['basisOfRecord'] = $BasisOfRecord;
        $lists['typeStatus'] = $typeStatus;

        return $lists;
    }
}
