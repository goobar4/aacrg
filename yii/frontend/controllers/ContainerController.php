<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Container;
use frontend\models\ContainerSearch;
use frontend\models\Sample;
use frontend\models\ServiceLayer;
use frontend\models\Service;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\Host;
use frontend\models\Storage;
use yii\helpers\ArrayHelper;

/**
 * ContainerController implements the CRUD actions for Container model.
 */
class ContainerController extends Controller
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
                   // 'delete' => ['POST','AJAX'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','view'],
                        'allow' => true,
                        'roles' => ['admin','user','guest'],
                    ],
                    [
                        'actions' => ['create','update','delete','restore','deleted-container'],
                        'allow' => true,
                        'roles' => ['admin','user'],
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all Container models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContainerSearch();
        //show only 'undeleted' records
        $param = ServiceLayer::setSession(Yii::$app->request->queryParams, 'ContainerSearch');
        $param["ContainerSearch"]["isDeleted"] = 0;
        $dataProvider = $searchModel->search($param);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    //show list of deleted containers 
    
    public function actionDeletedContainer()
    {

        $searchModel = new ContainerSearch();
        //show only 'deleted' records
        $param = ServiceLayer::setSession(Yii::$app->request->queryParams, 'ContainerSearch');
        $param["ContainerSearch"]["isDeleted"] = 1;
        $dataProvider = $searchModel->search($param);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'contoller'=>$this->id,
        ]);
    }

    /**
     * Displays a single Container model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        ($model->isDeleted == 1)?$del=1:$del=0;
        $sample = Sample::find()->where(['parId' => $id])->andWhere(['isDeleted'=>$del])->all();

        $lists=$this->setLists();
        $post = Yii::$app->request->post();

        // process ajax from Detail View Kartik
        if (Yii::$app->request->isAjax && isset($post['kvdelete'])) {
            
            //code the same as for actionDelete

            if($model->delation()){
                return $this->redirect(['host/view', 'id' => $model->parId]);
            } else {
                Yii::$app->session->setFlash('error', 'The record has not been deleted with the server since it is related to other elements.');
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        //procces post from Detail View Kartik
        if ($post) {
            $model = $this->findModel($_GET['id']);
            //if model validated save post
            $model->scenario = Container::SCENARIO_UPDATE;
            $model->load($post);
            if ($model->load($post)) {
                if ($model->validate()) {
                    $model->save(false);
                    //if model is not validated set error
                } else {

                    Yii::$app->session->setFlash('error', $model->getFirstErrors());
                }
            }
        }
        
        return $this->render('view', [
            'model' => $model,
            'sample'=>$sample,
            'lists'=>$lists,       ]);
    }

    /**
     * Creates a new Container model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        //set initial value
        $model = new Container(['scenario'=>Container::SCENARIO_CREATE]);
        $model->parId = $id;
        $host_model = Host::findOne($id);
        $model->isDeleted=$host_model->isDeleted;
        $model->containerId=$id;
        $lists = $this->setLists();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['host/view', 'id' => $model->parId]);
        }

        return $this->render('create', [
            'model' => $model,
            'lists'=>$lists,
        ]);
    }

    /**
     * Updates an existing Container model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Container::SCENARIO_UPDATE;
        $lists = $this->setLists();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['host/view', 'id' => $model->parId]);
        }

        return $this->render('update', [
            'model' => $model,
            'lists'=> $lists,
        ]);
    }

    // delete item. soft delation if it has status isDeleted = 0 and permanent delation if isDeleted = 1

    public function actionDelete($id)
    {
        $model = $this->findModel($id);        
    
        If($model->delation()){
            return $this->redirect(['host/view', 'id' => $model->parId]);
        } else {
            Yii::$app->session->setFlash('error', 'The record has not been deleted with the server since it is related to other elements.');
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    //set status isDeleted = 1 if item has no deleted children

    public function actionRestore($id){
        $model = $this->findModel($id);
        if($model->restore()){
            return $this->redirect(['host/view', 'id' => $model->parId]);
        }
        Yii::$app->session->setFlash('error', 'The record has not been restored  since it has removed children.');
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Finds the Container model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Container the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Container::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function setLists()
    {
        $containerType = ArrayHelper::map(Service::find()->where(['target' => 'containerType'])->andWhere(['_table' => 'container'])->orderBy('value')->all(), 'id', 'value');
        $prepType = ArrayHelper::map(Service::find()->where(['target' => 'prepType'])->andWhere(['_table' => 'container'])
        ->andWhere(['<>','value','nosample'])->orderBy('value')->all(), 'id', 'value');

        $fixative = ArrayHelper::map(Service::find()->where(['target' => 'fixative'])->andWhere(['_table' => 'container'])->orderBy('value')->all(), 'id', 'value');
        $storage = ArrayHelper::map(Storage::find()->orderBy('item1')->all(), 'id', 'item1');
        $lists['fixative'] = $fixative;
        $lists['containerType'] = $containerType;
        $lists['prepType'] = $prepType;
        $lists['storage']=$storage;
        
        return $lists;
    }

}
