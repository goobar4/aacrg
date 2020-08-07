<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\User;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string $oldName
 * @property string $name
 * @property int $updatedBy
 * @property int $createdBy
 * @property int $createdAt
 * @property int $editedAt
 * @property string $parId
 * @property bool $isDeleted
 *
 * 
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image';
    }

    public function behaviors()
    {
        return [
            
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createdAt', 'editedAt'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['editedAt'],
                ],
                // если вместо метки времени UNIX используется datetime:
                // 'value' => new Expression('NOW()'),
                          
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'createdBy',
                'updatedByAttribute' => 'updatedBy',
            ],  
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['updatedBy', 'createdBy', 'createdAt', 'editedAt'], 'integer'],
            [['isDeleted'], 'boolean'],
            [['oldName', 'name', 'md5'], 'string', 'max' => 250],
            [['md5'],'unique', 'message' => 'File(s) already exists in the collection!'],
            [['parId'], 'string', 'max' => 30],
            [['parId'], 'exist', 'skipOnError' => true, 'targetClass' => Host::className(), 'targetAttribute' => ['parId' => 'occurrenceID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'oldName' => 'Old Name',
            'name' => 'Name',
            'updatedBy' => 'Updated By',
            'createdBy' => 'Created By',
            'createdAt' => 'Created At',
            'updatetAt' => 'Updatet At',
            'parId' => 'Par ID',
            'isDeleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[Par]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPar()
    {
        return $this->hasOne(Host::className(), ['occurrenceID' => 'parId']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'createdBy']);
    }
}
