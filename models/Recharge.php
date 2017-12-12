<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%recharge}}".
 *
 * @property string $id
 * @property string $order_no
 * @property string $member_id
 * @property string $recharge_money
 * @property string $add_time
 * @property string $pay_time
 * @property string $pay_type
 * @property string $pay_no
 * @property integer $status
 */
class Recharge extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%recharge}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['member_id', 'recharge_money', 'add_time', 'pay_time', 'status'], 'integer'],
                [['order_no', 'pay_type'], 'string', 'max' => 20],
                [['pay_no'], 'string', 'max' => 50],
                [['order_no'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'order_no' => '订单编号',
            'member_id' => '会员ID',
            'recharge_money' => '充值金额',
            'add_time' => '添加时间',
            'pay_time' => '支付时间',
            'pay_type' => '支付方式',
            'pay_no' => '支付单号',
            'status' => '状态',
        ];
    }
    
    public function beforeSave($insert) {
        if($insert){
            $this->add_time = time();
            $this->order_no = $this->buildOrderNo($this->member_id);
        }
        return true;
    }

    /**
     * 生成充值单号
     * 
     * @param type $memberId
     * @return type
     */
    public static function buildOrderNo($memberId) {
        $flag = true;
        $orderNo = '';
        while ($flag) {
            $orderNo = \app\components\Tool::getOrderNo($memberId, '6');
            if (!static::find()->where(['order_no' => $orderNo])->count()) {
                $flag = false;
            }
        }
        return $orderNo;
    }
}
