<?php

namespace frontend\models;

use yii\data\SqlDataProvider;
use Yii;
use yii\helpers\VarDumper;


class TaxonomySearch extends yii\base\Model
{


    public $species;
    public $genus;
    public $family;
    public $order;
    public $class;
    public $phylum;



    public function rules()
    {
        return [

            [['species', 'genus', 'family', 'class', 'order', 'phylum'], 'trim']
        ];
    }


    public function search($params)
    {

        $this->load($params);

        $param = null;

        $sql = "SELECT
        t7.scientificName AS species, t6.scientificName AS genus,  t5.scientificName AS family, t4.scientificName AS 'order',
        t3.scientificName AS class, t2.scientificName AS phylum,
        t7.id AS sID, t6.id AS gID,  t5.id AS fID, t4.id AS oID, t3.id AS cID, t2.id AS pID
        FROM  taxonomy t1
        LEFT JOIN taxonomy t2 ON t1.id = t2.parId AND t2.rank = 2
        LEFT JOIN taxonomy t3 ON t2.id = t3.parId AND t3.rank = 3
        LEFT JOIN taxonomy t4 ON t3.id = t4.parId AND t4.rank = 4
        LEFT JOIN taxonomy t5 ON t4.id = t5.parId AND t5.rank = 5
        LEFT JOIN taxonomy t6 ON t5.id = t6.parId AND t6.rank = 6
        LEFT JOIN taxonomy t7 ON t6.id = t7.parId AND t7.rank = 7
        WHERE t2.scientificName IS NOT NULL
        AND t2.scientificName <> 'nohelminth' ";

        if ($this->species) {
            $param[':species'] = $this->species . '%';
            $sql = $sql . ' AND t7.scientificName like :species';
        }
        if ($this->genus) {
            $param[':genus'] = $this->genus . '%';
            $sql = $sql . ' AND t6.scientificName like :genus';
        }
        if ($this->family) {
            $param[':family'] = $this->family . '%';
            $sql = $sql . ' AND t5.scientificName like :family';
        }
        if ($this->order) {
            $param[':order'] = $this->order . '%';
            $sql = $sql . ' AND t4.scientificName like :order';
        }
        if ($this->class) {
            $param[':class'] = $this->class . '%';
            $sql = $sql . ' AND t3.scientificName like :class';
        }
        if ($this->phylum) {
            $param[':phylum'] = $this->phylum . '%';
            $sql = $sql . ' AND t2.scientificName like :phylum';
        }

        $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM ( '.$sql.' ) tab', $param )->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'params' => $param,
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => [
                    'species',
                    'genus',
                    'family',
                    'order',
                    'class',
                    'phylum',


                ],
            ],
        ]);
      //  VarDumper::dump( $count);

        
        return $dataProvider;
    }

    public static function findOne($rang, $search){
        
        $model = new TaxonomySearch;
        $param["TaxonomySearch"][$rang] = $search;
        $result = $model->search($param);
        return $result->models[0];           


    }
}
