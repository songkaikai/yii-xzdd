<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%withdraw}}".
 *
 * @property string $id
 * @property string $member_id
 * @property string $draw_money
 * @property string $add_time
 * @property string $cash_time
 * @property integer $status
 * @property string $pay_no
 */
class Withdraw extends \yii\db\ActiveRecord {

    const WAIT = 0;
    const SUCCESS = 8;
    const CLOSE = 9;

    public $nick_name;
    public $uname;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%withdraw}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['member_id', 'add_time', 'cash_time', 'status'], 'integer'],
            [['draw_money', 'pay_money'], 'number'],
            [['pay_no', 'true_name'], 'string', 'max' => 32],
            [['withdraw_type', 'card_no'], 'string', 'max' => 20],
            [['bank_name', 'alipay_no', 'friend_no'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'member_id' => '会员ID',
            'draw_money' => '提现金额',
            'add_time' => '添加时间',
            'cash_time' => '提现时间',
            'status' => '状态',
            'pay_no' => '支付单号',
            'nick_name' => '会员昵称',
            'withdraw_type' => '提现类型',
            'bank_name' => '银行名称',
            'card_no' => '银行卡号',
            'true_name' => '真实姓名',
            'alipay_no' => '支付宝号',
            'friend_no' => '朋友号',
            'uname' => '用户名',
        ];
    }

    public function beforeSave($insert) {
        if ($insert) {
            $this->add_time = time();
            $this->status = self::WAIT;
        }
        return true;
    }

    public static function getStatusData() {
        return [
            self::WAIT => '待审核',
            self::SUCCESS => '提现成功',
            self::CLOSE => '提现关闭',
        ];
    }

    public static function getStatusValByKey($key) {
        return ArrayHelper::getValue(self::getStatusData(), $key, '');
    }

    public static function getStatusKeys() {
        return array_keys(self::getStatusData());
    }

    public static function getWithdrawTypeData() {
        return [
            '0' => '微信提现',
            'alipay' => '支付宝提现',
            'wechat' => '微信提现',
            'bank' => '银行转账',
            'friend' => '朋友代提',
        ];
    }
    
    public static function getWithdrawTypeValByKey($key) {
        return ArrayHelper::getValue(self::getWithdrawTypeData(), $key, '');
    }
}
