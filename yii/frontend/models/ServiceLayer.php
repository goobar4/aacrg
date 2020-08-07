<?php

namespace frontend\models;


use yii\base\Model;
use common\models\User;
use yii\db\Query;
use Yii;

class ServiceLayer extends Model
{
    public static function getHistoryValue($dataProvider)
    {

        foreach ($dataProvider->models as $obj) {

            $search_old = Service::find()->where(['id' => $obj->old_value])
                ->andWhere(['_table' => $obj->table])
                ->andWhere(['target' => $obj->field_name])
                ->one();

            if ($search_old) {
                $obj->old_value = $search_old->value;
            }

            $search_new = Service::find()->where(['id' => $obj->new_value])
                ->andWhere(['_table' => $obj->table])
                ->andWhere(['target' => $obj->field_name])
                ->one();

            if ($search_new) {
                $obj->new_value = $search_new->value;
            }

            if ($obj->field_name == 'sciName' or $obj->field_name == 'scienName') {
                $obj->old_value = Taxonomy::findOne($obj->old_value)->scientificName;
                $obj->new_value = Taxonomy::findOne($obj->new_value)->scientificName;
            }

            if ($obj->field_name == 'placeName') {
                $obj->old_value = Locality::findOne($obj->old_value)->localityName;
                $obj->new_value = Locality::findOne($obj->new_value)->localityName;
            }
            if ($obj->field_name == 'determiner' or $obj->field_name == 'identifiedBy') {
                $obj->old_value = User::findOne($obj->old_value)->surname;
                $obj->new_value = User::findOne($obj->new_value)->surname;
            }

            if (!$obj->old_value) {
                $obj->old_value = '';
            }
            if (!$obj->new_value) {
                $obj->new_value = '';
            }
        }

        return $dataProvider;
    }

    public static function setHistoryParam($request, $table, $id)
    {
        $param = $request;
        $param["ModelhistorySearch"]["field_id"] = $id;
        $param["ModelhistorySearch"]["table"] = $table;
        $param["r"] = "modelhistory";
        return $param;
    }

    public static function getSelectList($q, $table, $field)
    {
        $out = ['results' => ['id' => '', 'text' => '']];     
        if (!is_null($q)) {
            $query = new Query;
            
            $query->select('id, '.$field.' AS text')
                ->from($table)
                ->where(['like', $field, $q]);
                $table == 'taxonomy' ? $query->andWhere(['<>', $field, 'nohelminth']) : null;             
                $query->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } 
        return $out;
    }

    //write values of GridView filter in session
    //$param - request from page with GridView
    //$search - name of search model
    public static function setSession($param, $search)
    {
        $session =  Yii::$app->session;       
       
        //check if session is opened
        if (!$session->isActive) {
            $session->open();
        }
        
        if(!isset($param[$search])){
            $param[$search] = null;
        }

        //reset grid
        if (isset($param['reset'])) {
           $param[$search] == null;
           $param['reset'] == null;
           $session->set($search, $param[$search]);
          //return $param;
        }
              
        if ($session->has($search) == false) {
            $session->set($search, $param[$search]);
        }
        //if data from the request is not equal to data from the session then write data from request to the session
        if (($session[$search] !== $param[$search]) and $param[$search] !== null) {
            $session->set($search, $param[$search]);
        }
        // if $param is false write data from the session
        if (!$param[$search]) {
            $param[$search] = $session[$search];
        }
    
    return $param;
        
    }
}
