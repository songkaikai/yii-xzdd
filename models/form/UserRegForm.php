<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\Member;
use yii\helpers\ArrayHelper;

/**
 * Description of UserRegForm
 *
 * @author Administrator
 */
class UserRegForm extends Model {

    public $trueName;
    public $mobile;
    public $password;
    public $recommName;
    public $confirmPassword;

    public function rules() {
        return [
                [['trueName', 'mobile', 'recommName', 'password', 'confirmPassword'], 'required'],
                [['password', 'confirmPassword'], 'string', 'min' => 6, 'max' => 30],
                [['recommName'], 'string', 'max' => 20],
                [['trueName'], 'string', 'max' => 30],
                ['confirmPassword', 'compare', 'compareAttribute' => 'password', 'message' => '两次输入的密码不一样'],
//                ['mobile', 'app\validator\MobileValidator'],
                ['mobile', 'unique', 'targetClass' => 'app\models\member', 'targetAttribute' => 'uname', 'message' => '手机号已经被注册'],
                ['recommName', 'validateRecommender'],
        ];
    }

    public function attributeLabels() {
        return [
            'trueName' => '姓名',
            'mobile' => '手机号',
            'sex' => '性别',
            'recommName' => '推荐人用户名',
            'password' => '密码',
            'confirmPassword' => '确认密码',
        ];
    }

    public function validateRecommender($attribute, $params) {
        if (!$this->hasErrors()) {
            $count = Member::find()->where("(uno='{$this->recommName}' or uname='{$this->recommName}') and status = " . Member::MEMBER_ON)->count();
            if ($count == 0) {
                $this->addError($attribute, '不存在的推荐人');
            }
        }
    }

    public function register() {
        //获取推荐人信息
        if (empty($this->recommName)) {
            $recommenderId = 0;
        } else {
            $recommendInfo = Member::find()->select('id')->asArray()->where("(uname='{$this->recommName}' or uno='{$this->recommName}') and status = " . Member::MEMBER_ON)->one();
            if (!$recommendInfo) {
                $this->addError('recommName', '不存在的推荐人');
                return false;
            }
            $recommenderId = ArrayHelper::getValue($recommendInfo, 'id', 0);
        }
        $model = new Member();
        $model->attributes = [
            'uname' => $this->mobile,
            'mobile' => $this->mobile,
            'nick_name' => $this->trueName,
            'recommender' => $recommenderId,
        ];
        $model->generateAuthKey();
        $model->setPassword($this->confirmPassword);
        if ($model->validate() && $model->save()) {
            return true;
        } else {
            print_r($model->errors);
            return false;
        }
    }

}
