<?php

namespace app\models\form;

use Yii;
use app\models\Address;
use app\models\Orders;

/**
 * 收货地址管理
 *
 * @author Administrator
 */
class AddressForm extends \yii\base\Model {

    public $addressId;
    public $memberId;
    public $consignee;
    public $address;
    public $mobile;
    public $area;
    public $isDefault = 0;
    public $isFirst = 0;

    public function scenarios() {
        return [
            'add' => ['memberId', 'consignee', 'address', 'mobile', 'area', 'isDefault', 'addressId', 'isFirst'],
            'edit' => ['addressId', 'memberId', 'consignee', 'address', 'mobile', 'area', 'isDefault'],
            'delete' => ['addressId', 'memberId'],
        ];
    }
    
    public function rules() {
        return [
            [['memberId', 'consignee', 'address', 'mobile', 'area'], 'required', 'on' => ['add', 'edit']],
            [['addressId'], 'required', 'on'=>['edit', 'delete']],
            [['memberId', 'isDefault', 'addressId', 'isFirst'], 'integer'],
//            [['mobile'], 'app\validator\mobileValidator'],
            [['consignee', 'address', 'area'], 'string'],
        ];
    }

    public function attributeLabels() {
        return [
            'addressId' => '地址ID',
            'memberId' => '会员ID',
            'consignee' => '收货人姓名',
            'address' => '收货地址',
            'mobile' => '手机号',
            'area' => '所在地区',
            'isDefault' => '是否默认',
            'isFirst' => '是否首次被充',
        ];
    }
    
    /**
     * 添加地址
     */
    public function create(){
        $model = new Address();
        $model->attributes = [
            'member_id' => $this->memberId,
            'consignee' => $this->consignee,
            'address' => $this->address,
            'mobile' => $this->mobile,
            'area' => $this->area,
            'is_default' => $this->isDefault,
        ];
        if($model->validate() && $model->save()){
            if($this->isFirst){
                $sql = "update {{%orders}} set consignee = '{$this->consignee}', area = '{$this->area}', address = '{$this->address}', mobile = '{$this->mobile}' where member_id = {$this->memberId} and order_type = " . Orders::MEMBER_UPGRADE;
                Yii::$app->db->createCommand($sql)->execute();
            }
            $this->addressId = $model->id;
            return true;
        }
        return false;
    }
    
    public function update(){
        $model = Address::find()->where(['id'=>$this->addressId, 'member_id'=>$this->memberId])->one();
        if($model){
            $model->attributes = [
                'consignee' => $this->consignee,
                'address' => $this->address,
                'mobile' => $this->mobile,
                'area' => $this->area,
                'is_default' => $this->isDefault,
            ];
            if($model->validate() && $model->save()){
                return true;
            }
        }
        return false;
    }
    
    public function getAddressInfo(){
        $model = Address::find()->where(['id'=>$this->addressId, 'member_id'=>$this->memberId])->one();
        $this->consignee = $model->consignee;
        $this->mobile = $model->mobile;
        $this->address = $model->address;
        $this->area = $model->area;
        $this->isDefault = $model->is_default;
    }
    
    public function delete(){
        $model = Address::find()->where(['id'=>$this->addressId, 'member_id'=>$this->memberId])->one();
        if($model->is_default){
            //设置最后一个为默认
            $lastModel = Address::find()->select('id')->asArray()->where("member_id = {$this->memberId} and id != {$this->addressId}")->one();
            Address::updateAll(['is_default'=>1], "id={$lastModel['id']}");
        }
        if($model->delete()){
            return true;
        }
        return false;
    }
}
