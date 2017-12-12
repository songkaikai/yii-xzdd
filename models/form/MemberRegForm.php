<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\Member;
use yii\helpers\ArrayHelper;
use app\models\form\AccountForm;
use app\models\form\RegOrderForm;
use app\models\AccountLog;

/**
 * 会员注册
 *
 * @filename MemberRegForm.php 
 * @encoding UTF-8 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2017-5-3 16:40:47
 */
class MemberRegForm extends Model {

    public $memberId;
    public $trueName;
    public $mobile;
    public $sex;
    public $recommName;

    public function rules() {
        return [
                [['trueName', 'mobile', 'memberId'], 'required'],
                [['recommName'], 'string', 'max' => 20],
                [['trueName'], 'string', 'max' => 30],
                [['sex', 'memberId'], 'integer'],
                ['sex', 'in', 'range' => Member::getSexKeys()],
//                ['mobile', 'app\validator\MobileValidator'],
                ['mobile', 'unique', 'targetClass' => 'app\models\member', 'targetAttribute' => 'uname', 'message' => '手机号已经被注册'],
//                ['mobile', 'unique', 'targetClass' => 'app\models\member', 'targetAttribute' => 'mobile', 'message' => '手机号已经被使用'],
//                ['recommName', 'validateRecommender'],
        ];
    }

    public function attributeLabels() {
        return [
            'trueName' => '姓名',
            'mobile' => '手机号',
            'sex' => '性别',
            'recommName' => '推荐人用户名',
            'memberId' => '报单人ID',
        ];
    }

    public function validateRecommender($attribute, $params) {
        if (!$this->hasErrors()) {
            $count = Member::find()->where("uname='{$this->recommName}' and status = " . Member::MEMBER_ON)->count();
            if ($count == 0) {
                $this->addError($attribute, '不存在的推荐人');
            }
        }
    }

    /**
     * 注册会员
     */
    public function register() {
        //判断报单人账户余额
        $baodanPerson = Member::find()->select('balance, report_center')->asArray()->where(['id' => $this->memberId])->one();
        if ($baodanPerson['balance'] < Yii::$app->params['registerMoney']) {
            $this->addError('memberId', '余额不足，无法报单');
            return false;
        }
        //获取推荐人信息
//        $recommenderId = 0;
        if ($baodanPerson['report_center']) {
            if (empty($this->recommName)) {
                $recommenderId = 0;
            } else {
                $recommendInfo = Member::find()->select('id')->asArray()->where("uname='{$this->recommName}' and status = " . Member::MEMBER_ON)->one();
                if (!$recommendInfo) {
                    $this->addError('recommName', '不存在的推荐人');
                    return false;
                }
                $recommenderId = ArrayHelper::getValue($recommendInfo, 'id', 0);
            }
        } else {
            $recommenderId = $this->memberId;
        }
        $model = new Member();
        $model->attributes = [
            'uname' => $this->mobile,
            'mobile' => $this->mobile,
            'nick_name' => $this->trueName,
            'sex' => $this->sex,
            'recommender' => $recommenderId,
        ];
        $model->generateAuthKey();
        $model->setPassword(Yii::$app->params['userDefaultPass']);
        if ($model->validate() && $model->save()) {
            $this->trans($this->memberId, $model->id);
            $this->buildOrder($model->id);
            return true;
        } else {
            print_r($model->errors);
            return false;
        }
    }
    
    /**
     * 后台添加
     */
    public function addMember() {
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
            'sex' => $this->sex,
            'recommender' => $recommenderId,
        ];
        $model->generateAuthKey();
        $model->setPassword(Yii::$app->params['userDefaultPass']);
        if ($model->validate() && $model->save()) {
            $this->recharge($model);
            $this->buildOrder($model->id);
            return true;
        } else {
            print_r($model->errors);
            return false;
        }
    }

    //会员充值
    private function recharge(& $memberInfo) {
        $money = Yii::$app->params['registerMoney'];
        $addTime = time();
        //添加账户变动日志
        $sql1 = "INSERT INTO {{%account_log}}(`member_id`, `type`, `in`, `balance`, `desc`, `add_date`) "
                . "VALUES({$memberInfo['id']}, ".AccountLog::J11.", {$money}, {$money}, '开户充值', {$addTime})";
        //更改账户余额
        $sql2 = "UPDATE {{%member}} SET balance = balance + {$money}, commissions = commissions + {$money} WHERE id = {$memberInfo['id']}";
        $connection = \Yii::$app->db;
        
        $transaction = $connection->beginTransaction();
        try {
            $connection->createCommand($sql1)->execute();
            $connection->createCommand($sql2)->execute();
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
    
    //扣除报单人的金币
    private function trans($memberId, $targetId) {
        $model = new AccountForm();
        $model->scenario = 'trans';
        $model->attributes = [
            'memberId' => $memberId,
            'targetId' => $targetId,
            'money' => Yii::$app->params['registerMoney'],
            'desc' => "开通会员转账",
        ];
        if ($model->validate() && $model->trans()) {
            return true;
        }
        return false;
    }

    /**
     * 创建订单并付款
     */
    private function buildOrder($memberId){
        $model = new RegOrderForm();
        $model->memberId = $memberId;
        if($model->validate() && $model->build()){
            return true;
        }
        return false;
    }
}
