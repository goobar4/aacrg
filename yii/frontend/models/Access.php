<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "access".
 *
 * @property int $id
 * @property int $taxon_id
 * @property int $user_id
 *
 * @property Taxonomy $taxon
 * @property User $user
 */
class Access extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['taxon_id', 'user_id'], 'required'],
            [['multi'], 'safe'],
            [['id', 'taxon_id', 'user_id'], 'integer'],
            [['taxon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Taxonomy::className(), 'targetAttribute' => ['taxon_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'taxon_id' => 'Taxon ID',
            'user_id' => 'User ID',
        ];
    }
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {          
            return false;
        }

     $search = $this->find()->where(['taxon_id' => $this->taxon_id])->andWhere(['user_id' => $this->user_id])->count();

        if ($search) {
            return Yii::$app->session->setFlash('error', 'The user has already has this permission.');
        }
        return true;
}

    /**
     * Gets query for [[Taxon]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaxon()
    {
        return $this->hasOne(Taxonomy::className(), ['id' => 'taxon_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
