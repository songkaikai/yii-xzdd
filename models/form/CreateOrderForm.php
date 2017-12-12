<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\Orders;
use app\models\Products;
use app\models\form\ChangeOrderForm;
use app\models\Address;

/**
 * Description of CreateOrderForm
 *
 * @filename CreateOrderForm.php 
 * @encoding UTF-8 
 * @copyright Copyright (C) 2016 浙江皮趣皮网络科技有限公司
 * @link http://www.zjpqp.com 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2016-10-30 21:18:59
 */
class CreateOrderForm extends Model {

    public $goodId;
    public $memberId;
    public $buyCount;
    public $addressId;
    public $orderInfo;
    public $isSystem = 0;

    public function rules() {
        return [
            [['goodId', 'memberId', 'buyCount', 'addressId'], 'required'],
            [['memberId', 'buyCount', 'isSystem', 'addressId'], 'integer'],
            [['buyCount'], 'number', 'min' => 1],
            ['orderInfo', 'safe'],
        ];
    }

    public function attributeLabels() {
        return [
            'goodId' => '产品ID',
            'memberId' => '会员ID',
            'buyCount' => '购买数量',
            'addressId' => '地区ID',
        ];
    }

    public function save() {
        if($this->getTodaySell() >= 300){
            $this->addError('buyCount', '今日最多消费300');
            return false;
        }
        $goodsInfo = $this->getGoodInfo();
        if($goodsInfo['stock'] < $this->buyCount){
            $this->addError('buyCount', '库存不足');
            return false;
        }
        if($goodsInfo['day_max_sell'] > 0 && $goodsInfo['day_max_sell'] < $goodsInfo['day_sell']){
            $this->addError('buyCount', '今日库存已售完，明日再来');
            return false;
        }
        if($goodsInfo['is_member'] == 1){
            $this->closeWaitPayOrder();
            $orderType = Orders::MEMBER_UPGRADE;
            $freight = 0;
        }else{
            $orderType = Orders::SALE_ORDER;
            $freight = Yii::$app->params['freight'];
        }
        $addressInfo = Address::findOne($this->addressId);
        $model = new Orders();
        $model->attributes = [
            'member_id' => $this->memberId,
            'order_type' => $orderType,
            'goods_id' => $goodsInfo['id'],
            'goods_name' => $goodsInfo['title'],
            'price' => $goodsInfo['member_price'],
            'buy_count' => $this->buyCount,
            'total' => $goodsInfo['member_price'] * $this->buyCount + $freight,
            'order_money' => $goodsInfo['member_price'] * $this->buyCount + $freight,
            'area' => $addressInfo->area,
            'consignee' => $addressInfo->consignee,
            'address' => $addressInfo->address,
            'mobile' => $addressInfo->mobile,
        ];
        if($model->validate() && $model->save()){
            $this->orderInfo = $model;
            return true;
        }
        $this->addError('member_id', $model->errors);
        return false;
    }
    
    private function getTodaySell(){
        $startTime = strtotime(date('Y-m-d'));
        $endTime = strtotime(date('Y-m-d') . ' 23:59:59');
        $todayBuyMoney = Orders::find()
                ->select('sum(total) as total')
                ->where("member_id={$this->memberId} and order_type = 1 and status in (1,2,8) and pay_time >= {$startTime} and pay_time <= {$endTime}")
                ->scalar();
        if( ! $todayBuyMoney){
            $todayBuyMoney = 0;
        }
        return $todayBuyMoney;
    }
    
    /**
     * 获取购买次数
     */
    private function getBuyCount(){
        $buyCount = Orders::find()->where(['member_id'=>$this->memberId, 'order_type'=>Orders::MEMBER_UPGRADE, 'status'=>[Orders::PENDINGSHIPPED, Orders::PENDINGRECEIVING, Orders::TRADINGSUCCESS]])->count();
        return $buyCount;
    }

    /**
     * 获取产品详情
     */
    private function getGoodInfo(){
        $goodsInfo = Products::find()->asArray()->where(['id'=>$this->goodId])->one();
        return $goodsInfo;
    }
    
    
    /**
     * 关闭待付款订单
     * @return type
     */
    private function closeWaitPayOrder(){
        $waitPayOrder = Orders::find()->where("member_id={$this->memberId} and order_type=".Orders::MEMBER_UPGRADE." and status = ".Orders::PENDINGPAYMENT)->one();
        if($waitPayOrder){
            $model = new ChangeOrderForm();
            $model->attributes = [
                'memberId' => $this->memberId,
                'orderNo' => $waitPayOrder->order_no,
            ];
            return $model->chgToClose();
        }
    }
}
