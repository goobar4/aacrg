<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Host;
use frontend\models\HostSearch;
use frontend\models\Container;
use frontend\models\Image;
use common\models\User;
use frontend\models\ModelhistorySearch;
use frontend\models\Service;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\db\IntegrityException;
use yii\helpers\BaseFileHelper;
use frontend\models\ServiceLayer;
use yii\web\ForbiddenHttpException;


/**
 * HostController implements the CRUD actions for Host model.
 */
class HostController extends Controller
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
                   // 'delete' => ['POST'],
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
                        'actions' => ['create', 'update', 'delete', 'restore', 'history', 'place-list', 'taxon-list', 'deleted-host', 'manage-image', 'delete-image'],
                        'allow' => true,
                        'roles' => ['admin', 'user', 'student'],
                    ],
                   
                ],
            ]
        ];
    }

    
    /**
     * Lists 'non-deleted' Host models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HostSearch();
        //remmember filter
        $param = ServiceLayer::setSession(Yii::$app->request->queryParams, 'HostSearch');
        //show only 'non-deleted' records
        $param["HostSearch"]["isDeleted"] = 0;
        $dataProvider = $searchModel->search($param);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /*
    /List of 'deleted' Host models 
    /@return mixed
    */
    public function actionDeletedHost()
    {

        $searchModel = new HostSearch();
        //show only 'deleted' records
        $param = ServiceLayer::setSession(Yii::$app->request->queryParams, 'HostSearch');
        $param["HostSearch"]["isDeleted"] = 1;
        $dataProvider = $searchModel->search($param);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'contoller'=>$this->id,
        ]);
    }

    /**
     * Displays a single Host model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        //prepare arrays for Select2 widget
        $lists = $this->setLists();
        // process ajax
        if (Yii::$app->request->isAjax && isset($post['kvdelete'])) {
            
            //try 'soft delation'
            
           
                if(!$this->softDelation($id)){
                Yii::$app->session->setFlash('error', 'The record has not been deleted with the server since it is related to other elements');
                return $this->redirect(['view', 'id' => $id]);
            }
            else{
                return $this->redirect(['index']);

            }

            
        }
        //procces post
        if ($post) {
            $model = $this->findModel($_GET['id']);
            //if model validated save post
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

        ($model->isDeleted == 1)?$del='1':$del='0';

        //look for children of the record (container)
       
        $sql1 = (new \yii\db\Query())
        ->select(['container.containerId', 'sample.id', 'taxonomy.scientificName',
        'sample.individualCount','service.value','container.prepType'])
        ->from('container')
        ->leftJoin('sample', 'container.containerId=sample.parid')
        ->leftJoin('taxonomy', 'sample.scienName=taxonomy.id')
        ->leftJoin('service', 'container.prepType=service.id')
        ->where(['container.parId' => $id])
        ->andWhere(['container.isDeleted'=>$del])
        ->andWhere(['sample.isDeleted'=>$del]);
                    
         $sql2 = (new \yii\db\Query())
        ->select(['container.containerId', 'sample.id', 'taxonomy.scientificName',
        'sample.individualCount','service.value','container.prepType'])
        ->from('container')
        ->leftJoin('sample', 'container.containerId=sample.parid')
        ->leftJoin('taxonomy', 'sample.scienName=taxonomy.id')
        ->leftJoin('service', 'container.prepType=service.id')
        ->where(['container.parId' => $id])
        ->andWhere(['container.isDeleted'=>$del])
        ->andWhere(['sample.isDeleted'=>NULL]);

        $sql = $sql1->union($sql2)->all();
       
        //look for images

        $images = Image::find()->where(['parId' => $id])->all();


        return $this->render('view', [
            'model' => $this->findModel($id),
            'lists' => $lists,
            'images' => $images,
            'sql' => $sql
        ]);
    }

    //return list of species for Select2

    public function actionTaxonList($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ServiceLayer::getSelectList($q,'taxonomy','scientificName');
    }

    //return list of places for Select2

    public function actionPlaceList($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; 
        return  ServiceLayer::getSelectList($q,'locality','localityName');    
    }


    public function actionManageImage($id){

            
        $image = Image::find()->where(['parId'=>$id])->all();
        return $this->render('images', ['image'=>$image, 'id'=>$id]);
    }

    public function actionDeleteImage($id){
        $image = Image::findOne($id);
        BaseFileHelper::unlink('uploads/images/'.$image->name);        
        $image->delete();
        return $this->redirect(['manage-image', 'id'=>$image->parId]);

    }


    /**
     * Creates a new Host model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Host();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->occurrenceID]);
        }

        return $this->render('create', [
            'model' => $model,
            'lists' => $this->setLists(),

        ]);
    }


    /**
     * Updates an existing Host model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $lists = $this->setLists();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->occurrenceID]);
        }

        return $this->render('update', [
            'model' => $model,
            'lists' => $lists,
        ]);
    }

    /**
     * Deletes an existing Host model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->isDeleted == 0) {
            if (!$this->softDelation($id)) {

                Yii::$app->session->setFlash('error', 'The record has not been deleted with the server since it is related to other elements.');
                return $this->redirect(['view', 'id' => $id]);
            }
            return $this->redirect(['index']);
        } else {
            if (Yii::$app->user->can('canAdmin')){
            try {
                if ($model->isEmpty == 1 and $model->isDeleted == 1) {
                    $empty = Container::find()->where(['parId' => $id]);
                    if ($empty->count() > 0) {
                        $empty = $empty->all();
                        foreach ($empty as $e) {
                            $e->DeleteEmptyTubes($id);
                        }
                    }
                    //delete images
                    $images = Image::find()->where(['parId'=>$id]);
                    if($images->count()>0){
                        foreach($images->all() as $image){
                            BaseFileHelper::unlink('uploads/images/'.$image->name);
                            $image->delete();                           
                        }
                    }
                }
                $model->delete();
                return $this->redirect(['index']);
            } catch (IntegrityException $e) {

                Yii::$app->session->setFlash('error', 'The record has not been deleted with the server since it is related to other elements.');
                return $this->redirect(['view', 'id' => $id]);
            }
        } else {
            throw new ForbiddenHttpException('You have not right to delete this record.');
        }
        }
    }

    public function actionRestore($id)
    {
        $model = $this->findModel($id);
        if ($model->isDeleted == 1) {
            
            if ($model->hasDeletedChildren() == 0) {
                $model->isDeleted = 0;
                $model->save(false);
            } else {
                Yii::$app->session->setFlash('error', 'The record has not been restored  since it has removed children.');
                return $this->redirect(['view', 'id' => $model->occurrenceID]);
            }
        }
        return $this->redirect(['view', 'id' => $model->occurrenceID]);
    }

    public function actionHistory($id, $table)
    {
        $searchModel = new ModelhistorySearch();
        $param = ServiceLayer::setHistoryParam(Yii::$app->request->queryParams, $table, $id);         
        $dataProvider = $searchModel->search($param);
        $dataProvider = ServiceLayer:: getHistoryValue($dataProvider);
               
        return $this->render('history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id,
            'table' => $table
        ]);
    }



    /**
     * Finds the Host model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Host the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Host::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function setLists()
    {
        $determiner = ArrayHelper::map(User::find()->all(), 'id', 'surname');
        $sex = ArrayHelper::map(Service::find()->where(['target' => 'sex'])->andWhere(['_table' => 'host'])->orderBy('value')->all(), 'id', 'value');
        $age = ArrayHelper::map(Service::find()->where(['target' => 'age'])->andWhere(['_table' => 'host'])->orderBy('value')->all(), 'id', 'value');
        $natureOfRecord = ArrayHelper::map(Service::find()->where(['target' => 'natureofRecord'])->andWhere(['_table' => 'host'])->orderBy('value')->all(), 'id', 'value');
        $lists['determiner'] = $determiner;
        $lists['sex'] = $sex;
        $lists['age'] = $age;
        $lists['natureOfRecord'] = $natureOfRecord;

        return $lists;
    }
    protected function softDelation($id)
    {
        $model = $this->findModel($id);   
     
        if ($model->hasChildren() == 0 or $model->hasDeletedChildren()==$model->hasChildren()) {
            $model->isDeleted = 1;
            $model->save(false);
            return true;
        } else {
            return false;
        }
    }
}
