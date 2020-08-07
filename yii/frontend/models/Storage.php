<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "storage".
 *
 * @property int $id
 * @property string $item1
 * @property string $item2
 * @property string $item3
 * @property string $item4
 * @property string $item5
 * @property string $item6
 * @property string $item7
 *
 * @property Container $id0
 */
class Storage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'storage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item1', 'item2', 'item3', 'item4', 'item5', 'item6', 'item7'], 'string', 'max' => 255],
          
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item1' => 'Item1',
            'item2' => 'Item2',
            'item3' => 'Item3',
            'item4' => 'Item4',
            'item5' => 'Item5',
            'item6' => 'Item6',
            'item7' => 'Item7',
        ];
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Container::className(), ['storage' => 'id']);
    }
}
