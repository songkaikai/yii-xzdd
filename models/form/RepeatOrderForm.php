<?php

namespace app\models\form;

use app\models\Member;
use app\models\form\ChangeOrderForm;
use yii\helpers\ArrayHelper;
use app\models\Address;
use app\models\form\CreateOrderForm;

/**
 * 订单复投
 *
 * @author xxx
 */
class RepeatOrderForm extends \yii\base\Model {

    public $mobile;
    public $goodsId;
    public $memberId;
    public $payPass;

    public function rules() {
        return [
            [['mobile', 'goodsId', 'payPass'], 'required'],
            [['memberId', 'goodsId'], 'integer'],
//            ['mobile', 'app\validator\MobileValidator'],
            ['mobile', 'validateUname'],
            ['payPass', 'validatePaypass'],
        ];
    }

    public function validatePaypass($attribute, $params) {
        if (!$this->hasErrors()) {
            if (md5($this->payPass) !== 'c804e83379c919992e640839e10d5eb8') {
                $this->addError($attribute, '支付密码错误');
            }
        }
    }
    
    public function validateUname($attribute, $params) {
        if (!$this->hasErrors()) {
            $count = Member::find()->where(['uname' => $this->mobile])->count();
            if ($count == 0) {
                $this->addError($attribute, '不存在的会员');
            }
        }
    }

    public function attributeLabels() {
        return [
            'mobile' => '手机号',
            'memberId' => '会员ID',
            'goodsId' => '产品ID',
            'payPass' => '支付密码',
        ];
    }

    /**
     * 复投订单
     */
    public function repeat() {
        $memberInfo = Member::find()->asArray()->where(['uname' => $this->mobile])->one();
        if ($memberInfo) {
            $this->createOrder($memberInfo['id']);
            return true;
        }
        return false;
    }

    /**
     * 创建订单
     */
    private function createOrder($memberId) {
        $model = new CreateOrderForm();
        $model->attributes = [
            'memberId' => $memberId,
            'goodId' => $this->goodsId,
            'buyCount' => 1,
            'addressId' => 1,
        ];
        if ($model->save()) {
            $paymodel = new ChangeOrderForm();
            $paymodel->attributes = [
                'memberId' => $memberId,
                'orderNo' => $model->orderInfo['order_no'],
            ];
            if ($paymodel->chgToPay()) {
                return true;
            }
        }
        return false;
    }

}
