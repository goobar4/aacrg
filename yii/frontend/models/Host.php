<?php

namespace frontend\models;

use Yii;
use common\models\User;
use frontend\models\Container;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use nhkey\arh\ActiveRecordHistoryBehavior;

/**
 * This is the model class for table "host".
 *
 * @property string $occurrenceID
 * @property int $sciName
 * @property string|null $sex
 * @property string|null $age
 * @property string|null $natureOfRecord
 * @property int $placeName
 * @property string $occurenceDate
 * @property string $sAIAB_Catalog_Number
 * @property int|null $idConfidence
 * @property string $comments
 * @property int $determiner
 * @property int $createdBy
 * @property int $updatedBy
 * @property int $createdAt
 * @property int $editedAt
 * @property int|null $isDeleted
 *
 * @property Container[] $containers
 * @property Locality $placeName0
 * @property Taxonomy $sciName0
 * @property User $determiner0
 * @property User $catalogerPerson0
 */
class Host extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'host';
    }

    /** 
     *add unixstamp in field 'reatedAt', 'editedAt' before changing of the fields
     */
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
            [
                'class' => ActiveRecordHistoryBehavior::className(),
                'manager' => '\nhkey\arh\managers\DBManager',
                'ignoreFields' => ['createdBy', 'updatedBy', 'createdAt', 'editedAt'],
                'managerOptions' => [
                    'tableName' => 'modelhistory',

                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['occurrenceID', 'sciName', 'placeName', 'occurenceDate', 'isEmpty','determiner'],  'required'],
            [['sciName', 'placeName', 'updatedBy', 'createdAt', 'idConfidence'], 'integer'],
            [['isEmpty', 'isDeleted'], 'integer', 'min' => 0, 'max' => 1],
            [['idConfidence'], 'integer', 'min' => 0, 'max' => 100],
            [['occurenceDate', 'idConfidence'], 'trim'],
            [['occurrenceID'], 'string', 'max' => 30],
            [['sex', 'age', 'natureOfRecord'], 'string', 'max' => 20],
            [['sAIAB_Catalog_Number'], 'string', 'max' => 20],
            [['comments'], 'string', 'max' => 2000],
            [['occurrenceID'], 'unique'],
            [['placeName'], 'exist', 'skipOnError' => true, 'targetClass' => Locality::className(), 'targetAttribute' => ['placeName' => 'id']],
            [['sciName'], 'exist', 'skipOnError' => true, 'targetClass' => Taxonomy::className(), 'targetAttribute' => ['sciName' => 'id']],
            [['determiner'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['determiner' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'occurrenceID' => 'organismID',
            'sciName' => 'organismName',
            'sex' => 'sex',
            'age' => 'lifeStage',
            'natureOfRecord' => 'basisOfRecord',
            'placeName' => 'locality',
            'occurenceDate' => 'eventDate',
            'sAIAB_Catalog_Number' => 'SAIAB Number',
            'idConfidence' => 'Id Confidence',
            'determiner' => 'identifiedBy',
            'comments' => 'organismRemarks',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
            'createdAt' => 'Created At',
            'editedAt' => 'Edited At',
            'isDeleted' => 'Is Deleted',
            'isEmpty' => 'Is Empty',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (!parent::afterSave($insert, $changedAttributes)) {

            //set isDeleted status for Container and Sample which are related with Host model

            $flag = Container::find()->where(['prepType' => 29])->andwhere(['parId' => $this->occurrenceID])->count();
            $flag2 = Container::find()->where(['parId' => $this->occurrenceID])->count();

            if ($this->isEmpty == 1) {
                //check existing any child

                if ($flag == 0 && $flag2 == 0) {

                    $model = new Container();
                    $model->EmptyTube($this->occurrenceID);
                } elseif ($flag2 > 0 and $flag == 0) {
                    Yii::$app->session->setFlash('error', 'The status \'isEmpty\' can not be changed due record has samples.');
                    $this->isEmpty = 0;
                    $this->save();
                }
            } elseif ($this->isEmpty == 0 and $flag == 1) {

               $model = Container::findOne(['parId'=>$this->occurrenceID]);
               $model->delete();                
            }

            //set isDeleted status in Image model according to isDeleted status in Host model

            $images = Image::find()->where(['parId' => $this->occurrenceID]);
            if ($images->count() > 0 and $this->isDeleted == 0) {
                foreach ($images->all() as $image) {
                    $image->isDeleted = 0;
                    $image->save();
                }
            } elseif ($images->count() > 0 and $this->isDeleted == 1) {
                foreach ($images->all() as $image) {
                    $image->isDeleted = 1;
                    $image->save();
                }
            }
        }


        return true;
    }



    /**
     * Gets query for [[Containers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContainers()
    {
        return $this->hasMany(Container::className(), ['parId' => 'occurrenceID']);
    }

    /**
     * Gets query for [[PlaceName0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlaceName0()
    {
        return $this->hasOne(Locality::className(), ['id' => 'placeName']);
    }

    /**
     * Gets query for [[SciName0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSciName0()
    {
        return $this->hasOne(Taxonomy::className(), ['id' => 'sciName']);
    }

    /**
     * Gets query for [[Determiner0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeterminer0()
    {
        return $this->hasOne(User::className(), ['id' => 'determiner']);
    }

    public function getcontainerType0()
    {
        return $this->hasOne(Service::className(), ['id' => 'containerType']);
    }
    public function getSexValue()
    {
        return $this->hasOne(Service::className(), ['id' => 'sex']);
    }
    public function getAgeValue()
    {
        return $this->hasOne(Service::className(), ['id' => 'age']);
    }
    public function getNatureValue()
    {
        return $this->hasOne(Service::className(), ['id' => 'natureOfRecord']);
    }
    
   /* public function haRemovedChild($id)
    {
        $children = Container::find()->where(['parId' => $id]);
        if ($children->count() > 0) {
            $i = 0;
            foreach ($children->all() as $chid) {
                if ($chid['isDeleted'] == 1) {
                    $i = $i + 1;
                } elseif ($chid['prepType'] == 'nohelminth') {
                    return null;
                }
            }
            $i = $children->count() - $i;
            return ($i == 0) ? true : false;
        } else {
            return null;
        }
    }*/

    public function hasDeletedChildren(){

        return (int) Container::find()->where(['parId' => $this->occurrenceID])->andWhere(['isDeleted'=>1])
        ->andWhere(['<>','prepType',29])->count(); 
       
    }

    //return amount of children
    
    public function hasChildren(){

        return (int) Container::find()->where(['parId' => $this->occurrenceID])->andWhere(['<>','prepType',29])->count();
         
    }

    
    
}
