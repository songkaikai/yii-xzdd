<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Member;

/**
 * 管理员登录表单
 */
class LoginForm extends Model {

    public $username;
    public $password;
    private $_user;

    const GET_API_TOKEN = 'generate_api_token';

    public function init() {
        parent::init();
        $this->on(self::GET_API_TOKEN, [$this, 'onGenerateApiToken']);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['username', 'password'], 'required'],
                ['password', 'validatePassword'],
        ];
    }

    /**
     * 密码验证
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->getUser();
            if (!$this->_user || !$this->_user->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或密码错误.');
            }
        }
    }

    public function attributeLabels() {
        return [
            'username' => '用户名',
            'password' => '密码',
        ];
    }

    /**
     * 登录
     */
    public function login() {
        if ($this->validate()) {
            $this->trigger(self::GET_API_TOKEN);
            return $this->_user;
        } else {
            return false;
        }
    }

    /**
     * 获取用户信息
     */
    protected function getUser() {
        if ($this->_user === null) {
            $this->_user = Member::findByUsername($this->username);
        }
    }

    /**
     * 登录校验成功后，为用户生成新的token
     * 如果token失效，则重新生成token
     */
    public function onGenerateApiToken() {
//        if (!Member::apiTokenIsValid($this->_user->api_token)) {
            $this->_user->generateApiToken();
            $this->_user->save(false);
//        }
    }
}
