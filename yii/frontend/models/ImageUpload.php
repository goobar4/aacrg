<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;
use frontend\models\Image;
use frontend\models\Host;
use Yii;


class ImageUpload extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }
    
    public function upload($id)
    {      
    

        if ($this->validate()) {
           
            foreach ($this->imageFiles as $file) {
                
                $model = new Image;
                $model->oldName = $file->baseName;
                $model->parId = $id;
                $parent_model = Host::find()->where(['occurrenceID'=>$id])->one();
                $user_id=Yii::$app->user->identity->id;
                $rand =Yii::$app->security->generateRandomString(5);
	        $sciName = str_replace(' ', '__', $parent_model->sciName0->scientificName);
                $name=$id.'_'.$sciName.'_'.time().'_'.$user_id .$rand.'.'.$file->extension;
                $model->name =  $name;
                $model->md5 = md5($file);
                if($model->validate()){
                    $model->save(false);                
                    $file->saveAs('uploads/images/'.$name);
                }
                else{
                    return $model->getFirstErrors();
                
                }
            }
            return true;
        } else {
            return false;
        }
    }
}
