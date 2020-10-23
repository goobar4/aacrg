<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use nhkey\arh\ActiveRecordHistoryBehavior;


/**
 * This is the model class for table "container".
 *
 * @property string $containerId
 * @property string|null $prepType
 * @property string|null $fixative
 * @property bool $containerStatus
 * @property string|null $containerType
 * @property string|null $parId
 * @property int|null $isDeleted
 * @property int|null $storage
 * @property string|null $date
 * @property string|null $comment
 * @property int|null $createdBy
 * @property int|null $updatedBy
 * @property int|null $createdAt
 * @property int|null $editedAt
 *
 * @property Host $par
 * @property Sample[] $samples
 * @property Storage $storage0
 */
class Container extends \yii\db\ActiveRecord
{
    
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE= 'update';
   
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['containerId', 'prepType', 'fixative','containerStatus', 'containerType', 'storage','date','comment',
            'createdBy', 'updatedBy', 'createdAt', 'editedAt', 'parId', 'isDeleted'],
            self::SCENARIO_UPDATE => ['prepType', 'fixative','containerStatus', 'containerType', 'storage','date','comment',
            'createdBy', 'updatedBy', 'createdAt', 'editedAt', 'parId', 'isDeleted'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'container';
    }

    //

    public function behaviors()
    {
        return [
            
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createdAt', 'editedAt'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['editedAt'],
                ],                                         
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'createdBy',
                'updatedByAttribute' => 'updatedBy',
            ],
            [
                'class' => ActiveRecordHistoryBehavior::className(),
                'manager' => '\nhkey\arh\managers\DBManager',
                'ignoreFields' => ['createdBy', 'updatedBy','createdAt','editedAt','containerId'],
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
            [['containerId','prepType','containerType'], 'required'],
            [['containerStatus','isDeleted'], 'boolean'],
            [['storage', 'createdBy', 'updatedBy', 'createdAt', 'editedAt'], 'integer'],
            [['date'], 'date', 'format'=>'y-m-d'],
            [['containerId', 'prepType', 'fixative', 'containerType', 'parId'], 'string', 'max' => 255],
            [['comment'], 'string', 'max' => 2000],
            [['containerId'], 'unique'],
            [['parId'], 'exist', 'skipOnError' => true, 'targetClass' => Host::className(), 'targetAttribute' => ['parId' => 'occurrenceID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'containerId' => 'Container ID',
            'prepType' => 'PrepType',
            'fixative' => 'preparations',
            'containerStatus' => 'InColection',
            'containerType' => 'Container Type',
            'parId' => 'Par ID',
            'isDeleted' => 'Is Deleted',
            'storage' => 'Storage',
            'date' => 'Date',
            'comment' => 'occurrenceRemarks',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
            'createdAt' => 'Created At',
            'editedAt' => 'Edited At',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        //restrict to create tissue-container
        if ($this->prepType == '21' and $this->hasChildren() > 0 and $this->oldAttributes['prepType'] !== '21') {

            $this->attributes = $this->oldAttributes;
            return Yii::$app->session->setFlash('error', 'The prepType = tissue can be only in containers which have 0 sample');
        }

        return true;
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        if (!parent::afterSave($insert, $changedAttributes)) {
            
            isset($this->oldAttributes['prepType']) ? $this->oldAttributes['prepType'] : $this->oldAttributes['prepType'] = null;
            isset($changedAttributes['prepType']) ? $changedAttributes['prepType'] : $changedAttributes['prepType'] = null;

            if(($this->prepType =='21') and ($this->hasChildren()==0)){
                $sample = Sample::className();
                $sample = new $sample;
                $sample->scienName = 7;
                $sample->isDeleted = 0;
                $sample->identifiedBy = Yii::$app->user->id;
                $sample->parId = $this->containerId;
                $sample->save(false);
            } elseif (($this->hasChildren()==1 and $this->oldAttributes['prepType'] !== '21') and $changedAttributes['prepType'] =='21' and !is_null($changedAttributes['prepType'])){           
                $var = Sample::className();
                $model_sample = new $var;
                $model_sample = Sample::findOne(['parId'=> $this->containerId]);
                $model_sample->delete();            
            }
           
           
            return false;
        }
       
        
        return true;
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }
        $model = Sample::findOne(['parId'=>$this->containerId]);

        if($model){
        $model->delete();
        }
        
        return true;
    }


    public function getContainerType0()
    {
        return $this->hasOne(Service::className(), ['id' => 'containerType']);
    }

    public function getPrepType0()
    {
        return $this->hasOne(Service::className(), ['id' => 'prepType']);
    }
    
    public function getFixative0()
    {
        return $this->hasOne(Service::className(), ['id' => 'fixative']);
    }

    public function getStorage0()
    {
        return $this->hasOne(Storage::className(), ['id' => 'storage']);
    }
    /**
     * Gets query for [[Par]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getPar()
    {
        return $this->hasOne(Host::className(), ['occurrenceID' => 'parId']);
    }

    /**
     * Gets query for [[Samples]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getSamples()
    {
        return $this->hasMany(Sample::className(), ['parId' => 'containerId']);
    }


    
    //change field isDeleted on 1;

    public function softDelete(){

       $this->isDeleted = 1;
       $this->scenario = 'update';
       $this->save(false);
       return true;
       
    }

   //return amount of children
    
    public function hasChildren(){

        $children = Sample::find()->where(['parId' => $this->containerId]);
        return (int) $children->count();
    }
    
    //return amount of deleted children

    public function hasDeletedChildren(){

        $children = Sample::find()->where(['parId' => $this->containerId])->andWhere(['isDeleted'=>1]);
        return $children->count();

    }

    //return amount of tissue sample

    public function hasTissue(){

        $children = Sample::find()->where(['scienName' => 7])->andWhere(['parId' => $this->containerId]);
        return (int) $children->count();

    }


    // decide soft or permanent delation

    public function delation()
    {
        if ($this->isDeleted == 1) {

            if ($this->hasChildren() == 0 or $this->prepType == '21') {
                
                if (Yii::$app->user->can('canAdmin') || $this->getRole()=='user') {
                    return $this->delete();
                } else {
                    throw new \yii\web\ForbiddenHttpException('You have not right to delete this record.');
                }
            } else {
                return false;
            }
        } elseif ($this->isDeleted == 0) {

            return (($this->hasDeletedChildren() == ($this->hasChildren() - $this->hasTissue())) or ($this->hasChildren() == 0)) ?  $this->softDelete() : false;
        }
    }

    //restore after soft delation

    

    public function restore(){
        
        if($this->hasDeletedChildren() == 0 or $this->prepType == 21){
            $this->isDeleted = 0;
            $this->scenario = 'update';
            $this->save(false);
            return true;
        } else {
            return false;
        }

    }

    //create empty tube

    public function EmptyTube($id) {

       if (Container::find()->where(['parId'=>$id])->andWhere(['prepType'=>'nohelminth'])->count()==0 ){
        $this->parId =$id;
        $this->prepType = 29;
        $this->containerId = $id.'nohelminth';
        $this->scenario = 'create';        
        $this->save(false);
        $model =  Sample::className();
        $model = new $model;
        $model -> isDeleted  = 0;
        $model->scienName = 7;
        $model->identifiedBy = Yii::$app->user->id;
        $model->parId = $this->containerId;
        $model->save(false);
        return true;
        }else{
           return false;
       }
    }

    //delete empty tube

    public function DeleteEmptyTubes($id) {
        $model = $this->findOne(['parId'=>$id]);
        $var = Sample::className();
        $model_sample = new $var;
        $model_sample = $model_sample->findOne(['parId'=>$model['containerId']]);
        $model_sample->delete();
        $model->delete();
    }

    //get name of user role
    protected function getRole()
    {        
        $user = Yii::$app->getUser()->identity->role;
        return $user->item_name;
    }
}
