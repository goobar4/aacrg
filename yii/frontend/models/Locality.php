<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "locality".
 *
 * @property int $id
 * @property string $localityName
 * @property int $province
 * @property int $country
 * @property int $decimalLatitude
 * @property int $decimalLongitude
 * @property string $typeHabitate
 * @property int island
 * @property string cordMethod
 * @property string datum
 * @property int elevation
 * 
 */
class Locality extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'locality';
    }

   

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['localityName', 'province', 'country', 'decimalLatitude', 'decimalLongitude'], 'required'],
            [['decimalLatitude', 'decimalLongitude', 'province', 'country', 'island', 'elevation'], 'integer'],
            [['localityName', 'typeHabitate'], 'string', 'max' => 255],
            [['cordMethod', 'datum'], 'string', 'max' => 255],
            [['localityName'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'localityName' => 'Locality Name',
            'province' => 'Province',
            'country' => 'Country',
            'decimalLatitude' => 'Decimal Latitude',
            'decimalLongitude' => 'Decimal Longitude',
            'typeHabitate' => 'Type Habitate',
            'island'=>'Island'
        ];
    }

   
    public function getProvince0()
    {
        return $this->hasOne(Service::className(), ['id'=>'province']);
    }

    public function getCountry0()
    {
        return $this->hasOne(Service::className(), ['id' =>'country']);
    }

    public function getIsland0()
    {
        return $this->hasOne(Service::className(), ['id'=> 'island' ]);
    }


}
