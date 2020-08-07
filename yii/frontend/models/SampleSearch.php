<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\SqlDataProvider;
use Yii;
use yii\data\ActiveDataProvider;
use frontend\models\Sample;



/**
 * SampleSearch represents the model behind the search form of `frontend\models\Sample`.
 */
class SampleSearch extends Model
{
    public $isDeleted;
    public $species;
    public $site;
    public $indCount;
    public $collection;
    public $container;




    public function rules()
    {
        return [
            [['site', 'species', 'indCount', 'parId', 'collection', 'container'], 'trim'],
            [['isDeleted'], 'boolean']
        ];
    }

    public function search($params, $del)
    {

        $this->load($params);

        $param = null;
        

        $sql = "SELECT s.id AS ident, t.scientificName AS species, se.VALUE AS sex, s.parId AS 'container',
        s.individualCount AS 'indCount', s.isDeleted, c.id, c.user_id AS 'collection'  FROM sample s
        LEFT JOIN taxonomy t ON s.scienName=t.id
        LEFT JOIN service se ON s.site=se.id
        LEFT JOIN collection c ON IF(c.user_id = :user, c.sample_id = s.id, '')
        WHERE t.scientificName<>'nohelminth'";

        $param[':user'] = Yii::$app->user->id;

        if ($this->species) {
            $param[':species'] = $this->species . '%';
            $sql = $sql . ' AND t.scientificName like :species';
        }
        if ($this->site) {
            $param[':sex'] = $this->site . '%';
            $sql = $sql . ' AND se.value like :site';
        }
        if ($this->indCount) {
            $param[':indCount'] = $this->indCount;
            $sql = $sql . ' AND s.individualCount = :indCount';
        }
        if ($this->collection) {
            $sql = $sql . ' AND c.id >0';
        } elseif ($this->collection == '0') {
            $sql = $sql . ' AND c.id is null';
        }
        if ($this->container) {
            $param[':container'] = $this->container . '%';
            $sql = $sql . ' AND s.parId like :container';
        }

        $sql = $sql . ' AND s.isDeleted ='.$del;

        //var_dump($this->collection);
        // die();

        // $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM ( '.$sql.' ) tab', $param )->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'params' => $param,
            //'totalCount' => $count,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => [
                    'sex',
                    'indCount',
                    'collection',



                ],
            ],
        ]);
        //  VarDumper::dump( $count);


        return $dataProvider;
    }
}
