<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "service".
 *
 * @property int $id
 * @property string $value
 * @property string $target
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'target', '_table'], 'required'],
            [['id'], 'integer'],
            [['value', 'target'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'target' => 'Target',
            '_table' => 'Table',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        //restrict changing of sensitive fields

        if ($this->id == 21 or $this->id == 22 or $this->id == 17 or $this->id == 29) {
            return  Yii::$app->session->setFlash('error', 'This record can not be changed.');
        }


        return true;
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if($this->id == 21 or $this->id == 22 or $this->id == 17 or $this->id == 29){
            return Yii::$app->session->setFlash('error', 'This record can not be deleted.');
        }
        return true;
    }
}
