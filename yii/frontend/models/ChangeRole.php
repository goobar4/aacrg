<?php
namespace frontend\models;

use yii\base\Model;
use common\models\AuthAssignment;

/**
 * Password change form
 */
class ChangeRole extends Model
{
    public $role;

    
       
    public function changeRole($id,$name)
    {
        $role = AuthAssignment::findId($id);
        
        if ($role)
        {
            
            $role->item_name = $name;        
            return $role->save(false);
            
        }
        else{
            $role = new AuthAssignment();
            $role->item_name = $name;
            $role->user_id = $id;
            return $role->save(false);
        }
        
    }

    public function countAdmin($name,$id,$role){
        
        $count = AuthAssignment::find()->where(['item_name' => 'admin'])->count();
       if ($name=='admin'and $count==1){
        return false;
       }
       elseif($count>1){
        return false;
       }       
        elseif ($count==1 and $role==$id){
            return true;
        }
        else{return false;}
    }
}
