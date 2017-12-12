<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\Recharge;

/**
 * 充值表单
 *
 * @author Administrator
 */
class RechargeForm extends Model {

    public $memberId;
    public $rechargeMoney;
    public $orderNo;

    public function rules() {
        return [
            [['memberId', 'rechargeMoney'], 'required'],
            [['memberId', 'rechargeMoney'], 'integer'],
            ['rechargeMoney', 'integer', 'min' => 1],
            ['orderNo', 'string'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'memberId' => '会员ID',
            'rechargeMoney' => '充值金额',
        ];
    }
    
    /**
     * 保存
     * @return boolean
     */
    public function save(){
        $model = new Recharge();
        $model->attributes = [
            'member_id' => $this->memberId,
            'recharge_money' => $this->rechargeMoney,
        ];
        if($model->validate() && $model->save()){
            $this->orderNo = $model->order_no;
            return true;
        }
        return false;
    }
}
