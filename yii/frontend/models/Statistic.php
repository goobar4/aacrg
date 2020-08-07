<?php

namespace frontend\models;

use Yii;

class Statistic extends yii\base\Model
{

    public static function count()
    {
        return [
            'host'=>Yii::$app->db->createCommand('SELECT COUNT(occurrenceID) FROM host WHERE isDeleted=0')->queryScalar(),
            'container'=> Yii::$app->db->createCommand('SELECT COUNT(containerId) FROM container WHERE prepType != 29 and isDeleted=0')->queryScalar(),
        ];       
    }
}
