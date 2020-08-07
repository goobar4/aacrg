<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "taxonomy".
 *
 * @property int $id
 * @property string $scientificName
 * @property string $parId
 * @property string $rank

 *
 * @property Host[] $hosts
 * @property Sample[] $samples
 */
class Taxonomy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'taxonomy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['scientificName'], 'required'],
            [['scientificName'], 'string', 'max' => 255],
            [['scientificName'], 'unique'],
            [['parId','rank'],'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'scientificName' => 'Scientific Name',
            'parId' => 'parId',
            'rank' => 'rank',
           
        ];
    }


    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {      
            return false;
        }

        //set rank
        if (isset($this->oldAttributes["parId"])) {

            if ((int) $this->dirtyAttributes["parId"] !== $this->oldAttributes["parId"]) {
                if (!$this->find()->where(['parId' => $this->id])->count()) {
                    //rewrite rank on base of parent rank
                    $rank = $this->find()->where(['id' => $this->parId])->one();
                    $this->rank = $rank->rank + 1;
                } else {
                    return Yii::$app->session->setFlash('error', 'This record has children.');                }
            }
        } else {
            //create rank of record on base of rank of parent
            $rank = $this->find()->where(['id' => $this->parId])->one();
            $this->rank = $rank->rank + 1;
        }
       
        //restrict changing of sensitive fields

        if ($this->id == 7 or $this->id == 1) {
           return  Yii::$app->session->setFlash('error', 'This record can not be changed.');
        }

        return true;
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        //restrict deletion of sensitive fields

        if($this->id == 7 or $this->id == 1){
            return Yii::$app->session->setFlash('error', 'This record can not be deleted.');
        }
        return true;
    }

   
    /**
     * Gets query for [[Hosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHosts()
    {
        return $this->hasMany(Host::className(), ['scientificName' => 'id']);
    }

    /**
     * Gets query for [[Samples]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSamples()
    {
        return $this->hasMany(Sample::className(), ['scientificName' => 'id']);
    }

    public function getParId0()
    {
        return $this->hasone(Taxonomy::className(), ['id' => 'parId']);
    }

}
