<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\Recharge;
use app\models\Member;
use app\models\AccountLog;

/**
 * 改变充值单状态
 *
 * @author Administrator
 */
class ChgRechargeForm extends Model{
    public $orderNo;
    public $orderMoney;
    public $payType;
    public $payNo;
    
    public function rules() {
        return [
            [['orderNo', 'orderMoney', 'payType', 'payNo'], 'required'],
            [['orderNo', 'payType', 'payNo'], 'string'],
            [['orderMoney'], 'integer'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'orderNo' => '订单编号',
            'orderMoney' => '订单金额',
            'payType' => '支付类型',
            'payNo' => '支付单号',
        ];
    }
    
    public function pay(){
        $rechargeInfo = Recharge::find()->where(['order_no'=>$this->orderNo, 'recharge_money'=>$this->orderMoney])->one();
        if(! $rechargeInfo){
            $this->addError('orderNo', '不存在的订单号');
            return false;
        }
        if($rechargeInfo->status > 0){
            $this->addError('orderNo', '当前订单不是待支付状态');
            return false;
        }
        $rechargeInfo->status = 1;
        $rechargeInfo->pay_time = time();
        $rechargeInfo->pay_type = 'alipay';
        $rechargeInfo->pay_no = $this->payNo;
        if($rechargeInfo->save()){
            $this->rechargeMoney($rechargeInfo->recharge_money, $rechargeInfo->order_no, $rechargeInfo->member_id);
            return true;
        }
        return false;
    }
    
    private function rechargeMoney($money, $orderNo, $memberId){
        $userModel = Member::find()->select('id, balance, nick_name')->asArray()->where(['id'=>$memberId])->one();
        $blance = $userModel['balance'] + $money;
        $addTime = time();
        //添加账户变动日志
        $sql1 = "INSERT INTO {{%account_log}}(`member_id`, `type`, `in`, `balance`, `desc`, `add_date`, `order_no`) VALUES({$userModel['id']}, ".AccountLog::J10.", {$money}, {$blance}, '充值', {$addTime}, '{$orderNo}')";
        //更改账户余额
        $sql2 = "UPDATE {{%member}} SET balance = balance + {$money}, commissions = commissions + {$money} WHERE id = {$userModel['id']}";
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
