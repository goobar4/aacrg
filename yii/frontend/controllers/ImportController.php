<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Import;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Import options
 */
class ImportController extends Controller
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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],                    
                ],
            ]
        ];
    }


    public function actionIndex()
    {
        $model = new Import;
        if (Yii::$app->request->post()) {
          
            $model->file = UploadedFile::getInstance($model, 'file');
          
            if ($model->import()) {                
                Yii::$app->session->setFlash('success', 'Success');
            } else {
                Yii::$app->session->setFlash('error', $model->log);
            }
        }
        return $this->render(
            'index',
            ['model' => $model]
        );
    }   
}