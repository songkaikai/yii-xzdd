<?php

namespace app\models\form;

use Yii;
use app\models\Member;
use app\models\AccountLog;
use app\models\form\PublicRowBForm;

/**
 * 会员账户
 *
 * @filename AccountForm.php 
 * @encoding UTF-8 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2016-11-5 9:22:03
 */
class AccountForm extends \yii\base\Model {
    public $memberId;
    public $targetId;
    public $type;
    public $money;
    public $desc;
    public $orderNo;
    
    public function scenarios() {
        return [
            'default' => ['memberId', 'type', 'money', 'desc', 'orderNo'],
            'trans' => ['memberId', 'targetId', 'money', 'desc'],
        ];
    }
    
    public function rules() {
        return [
            [['type', 'memberId', 'money'], 'required', 'on' => 'default'],
            [['targetId', 'memberId', 'money'], 'required', 'on' => 'trans'],
            [['targetId', 'memberId', 'type'], 'integer'],
            [['orderNo', 'desc'], 'string', 'max' => 100],
            ['type', 'in', 'range' => AccountLog::getTypeKeys()],
            ['money', 'app\validator\MoneyValidator'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'memberId' => '会员ID',
            'desc' => '备注',
            'money' => '金额',
            'targetId' => '对方ID',
            'type' => '日志类型',
            'orderNo' => '订单号',
        ];
    }
    
    /**
     * 转账
     */
    public function trans(){
        if($this->money <= 0){
            $this->addError('money', '转账金额必须大于0');
            return false;
        }
        $userModel = Member::find()->select('id, balance, nick_name, level')->asArray()->where(['id'=>$this->memberId])->one();
        if($userModel['level'] == 0){
            $this->addError('money', '非正式会员不可以转币');
            return false;
        }
        if($userModel['balance'] < $this->money){
            $this->addError('money', '账户余额不足');
            return false;
        }
        $targetModel = Member::find()->select('id, balance, nick_name')->asArray()->where(['id'=>$this->targetId])->one();
        if(! $targetModel){
            $this->addError('targetId', '不存在的收款人');
            return false;
        }
        $userBalance = $userModel['balance'] - $this->money;
        $targetBalance = $targetModel['balance'] + $this->money;
        $addTime = time();
        
        $sql1 = "INSERT INTO {{%account_log}}(`member_id`, `type`, `in`, `balance`, `desc`, `add_date`) VALUES({$targetModel['id']}, " . AccountLog::J9 . ", {$this->money}, {$targetBalance}, '{$this->desc}', {$addTime})";
        $sql2 = "UPDATE {{%member}} SET balance = balance + {$this->money}, commissions = commissions + {$this->money} WHERE id = {$targetModel['id']}";
        $sql3 = "INSERT INTO {{%account_log}}(`member_id`, `type`, `out`, `balance`, `desc`, `add_date`) VALUES({$userModel['id']}, " . AccountLog::J9 . ", {$this->money}, {$userBalance}, '{$this->desc}', {$addTime})";
        $sql4 = "UPDATE {{%member}} SET balance = balance - {$this->money} WHERE id = {$userModel['id']}";
        $connection = \Yii::$app->db;
        
        $transaction = $connection->beginTransaction();
        try {
            $connection->createCommand($sql1)->execute();
            $connection->createCommand($sql2)->execute();
            $connection->createCommand($sql3)->execute();
            $connection->createCommand($sql4)->execute();
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::error($e->message, 'app.accountForm.trans');
            return false;
        }
    }
    
    /**
     * 充值现金
     */
    public function rechargeMoney(){
        if($this->money <= 0){
            $this->addError('money', '金额必须大于0');
            return false;
        }
        $userModel = Member::find()->select('id, balance, nick_name, integral_balance')->asArray()->where(['id'=>$this->memberId])->one();
        $blance = $userModel['balance'] + $this->money;
        $addTime = time();
        $integral = round($this->money * 0.1, 2);
        $shouMoney = round($this->money - $integral, 2);
        //添加账户变动日志
        $sql1 = "INSERT INTO {{%account_log}}(`member_id`, `type`, `in`, `balance`, `desc`, `add_date`, `order_no`) VALUES({$userModel['id']}, {$this->type}, {$this->money}, {$blance}, '{$this->desc}', {$addTime}, '{$this->orderNo}')";
        //更改账户余额
        $sql2 = "UPDATE {{%member}} SET balance = balance + {$shouMoney}, commissions = commissions + {$this->money}, integral_balance = integral_balance + {$integral} WHERE id = {$userModel['id']}";
        $connection = \Yii::$app->db;
        
        $transaction = $connection->beginTransaction();
        try {
            $connection->createCommand($sql1)->execute();
            $connection->createCommand($sql2)->execute();
            $transaction->commit();
            if(($userModel['integral_balance'] + $integral)>=60){
                $this->chgToBNet($userModel['id'], 60);
            }
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::error($e->message, 'app.accountForm.rechargeMoney');
            return false;
        }
    }
    
    /**
     * 现金提现
     */
    public function withdrawMoney(){
        $userModel = Member::find()->select('id, balance')->asArray()->where(['id'=>$this->memberId])->one();
        if($userModel['balance'] < $this->money){
            return false;
        }
        $blance = $userModel['balance'] - $this->money;
        $addTime = time();
        //添加账户变动日志
        $sql1 = "INSERT INTO {{%account_log}}(`member_id`, `type`, `out`, `balance`, `desc`, `add_date`, `order_no`) VALUES({$this->memberId}, {$this->type}, {$this->money}, {$blance}, '{$this->desc}', {$addTime}, '{$this->orderNo}')";
        //更改账户余额
        $sql2 = "UPDATE {{%member}} SET balance = balance - {$this->money} WHERE id = {$this->memberId}";
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $connection->createCommand($sql1)->execute();
            $connection->createCommand($sql2)->execute();
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::error($e->message, 'common.accountForm.withdraw');
            return false;
        }
    }

    /**
     * 会员跳B网
     */
    private function chgToBNet($memberId, $point){
        $memberInfo = Member::find()->select('id, integral_balance')->where(['id'=>$memberId])->one();
        if($memberInfo->integral_balance < $point){
            return false;
        }
        $memberInfo->integral_balance = $memberInfo->integral_balance - $point;
        if($memberInfo->save()){
            $this->setPublicRow($memberInfo->id);
            $this->setPublicRowA($memberInfo->id);
        }
    }
    
    /**
     * 设置A网公排号
     * 
     * @param type $memberId
     * @param type $orderId
     * @return boolean
     */
    private function setPublicRowA($memberId){
        $publicModel = new PublicRowForm();
        $publicModel->attributes = [
            'memberId' => $memberId,
            'orderId' => 'repeat',
            'isBuy' => 0,
        ];
        if($publicModel->validate() && $publicModel->paiHao()){
            return true;
        }
        return false;
    }
    
    /**
     * 设置B网公排号
     * 
     * @param type $memberId
     * @param type $orderId
     * @return boolean
     */
    private function setPublicRow($memberId){
        $publicModel = new PublicRowBForm();
        $publicModel->attributes = [
            'memberId' => $memberId,
        ];
        if($publicModel->validate() && $publicModel->paiHao()){
            return true;
        }
        return false;
    }
    
    
}
