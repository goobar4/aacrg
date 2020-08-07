<?php
namespace frontend\models;

//use yii\base\InvalidArgumentException;
use yii\base\Model;
use common\models\User;

/**
 * Password change form
 */
class ChangePasswordForm extends Model
{
    public $password;

    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Change password.
     *
     * @return bool if password was changed.
     */
    public function changePassword($id)
    {
        $user = User::findId($id);
        $user->setPassword($this->password);
        
       return $user->save(false);
    }
}
