<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\Member;
use app\models\Orders;
use app\models\PublicRow;

/**
 * Description of RegOrderForm
 *
 * @author Administrator
 */
class RegOrderForm extends Model {

    public $memberId;
    public $orderInfo;
    public $consignee;
    public $area;
    public $address;
    public $mobile;

    public function rules() {
        return [
                [['memberId'], 'required'],
                [['memberId'], 'integer'],
//                [['mobile'], 'app\validator\mobileValidator'],
                [['consignee', 'address', 'area', 'mobile'], 'string'],
                ['orderInfo', 'safe'],
        ];
    }

    public function attributeLabels() {
        return [
            'memberId' => '会员ID',
            'mobile' => '收货人手机号',
            'consignee' => '收货人',
            'area' => '所在地区',
            'address' => '详细地址',
        ];
    }

    /**
     * 创建报单订单
     */
    public function build() {
        $orderMoney = Yii::$app->params['registerMoney'];
        $memberInfo = Member::find()->select('id, balance, recommender')->asArray()->where(['id' => $this->memberId])->one();
        if (!$memberInfo || $memberInfo['balance'] < $orderMoney) {
            $this->addError('memberId', '账户余额不足');
            return false;
        }
        $buyCount = Orders::find()->where("member_id = {$this->memberId} and order_type = " . Orders::MEMBER_UPGRADE)->count();
//        if ($buyCount > 0) {
//            $this->addError('memberId', '报单产品每人限购1单');
//            return false;
//        }
        $time = time();
        $balance = $memberInfo['balance'] - $orderMoney;
        $orderNo = Orders::buildOrderNo($this->memberId, Orders::MEMBER_UPGRADE);
        $sql1 = "insert into {{%orders}}(order_no, member_id, order_type, goods_id, goods_name, price, buy_count, total, order_money, add_time, pay_time, status, consignee, area, address, mobile) "
                . "values('{$orderNo}', {$this->memberId}, " . Orders::MEMBER_UPGRADE . ", 1, '报单产品', {$orderMoney}, 1, {$orderMoney}, {$orderMoney}, {$time}, {$time}, " . Orders::PENDINGSHIPPED . ", '{$this->consignee}', '{$this->area}', '{$this->address}', '$this->mobile')";
        $sql2 = "update {{%member}} set balance = balance - {$orderMoney}, level = " . Member::LEVEL_TWO . " where id = {$this->memberId}";
        $sql3 = "insert into {{%account_log}}(`member_id`, `type`, `out`, `balance`, `desc`, `add_date`) VALUES({$this->memberId}, 0, {$orderMoney}, {$balance}, '会员开通购买', $time)";
        if ($memberInfo['recommender'] && $buyCount == 0) {
            $sql4 = "update {{%member}} set recomm_count = recomm_count + 1 where id = {$memberInfo['recommender']}";
        }

        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $connection->createCommand($sql1)->execute();
            $connection->createCommand($sql2)->execute();
            $connection->createCommand($sql3)->execute();
            if ($memberInfo['recommender'] && $buyCount == 0) {
                $connection->createCommand($sql4)->execute();
            }
            $transaction->commit();
            $this->setPublicRow();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::error($e->message, 'app.regOrderForm.build');
            return false;
        }
    }

    /**
     * 设置公排号
     * 
     * @param type $memberId
     * @param type $orderId
     * @return boolean
     */
    private function setPublicRow() {
        $orderId = Orders::find()->select('order_no')->where(['member_id' => $this->memberId, 'order_type' => Orders::MEMBER_UPGRADE])->scalar();
        $publicModel = new PublicRowForm();
        $publicModel->attributes = [
            'memberId' => $this->memberId,
            'orderId' => $orderId,
        ];
        if ($publicModel->validate() && $publicModel->paiHao()) {
            return true;
        }
        return false;
    }

}
