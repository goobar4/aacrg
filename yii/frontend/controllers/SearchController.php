<?php

namespace frontend\controllers;

use Yii;
use frontend\models\VialSearch;
use frontend\models\TaxonomySearch;
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
                        'actions' => ['export','index'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['vial'],
                        'allow' => true,
                        'roles' => ['admin','user', 'student', 'guest'],
                    ],
                ],
            ]

        ];
    }
    
 //simple search
     
    public function actionIndex()
    {
        $searchModel = new TaxonomySearch();
        //show only 'undeleted' records
        $param = Yii::$app->request->queryParams;
               $dataProvider = $searchModel->search($param);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
       
       
       
       
       
       
      /*  if (Yii::$app->request->get()){
            $q=Yii::$app->request->get()['search'];
            $result = Yii::$app->db->createCommand('
            SELECT {{h.occurrenceID}} AS id, {{h.occurrenceID}} AS text, "host" as tablename FROM {{host}} {{h}}
            LEFT JOIN {{taxonomy}} {{t}} ON {{h.sciName}} = {{t.id}}
            WHERE h.occurrenceID LIKE :id                   
            UNION
            SELECT {{h.occurrenceID}}, {{t.scientificName}}, "host" as tablename FROM {{host}} {{h}}
            LEFT JOIN {{taxonomy}} {{t}} ON {{h.sciName}} = {{t.id}}
            WHERE t.scientificName LIKE :id
            UNION 
            SELECT {{c.parId}}, {{c.containerId}}, "container" as tablename FROM {{container}} {{c}}
            LEFT JOIN {{sample}} {{s}} ON {{c.containerId}} = {{s.parId}}
            LEFT JOIN {{taxonomy}} {{t}} ON {{s.scienName}} = {{t.id}}
            WHERE c.containerId LIKE :id
            UNION
            SELECT {{c.parId}}, {{t.scientificName}}, "container" as tablename FROM {{container}} {{c}}
            LEFT JOIN {{sample}} {{s}} ON {{c.containerId}} = {{s.parId}}
            LEFT JOIN {{taxonomy}} {{t}} ON {{s.scienName}} = {{t.id}}
            WHERE t.scientificName LIKE :id
            ')
           ->bindValue(':id', $q)
            ->queryAll();
           
            If(count($result)===1){
                
                return $this->redirect([$result[0]['tablename'].'/view', 'id'=>$result[0]['text']]);
            //var_dump($result[0]['table']);
            //die();
            } else {
                return $this->render('index');
            }
            
             }
        return $this->render('index');*/
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


//form query for simple search
    
    public function actionSimple($q = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $posts = Yii::$app->db->createCommand('
            SELECT {{h.occurrenceID}} AS text, {{h.occurrenceID}} AS id FROM {{host}} {{h}}
            LEFT JOIN {{taxonomy}} {{t}} ON {{h.sciName}} = {{t.id}}
            WHERE h.occurrenceID LIKE :id
            GROUP by h.occurrenceID           
            UNION
            SELECT {{t.scientificName}}, {{t.scientificName}} FROM {{host}} {{h}}
            LEFT JOIN {{taxonomy}} {{t}} ON {{h.sciName}} = {{t.id}}
            WHERE t.scientificName LIKE :id
            GROUP by t.scientificName
            UNION 
            SELECT {{c.containerId}}, {{c.containerId}} FROM {{container}} {{c}}
            LEFT JOIN {{sample}} {{s}} ON {{c.containerId}} = {{s.parId}}
            LEFT JOIN {{taxonomy}} {{t}} ON {{s.scienName}} = {{t.id}}
            WHERE c.containerId LIKE :id
            GROUP by c.containerId
            UNION
            SELECT {{t.scientificName}}, {{t.scientificName}} FROM {{container}} {{c}}
            LEFT JOIN {{sample}} {{s}} ON {{c.containerId}} = {{s.parId}}
            LEFT JOIN {{taxonomy}} {{t}} ON {{s.scienName}} = {{t.id}}
            WHERE t.scientificName LIKE :id
            GROUP BY t.scientificName
           ')
           ->bindValue(':id', $q.'%')
            ->queryAll();
            $out['results'] = array_values($posts);

        return $out;

    }

}
