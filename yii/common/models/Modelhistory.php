<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "modelhistory".
 *
 * @property int $id
 * @property string $date
 * @property string $table
 * @property string $field_name
 * @property string $field_id
 * @property string|null $old_value
 * @property string|null $new_value
 * @property int $type
 * @property string $user_id
 */
class Modelhistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'modelhistory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'table', 'field_name', 'field_id', 'type', 'user_id'], 'required'],
            [['date'], 'safe'],
            [['old_value', 'new_value'], 'string'],
            [['type'], 'integer'],
            [['table', 'field_name', 'field_id', 'user_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'table' => 'Table',
            'field_name' => 'Field Name',
            'field_id' => 'Field ID',
            'old_value' => 'Old Value',
            'new_value' => 'New Value',
            'type' => 'Type',
            'user_id' => 'User ID',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
