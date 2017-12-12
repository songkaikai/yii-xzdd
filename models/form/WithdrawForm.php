<?php

namespace app\models\form;

use Yii;
use app\models\Withdraw;
use app\components\payment\WechatCash;
use app\models\Member;

/**
 * 提现表单
 *
 * @author Administrator
 */
class WithdrawForm extends \yii\base\Model {
    public $memberId;
    public $drawMoney;
    public $withdrawType;
    public $bankName;
    public $cardNo;
    public $trueName;
    public $alipayNo;
    public $friendNo;
    public $errorMsg;
    
    public function rules() {
        return [
            [['memberId', 'drawMoney', 'withdrawType'], 'required'],
            [['bankName', 'cardNo', 'trueName'], 'required', 'when' => function($model){return $model->withdrawType == 'bank';}],
            [['alipayNo', 'trueName'], 'required', 'when' => function($model){return $model->withdrawType == 'alipay';}],
            [['alipayNo', 'trueName'], 'required', 'when' => function($model){return $model->withdrawType == 'wechat';}],
            [['drawMoney'], 'app\validator\MoneyValidator'],
            [['drawMoney'], 'number', 'min' => 50],
            [['errorMsg', 'withdrawType', 'bankName', 'cardNo', 'trueName', 'alipayNo', 'friendNo'], 'string'],
            [['withdrawType'], 'in', 'range'=>['friend', 'wechat', 'bank', 'alipay']],
            ['drawMoney', 'validateDrawMoney', 'when' => function($model){return $model->withdrawType !== 'friend';}],
            ['drawMoney', 'validateDrawMoney100', 'when' => function($model){return $model->withdrawType == 'friend';}],
            ['friendNo', 'validateFriend', 'when' => function($model){return $model->withdrawType == 'friend';}]
        ];
    }
    
    public function validateDrawMoney($attribute, $params) {
        if (!$this->hasErrors()) {
            if ($this->drawMoney % 50 > 0) {
                $this->addError($attribute, '提现金额必须为50的倍数');
            }
        }
    }
    
    public function validateDrawMoney100($attribute, $params) {
        if (!$this->hasErrors()) {
            if ($this->drawMoney % 100 > 0) {
                $this->addError($attribute, '朋友代提金额必须为100的倍数');
            }
        }
    }
    
    public function validateFriend($attribute, $params){
        if (!$this->hasErrors()) {
            $friendMemberInfo = Member::find()->asArray()->where(['uname'=>$this->friendNo, 'status'=>1])->one();
            if( ! $friendMemberInfo){
                $this->addError($attribute, '不存在的朋友账号');
            }
            if($friendMemberInfo['id'] == $this->memberId){
                $this->addError($attribute, '不可以自己转自己了');
            }
            $sql = "select route from {{%member}} where id = {$this->memberId}";
            $memberInfo = Yii::$app->db->createCommand($sql)->queryOne();
            $tempRoute = trim($memberInfo['route'], ',');
            $tempRouteArr = explode(',', $tempRoute);
            if(strpos($friendMemberInfo['route'], ",{$tempRouteArr[0]},") === false){
                $this->addError($attribute, '只可以自己的团队一条线代提');
            }
        }
    }
    
    public function attributeLabels() {
        return [
            'memberId' => '会员ID',
            'drawMoney' => '提现金额',
            'withdrawType' => '提现类型',
            'bankName' => '开户行',
            'cardNo' => '银行卡号',
            'trueName' => '真实姓名',
            'alipayNo' => '支付宝账号',
            'friendNo' => '朋友手机号',
            'payType' => '付款方式',
        ];
    }

    public function save(){
        $this->addError('drawMoney', '提现功能升级，稍后开放');
        return false;
        $startTime = strtotime(date('Y-m-d'));
        $endTime = strtotime(date('Y-m-d') . ' 23:59:59');
//        if(date('H')<10 || date('H') >17){
//            $this->addError('drawMoney', '每天10点到18点提现');
//            return false;
//        }
        if(Withdraw::find()->where("member_id={$this->memberId} and add_time >= {$startTime} and add_time <={$endTime}")->count()>0){
            $this->addError('drawMoney', '每天限提现1次');
            return false;
        }
        $memberInfo = \app\models\Member::findOne($this->memberId);
        if($memberInfo->level == 0){
            $this->addError('drawMoney', '非正式会员不可以提现');
            return false;
        }
        if($memberInfo->balance < $this->drawMoney){
            $this->addError('drawMoney', '余额不足');
            return false;
        }
        
        $userBalance = $memberInfo->balance - $this->drawMoney;
        
        $vouchers = round($this->drawMoney * 0.05, 2);
        $addTime = time();
        $sql = "update {{%member}} set balance = balance - {$this->drawMoney}, vouchers = vouchers + {$vouchers} where id = {$this->memberId};";
        $sql.= "INSERT INTO {{%account_log}}(`member_id`, `type`, `out`, `balance`, `desc`, `add_date`) VALUES({$this->memberId}, 0, {$this->drawMoney}, {$userBalance}, '提现', {$addTime});";
        \Yii::$app->db->createCommand($sql)->execute();
        
        $model = new Withdraw();
        $model->attributes = [
            'member_id' => $this->memberId,
            'draw_money' => $this->drawMoney,
            'pay_money' => $this->drawMoney * 0.9,
            'withdraw_type' => $this->withdrawType,
            'bank_name' => $this->bankName,
            'card_no' => $this->cardNo,
            'true_name' => $this->trueName,
            'alipay_no' => $this->alipayNo,
        ];
        if($model->save()){
            return true;
        }
        return false;
    }
    
    private function send($orderId, $memberId, $money){
        $cashModel = new WechatCash();
        $result = $cashModel->send($orderId, $memberId, $money);
        if($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
            //成功
            $sql = "update {{%withdraw}} set pay_no = '{$result['send_listid']}', cash_time = " . time() . ", status = " . Withdraw::SUCCESS . " where id = {$orderId}";
            \Yii::$app->db->createCommand($sql)->execute();
            return true;
        }else{
            $this->errorMsg = $result['return_msg'];
//            $result['err_code'] = 'SYSTEMERROR';
            //提现失败，添加日志
            \app\components\Tool::log(json_encode($result), 'cash');
            $errorCode = ['SYSTEMERROR', 'NOTENOUGH', 'PROCESSING'];
            if( ! in_array($result['err_code'], $errorCode)){
                $sql1 = "UPDATE {{%withdraw}} SET status = " . Withdraw::CLOSE . " WHERE id = {$orderId}";
                $sql2 = "UPDATE {{%member}} set balance = balance + {$money} where id = {$memberId}";
                $connection = \Yii::$app->db;
                $transaction = $connection->beginTransaction();
                try {
                    $connection->createCommand($sql1)->execute();
                    $connection->createCommand($sql2)->execute();
                    $transaction->commit();
                    return false;
                } catch (Exception $e) {
                    $transaction->rollBack();
                    \common\components\Tool::log("返钱失败|{$sql1}|{$sql2}", 'cash');
                    return false;
                }
            }
        }
    }

}
