<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%orders}}".
 *
 * @property string $order_no
 * @property string $member_id
 * @property integer $order_type
 * @property string $goods_id
 * @property string $goods_name
 * @property string $price
 * @property integer $buy_count
 * @property string $total
 * @property string $add_time
 * @property string $pay_time
 * @property string $consignee
 * @property string $address
 * @property string $mobile
 * @property integer $status
 * @property string $over_time
 * @property string $express
 * @property string $express_no
 * @property string $fh_time
 */
class Orders extends \yii\db\ActiveRecord {

    public $nick_name;
    
    const MEMBER_UPGRADE = 1;   //会员升级订单
    const LICAI_ORDER     = 2;   //理财订单
    const SALE_ORDER     = 3;   //销售订单
    
    //订单状态
    const PENDINGPAYMENT = 0;       //待付款
    const PENDINGSHIPPED = 1;       //待发货
    const PENDINGRECEIVING = 2;     //待收货
    const TRADINGSUCCESS = 8;       //交易成功
    const TRADINGCANCLE = 4;        //交易取消
    const TRADINGCLOSE = 5;        //交易关闭
    
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%orders}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['member_id', 'consignee', 'address', 'mobile'], 'required'],
            [['member_id', 'order_type', 'goods_id', 'buy_count', 'add_time', 'pay_time', 'status', 'over_time', 'fh_time', 'is_activity', 'is_repeat'], 'integer'],
            [['price', 'total', 'point_amount', 'order_money'], 'number'],
            [['order_no', 'consignee', 'express_no'], 'string', 'max' => 30],
            [['goods_name', 'address', 'area'], 'string', 'max' => 100],
            [['mobile'], 'string', 'max' => 11],
            [['express'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'order_no' => '订单编号',
            'member_id' => '会员ID',
            'order_type' => '订单类型',
            'goods_id' => '产品ID',
            'goods_name' => '产品名称',
            'price' => '单价',
            'buy_count' => '购买数量',
            'total' => '总价',
            'add_time' => '添加时间',
            'pay_time' => '支付时间',
            'consignee' => '收货人',
            'address' => '收货地址',
            'mobile' => '收货人手机',
            'status' => '订单状态',
            'over_time' => '完成时间',
            'express' => '快递公司',
            'express_no' => '快递单号',
            'fh_time' => '发货时间',
            'point_amount' => '积分抵扣金额',
            'is_repeat' => '是否出局自投',
            'is_activity' => '是否活动1',
        ];
    }
    
    public function getMember() {
        return $this->hasOne(Member::className(), ['id' => 'member_id']);
    }

    public function beforeSave($insert) {
        if($insert){
            $this->add_time = time();
            $this->order_no = self::buildOrderNo($this->member_id, $this->order_type);
            $this->status = self::PENDINGPAYMENT;
        }
        return true;
    }
    
    /**
     * 生成订单号
     * @return type
     */
    public static function buildOrderNo($memberId, $orderType=1) {
        return $orderType. str_pad($memberId, 5, '0', STR_PAD_LEFT) . date('ymdHis') . rand(1000,9999);
    }

    /**
     * 获取订单类型数据
     */
    public static function getOrderTypeData() {
        return [
            self::MEMBER_UPGRADE => '会员报单',
            self::LICAI_ORDER => '理财单',
            self::SALE_ORDER => '兑换单',
        ];
    }

    /**
     * 根据主键获取订单类型名
     * 
     * @param type $key
     * @return type
     */
    public static function getOrderTypeByKey($key) {
        return ArrayHelper::getValue(self::getOrderTypeData(), $key, '');
    }

    /**
     * 获取订单类型主键
     * 
     * @return type
     */
    public static function getOrderTypeKeys() {
        return array_keys(self::getOrderTypeData());
    }

    /**
     * 获取订单状态数据
     *
     * @return type
     */
    public static function getStatusData() {
        return [
            self::PENDINGPAYMENT => '待付款',
            self::PENDINGSHIPPED => '待发货',
            self::PENDINGRECEIVING => '待买家确认',
            self::TRADINGSUCCESS => '交易成功',
            self::TRADINGCANCLE => '交易取消',
            self::TRADINGCLOSE => '交易关闭',
        ];
    }

    /**
     * 获取订单状态值
     *
     * @param type $key
     * @return type
     */
    public static function getStatusByKey($key) {
        return ArrayHelper::getValue(self::getStatusData(), $key, '');
    }

    /**
     * 获取订单状态主键
     * @return type
     */
    public static function getStatusKeys() {
        return array_keys(self::getStatusData());
    }

}
