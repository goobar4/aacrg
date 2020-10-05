<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use nhkey\arh\ActiveRecordHistoryBehavior;

/**
 * This is the model class for table "sample".
 *
 * @property int $id
 * @property int $scienName
 * @property int|null $individualCount
 * @property string $parId
 * @property bool $isDeleted
 * @property int|null $basisOfRecord
 * @property int|null $typeStatus
 * @property string|null $remarks
 * @property int $identifiedBy
 * @property string|null $qualifier
 * @property int|null $confidence
 * @property int|null $createdBy
 * @property int|null $createdAt
 * @property int|null $editedAt
 * @property int|null $updatedBy
 *
 * @property Container $par
 * @property Taxonomy $scienName0
 * @property User $identifiedBy0
 */
class Sample extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sample';
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
                'ignoreFields' => ['createdBy', 'updatedBy','createdAt','editedAt'],
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
            [['scienName', 'identifiedBy'], 'required'],
            [['scienName', 'site', 'individualCount', 'basisOfRecord', 'typeStatus', 'identifiedBy', 'confidence', 'createdBy', 'createdAt', 'editedAt', 'updatedBy'], 'integer'],
            [['isDeleted'], 'boolean'],
            [['confidence'],'integer','min'=>0,'max'=>100],
            [['parId', 'qualifier'], 'string', 'max' => 30],
            [['remarks'], 'string', 'max' => 2000],
            [['parId'], 'exist', 'skipOnError' => true, 'targetClass' => Container::className(), 'targetAttribute' => ['parId' => 'containerId']],
            [['scienName'], 'exist', 'skipOnError' => true, 'targetClass' => Taxonomy::className(), 'targetAttribute' => ['scienName' => 'id']],
            [['identifiedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['identifiedBy' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'scienName' => 'Scien Name',
            'individualCount' => 'Individual Count',
            'parId' => 'Container id',
            'isDeleted' => 'Is Deleted',
            'basisOfRecord' => 'Basis Of Record',
            'typeStatus' => 'Type Status',
            'remarks' => 'Remarks',
            'identifiedBy' => 'Identified By',
            'qualifier' => 'Qualifier',
            'confidence' => 'Confidence',
            'createdBy' => 'Created By',
            'createdAt' => 'Created At',
            'editedAt' => 'Edited At',
            'updatedBy' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Par]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPar()
    {
        return $this->hasOne(Container::className(), ['containerId' => 'parId']);
    }
    public function getCollection0()
    {
        return $this->hasMany(Collection::className(), ['sample_id' => 'id']);       
    }

    /**
     * Gets query for [[ScienName0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getScienName0()
    {
        return $this->hasOne(Taxonomy::className(), ['id' => 'scienName']);
    }
    public function getbasisOfRecord0()
    {
        return $this->hasOne(Service::className(), ['id' => 'basisOfRecord']);
    }
    public function getTypeStatus0()
    {
        return $this->hasOne(Service::className(), ['id' => 'typeStatus']);
    }
    public function getSite0()
    {
        return $this->hasOne(Service::className(), ['id' => 'site']);
    }
    
    /**
     * Gets query for [[IdentifiedBy0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdentifiedBy0()
    {
        return $this->hasOne(User::className(), ['id' => 'identifiedBy']);
    }

        //change field isDeleted on 1;

        public function softDelete(){

            $this->isDeleted = 1;
            $this->save(false);
            return true;
            
         }     
          
        // decide soft or permanent delation
     
         public function delation()
         {
             if ($this->isDeleted == 1) {
     
                 return $this->delete();
     
             } elseif ($this->isDeleted == 0) {
                
                 return  $this->softDelete();
             }
         }
     
         //restore after soft delation
     
         public function restore(){
             
             if($this->isDeleted == 1){
                 $this->isDeleted = 0;
                 $this->save(false);
                 return true;
             } else {
                 return false;
             }
     
         }
     
}
