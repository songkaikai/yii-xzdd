<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\Member;
use app\models\AccountLog;

/**
 * 后台会员充值
 *
 * @author Administrator
 */
class HtRechargeForm extends Model {

    public $mobile;
    public $rechargeMoney;
    public $payPass;

    public function rules() {
        return [
            [['mobile', 'rechargeMoney', 'payPass'], 'required'],
            [['rechargeMoney'], 'integer'],
            ['mobile', 'validateUname'],
            ['payPass', 'validatePaypass'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'mobile' => '手机号',
            'rechargeMoney' => '充值金额',
            'payPass' => '支付密码',
        ];
    }
    
    public function validatePaypass($attribute, $params) {
        if (!$this->hasErrors()) {
            if (md5($this->payPass) !== '031687dc39cf9c9c69898f514daa50dd') {
                $this->addError($attribute, '支付密码错误');
            }
        }
    }
    
    public function validateUname($attribute, $params) {
        if (!$this->hasErrors()) {
            $count = Member::find()->where(['uname' => $this->mobile])->count();
            if ($count == 0) {
                $this->addError($attribute, '不存在的会员');
            }
        }
    }
    
    /**
     * 充值
     */
    public function recharge(){
        $userModel = Member::find()->select('id, balance, nick_name')->asArray()->where(['uname'=>$this->mobile])->one();
        $blance = $userModel['balance'] + $this->rechargeMoney;
        $addTime = time();
        //添加账户变动日志
        $sql1 = "INSERT INTO {{%account_log}}(`member_id`, `type`, `in`, `balance`, `desc`, `add_date`) VALUES({$userModel['id']}, ".AccountLog::J12.", {$this->rechargeMoney}, {$blance}, '系统充值', {$addTime})";
        //更改账户余额
        $sql2 = "UPDATE {{%member}} SET balance = balance + {$this->rechargeMoney}, commissions = commissions + {$this->rechargeMoney} WHERE id = {$userModel['id']}";
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
}
