<?php

namespace frontend\controllers;

use Yii;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use common\models\LoginForm;
use frontend\models\Statistic;
use frontend\models\ImageUpload;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'upload-image', 'logout', 'about'],
                'rules' => [
                    [
                        'actions' => ['index', 'upload-image', 'logout', 'about'],
                        'allow' => true,
                        'roles' => ['admin', 'user', 'guest'],

                    ],
                    [
                        'actions' => ['index', 'logout', 'about'],
                        'allow' => true,
                        'roles' => ['guest'],

                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    //Displays homepage.
    function actionIndex()
    {
        $count = Statistic::count();       
        return $this->render(
            'index',
            ['count'=>$count]);
    }

    // upload image(s)
    public function actionUploadImage($id)
    {
        $model = new ImageUpload();


        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->upload($id) === true) {
                // file is uploaded successfully
                $this->redirect(['host/view', 'id' => $id]);
            } else {
                Yii::$app->session->setFlash('error', $model->upload($id));
            }
        }
        return $this->render('uploadImage', ['model' => $model]);
    }

    //Logs in a user.     
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    //Logs out the current user.   
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    //Displays about page.    
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionError()
    {
        /* @var HttpException $exception */
        $exception = \Yii::$app->getErrorHandler()->exception;

        return $this->render('site/errors', [
            'name' => '',
            'message' => $exception->getMessage(),
            'exception' => $exception,
        ]);
    }
}
