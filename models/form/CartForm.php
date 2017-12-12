<?php

namespace app\models\form;

use Yii;
use app\models\Cart;

/**
 * 购物车
 *
 * @filename CartForm.php 
 * @encoding UTF-8 
 * @copyright Copyright (C) 2016 浙江皮趣皮网络科技有限公司
 * @link http://www.zjpqp.com 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2016-12-12 20:36:27
 */
class CartForm extends \yii\base\Model {

    public $memberId;
    public $goodsId;
    public $cartId;
    public $chgCount;

    public function scenarios() {
        return [
            'default' => ['memberId', 'goodsId'],
            'change' => ['memberId', 'cartId', 'chgCount'],
            'delete' => ['memberId', 'cartId'],
        ];
    }

    public function rules() {
        return [
            [['memberId', 'goodsId'], 'required', 'on' => 'default'],
            [['memberId', 'cartId', 'chgCount'], 'required', 'on' => 'change'],
            [['memberId', 'cartId'], 'required', 'on' => 'delete'],
            [['memberId', 'cartId', 'goodsId', 'chgCount'], 'integer'],
        ];
    }

    public function attributeLabels() {
        return [
            'memberId' => '会员ID',
            'goodsId'  => '产品ID',
            'cartId'   => '购物车ID',
            'chgCount' => '更改数量',
        ];
    }
    
    /**
     * 加入到购物车
     * 
     * @return boolean
     */
    public function add(){
        $cartInfo = Cart::find()
                ->where(['member_id'=>$this->memberId, 'goods_id'=>$this->goodsId])
                ->one();
        if( ! $cartInfo){
            $goodsInfo = \app\models\Products::find()->select('title')->asArray()->where(['id'=>$this->goodsId])->one();
            if($goodsInfo){
                $cartInfo = new Cart();
                $cartInfo->attributes = [
                    'member_id' => $this->memberId,
                    'goods_id' => $this->goodsId,
                    'goods_name' => $goodsInfo['title'],
                    'buy_count' => 1,
                ];
            }else{
                $this->addError('goodsId', '不存在产品');
                return false;
            }
        }else{
            $cartInfo->buy_count += 1;
        }
        if($cartInfo->validate() && $cartInfo->save()){
            return true;
        }
        return false;
    }
    
    /**
     * 更改购物车中产品数量
     * 
     * @return boolean
     */
    public function change(){
        $cartInfo = Cart::find()->where(['id'=>$this->cartId, 'member_id'=>$this->memberId])->one();
        if($cartInfo){
            $cartInfo->buy_count = $this->chgCount;
            if($cartInfo->save()){
                return true;
            }
        }else{
            $this->addError('cartId', '不存在的数据');
        }
        return false;
    }
    
    /**
     * 删除购物车中的产品
     * @return boolean
     */
    public function delete(){
        if(Cart::deleteAll(['id'=>$this->cartId, 'member_id'=>$this->memberId])){
            return true;
        }
        return false;
    }
}
