<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;


class TaxonomyIndex extends \yii\db\ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'taxonomy_index';
    }

    const INSERT = 'INSERT INTO taxonomy_index(ID, species, genus, family, _order, class, phylum, root) VALUES';

    public function reIndex()
    {
        ini_set('max_execution_time', 0);
        $oldLimit = ini_get( 'memory_limit');
        ini_set( 'memory_limit', '1024M' );
       
        $result =  $this->getTaxonomyTableAsArray();
        $sql = self::INSERT;

        $in = 0;
        $lastRow = end($result);

        $amounOfrestart = round($lastRow['id'] / 10000) + 1;

        Yii::$app->db->createCommand('DELETE FROM taxonomy_index WHERE 0=0')->execute();

        for ($i = 0; $i < $amounOfrestart; $i++) {

            for ($j = $in; $j < 10000 + $in; $j++) {
                if (isset($result[$j]['id'])) {
                    $sql = $sql . $this->one($result, $result[$j]['id']) . ',';
                }
            }
            $sql = substr($sql, 0, -1);

            if (strlen($sql) > 89) {
                Yii::$app->db->createCommand($sql)->execute();
            }

            $sql = self::INSERT;
            $in = $j;
        }        

        ini_set('max_execution_time', 180);
        ini_set( 'memory_limit', $oldLimit);
        Yii::$app->session->setFlash('success', "Indexing completed");        
    }

    protected function one($result, $id)
    {

        $one = $result[$id];
        $string = $id . ', ';
        $parent =  $one['id'];
        for ($i =  7; $i > 0; $i--) {
            $row =  $result[$parent];

            if ($i == $row['rank']) {
                $string = $string . $row['id'] . ', ';
                $parent = $row['parId'];
            } else {
                $string = $string . 'NULL, ';
            }
        }
        $string = substr($string, 0, -2);
        $string = '(' . $string . ')';

        return  $string;
    }

    public static function updateRecord($id)
    {

        $index = new TaxonomyIndex;
        $modelsArray = $index->getTaxonomyTableAsArray();

        Yii::$app->db->createCommand('DELETE FROM taxonomy_index WHERE id = ' . $id)->execute();
        $sql = self::INSERT . $index->one($modelsArray, $id);
        Yii::$app->db->createCommand($sql)->execute();
    }

    protected function getTaxonomyTableAsArray()
    {
        $models = Taxonomy::find()->asArray()->all();
        return ArrayHelper::index($models, 'id');
    }
}
