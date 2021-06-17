<?php

namespace frontend\controllers;

use Yii;
use frontend\models\VialSearch;
use frontend\models\HostSearch;
use yii\filters\AccessControl;



class SearchController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['export'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['vial', 'map-parasite', 'map-host'],
                        'allow' => true,
                        'roles' => ['admin', 'user', 'student', 'guest'],
                    ],
                ],
            ]

        ];
    }


    public function actionVial()
    {

        $this->layout = 'defaults_main';
        $searchModel = new VialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 1);
        return $this->render('vial', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExport()
    {

        $this->layout = 'defaults_main';
        $searchModel = new VialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 2);
        return $this->render('export', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMapParasite()
    {
        $searchModel = new VialSearch(['pagination' => 100000000000000]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 2);

        return $this->render('map-parasite', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMapHost()
    {
        $searchModel = new HostSearch([
            'pagination' => 100000000000000,
            'isDeleted' => 0
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('map-host', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
