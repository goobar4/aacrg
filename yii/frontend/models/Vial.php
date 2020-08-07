<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "_vialsearch".
 *
 * @property string $occurrenceID
 * @property string|null $scientificName
 * @property string|null $genus
 * @property string|null $family
 * @property string|null $order
 * @property string|null $class
 * @property string|null $phylum
 * @property string|null $sexH
 * @property string|null $ageH
 * @property string|null $localityName
 * @property string|null $province
 * @property string|null $country
 * @property int|null $decimalLatitude
 * @property int|null $decimalLongitude
 * @property bool|null $isEmpty
 * @property string|null $occurenceDate
 * @property string|null $containerId
 * @property string|null $prType
 * @property int|null $containerStatus
 * @property int|null $id
 * @property string|null $sName
 * @property string|null $sGenus
 * @property string|null $sFamily
 * @property string|null $sOrder
 * @property string|null $sClass
 * @property string|null $sPhylum
 * @property float|null $SUM(s.individualCount)
 */
class Vial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '_vialsearch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['occurrenceID'], 'required'],
            [['decimalLatitude', 'decimalLongitude', 'containerStatus', 'id'], 'integer'],
            [['isEmpty'], 'boolean'],
            [['occurenceDate'], 'safe'],
            [['SUM(s.individualCount)'], 'number'],
            [['occurrenceID'], 'string', 'max' => 30],
            [['scientificName', 'genus', 'family', 'order', 'class', 'phylum', 'sexH', 'ageH', 'localityName', 'province', 'country', 'containerId', 'prType', 'sName', 'sGenus', 'sFamily', 'sOrder', 'sClass', 'sPhylum'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'occurrenceID' => 'Occurrence ID',
            'scientificName' => 'Scientific Name',
            'genus' => 'Genus',
            'family' => 'Family',
            'order' => 'Order',
            'class' => 'Class',
            'phylum' => 'Phylum',
            'sexH' => 'Sex H',
            'ageH' => 'Age H',
            'localityName' => 'Locality Name',
            'province' => 'Province',
            'country' => 'Country',
            'decimalLatitude' => 'Decimal Latitude',
            'decimalLongitude' => 'Decimal Longitude',
            'isEmpty' => 'Is Empty',
            'occurenceDate' => 'Occurence Date',
            'containerId' => 'Container ID',
            'prType' => 'Pr Type',
            'containerStatus' => 'Container Status',
            'id' => 'ID',
            'sName' => 'S Name',
            'sGenus' => 'S Genus',
            'sFamily' => 'S Family',
            'sOrder' => 'S Order',
            'sClass' => 'S Class',
            'sPhylum' => 'S Phylum',
            'SUM(s.individualCount)' => 'Individual Count',
        ];
    }
}
