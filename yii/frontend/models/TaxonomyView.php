<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "_taxonomy".
 *
 * @property string $species
 * @property string|null $genus
 * @property string|null $family
 * @property string|null $order
 * @property string|null $class
 * @property string|null $phylum
 * @property int $sID
 * @property int|null $gID
 * @property int|null $fID
 * @property int|null $oID
 * @property int|null $cID
 * @property int|null $pID
 */
class TaxonomyView extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '_taxonomy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['species'], 'required'],
            [['sID', 'gID', 'fID', 'oID', 'cID', 'pID'], 'integer'],
            [['species', 'genus', 'family', 'order', 'class', 'phylum'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'species' => 'Species',
            'genus' => 'Genus',
            'family' => 'Family',
            'order' => 'Order',
            'class' => 'Class',
            'phylum' => 'Phylum',
            'sID' => 'S ID',
            'gID' => 'G ID',
            'fID' => 'F ID',
            'oID' => 'O ID',
            'cID' => 'C ID',
            'pID' => 'P ID',
        ];
    }
}
