<?php

namespace app\models\form;

use yii\base\Model;
use Yii;
use app\models\Member;

/**
 * 修改个人密码
 *
 * @filename ChgPasswordForm.php 
 * @encoding UTF-8 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2015-10-20 10:56:30
 */
class ChgPasswordForm extends Model {

    public $memberId;
    public $oldPassword;
    public $newPassword;
    public $newPasswordConfirm;
    
    private $_users;

    public function rules() {
        return [
            [['memberId', 'newPassword', 'oldPassword', 'newPasswordConfirm'], 'required'],
            [['newPassword', 'newPasswordConfirm', 'oldPassword'], 'string', 'min' => 6, 'max' => 20],
            ['memberId', 'integer'],
            ['newPasswordConfirm', 'compare', 'compareAttribute' => 'newPassword', 'message'=>'两次输入的新密码不一样'],
            ['oldPassword', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->oldPassword)) {
                $this->addError($attribute, '旧密码不正确');
            }
        }
    }
    
    public function attributeLabels() {
        return [
            'oldPassword' => '原密码',
            'newPassword' => '新密码',
            'newPasswordConfirm' => '确认新密码',
        ];
    }
    
    protected function getUser() {
        if ($this->_users === null) {
            $this->_users = Member::findIdentity($this->memberId);
        }
        return $this->_users;
    }
    
    /**
     * 修改密码
     * @return type
     */
    public function changePassword(){
        $user = $this->getUser();
        $user->setPassword($this->newPassword);
        return $user->save(false);
    }
}
