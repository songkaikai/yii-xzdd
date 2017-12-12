<?php

namespace app\models\form;

use Yii;
use app\models\Cart;
use app\models\Orders;
use app\models\Member;
use app\models\Address;

/**
 * 购物车转订单
 *
 * @filename CartOrderForm.php 
 * @encoding UTF-8 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2016-12-12 23:29:27
 */
class CartOrderForm extends \yii\base\Model {
    
    public $memberId;
    public $cartId;
    public $addressId;
    public $orderInfo;
    
    public function rules() {
        return [
            [['memberId', 'addressId', 'cartId'], 'required'],
            [['memberId', 'addressId'], 'integer'],
            [['cartId'], 'string'],
            ['orderInfo', 'safe'],
        ];
    }

    public function attributeLabels() {
        return [
            'memberId' => '会员ID',
            'addressId' => '地址ID',
            'cartId' => '购物车ID',
        ];
    }
    
    public function save() {        
        $cartInfo = $this->getCartInfo();
        if( ! $cartInfo){
            $this->addError('memberId', '购物车为空');
            return false;
        }
        $addressInfo = Address::findOne($this->addressId);
        $model = new Orders();
        $model->attributes = [
            'member_id' => $this->memberId,
            'order_type' => Orders::SALE_ORDER,
            'goods_id' => 0,
            'goods_name' => '商城商品',
            'price' => 0,
            'consignee' => $addressInfo->consignee,
            'address' => $addressInfo->address,
            'mobile' => $addressInfo->mobile,
            'area' => $addressInfo->area,
        ];
        if($model->validate() && $model->save()){
            $this->insertOrderDetail($cartInfo, $model->order_no, $this->memberId);
            $this->delCart();
            $this->orderInfo = $model;
            return true;
        }
        $this->addError('member_id', $model->errors);
        return false;
    }
    
    /**
     * 插入订单详情
     * 
     * @param type $cartInfo
     * @param type $orderNo
     * @return boolean
     */
    private function insertOrderDetail($cartInfo, $orderNo, $memberId){
        $sum = Yii::$app->params['freight'];
        $point = 0;
        $sql = 'insert into {{%orders_detail}}(order_no, goods_id, goods_name, price, buy_count, total) values';
        foreach($cartInfo as $val){
            $total = round($val['price'] * $val['buy_count'], 2);
            $sql .= "('{$orderNo}', {$val['goods_id']}, '{$val['goods_name']}', {$val['price']}, {$val['buy_count']}, {$total}),";
            $sum += $total;
            $point += $val['max_point'];
        }
        if(Yii::$app->db->createCommand(trim($sql, ','))->execute()){
            //获得会员可用积分
            $memberInfo = Member::findOne($this->memberId);
            if($memberInfo['integral_balance']<$point){
                $point = $memberInfo['integral_balance'];
            }
            $payMoney = $sum - $point;
            if($payMoney > 0){
                $sql = "update {{%orders}} set point_amount = {$point}, order_money = {$sum}, total = {$payMoney} where order_no = '{$orderNo}';";
            }else{
                $sql = "update {{%orders}} set point_amount = {$point}, order_money = {$sum}, total = {$payMoney}, status = 1, pay_time = ".time()." where order_no = '{$orderNo}';";
            }
            if($point > 0){
                $sql .= "update {{%member}} set integral_balance = integral_balance - {$point} where id = '{$memberId}';";
            }
            Yii::$app->db->createCommand($sql)->execute();
            return true;
        }
        return false;
    }
    
    /**
     * 获取会员购物车详情
     * @return type
     */
    private function getCartInfo(){
        $sql = "select a.id, a.goods_id, a.buy_count, b.title as goods_name, b.image as pic, b.member_price as price, b.max_point from {{%cart}} a left join {{%content}} b on a.goods_id = b.id where a.member_id = " . $this->memberId . " and a.id in ($this->cartId)";
        $cartInfo = Yii::$app->db->createCommand($sql)->queryAll();
        return $cartInfo;
    }
    
    private function delCart(){
        $sql = "delete from {{%cart}}  where member_id = " . $this->memberId . " and id in ($this->cartId)";
        Yii::$app->db->createCommand($sql)->execute();
    }
}
