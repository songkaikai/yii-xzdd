<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\Member;
use app\components\VerificationCode;

/**
 * 找回密码
 *
 * @filename ForgetPassForm.php 
 * @encoding UTF-8 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2016-10-13 11:31:27
 */
class ForgetPassForm extends Model {

    public $mobile;
    public $code;
    public $newpass;
    public $confirmPass;

    public function rules() {
        return [
            [['mobile', 'code', 'newpass', 'confirmPass'], 'required'],
            ['mobile', 'string', 'max' => 11],
            [['newpass', 'confirmPass'], 'string', 'min' => 6, 'max' => 30],
            ['code', 'string', 'max' => 6],
            ['confirmPass', 'compare', 'compareAttribute' => 'newpass', 'message' => '两次输入的密码不一样'],
            ['mobile', 'app\validator\MobileValidator'],
            ['code', 'validateCode'],
        ];
    }
    
    public function validateCode($attribute, $params) {
        if (!$this->hasErrors()) {
            $cookieId = 'findpasscode';
            $model = new VerificationCode();
            if ($model->getCookies($cookieId) !== $this->code) {
                $this->addError($attribute, '验证码不正确');
            }
        }
    }

    public function attributeLabels() {
        return [
            'mobile' => '手机号',
            'code' => '验证码',
            'newpass' => '新密码',
            'confirmPass' => '确认密码',
        ];
    }

    /**
     * 密码重置
     */
    public function resetPass() {
        $user = Member::find()->where(['uname'=>$this->mobile, 'status'=>Member::MEMBER_ON])->one();
        if( ! $user){
            $this->addError('mobile', '不存在的用户');
            return false;
        }
        $user->setPassword($this->confirmPass);
        return $user->save();
    }

}
