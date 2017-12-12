<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property string $id
 * @property string $member_id
 * @property string $consignee
 * @property string $address
 * @property string $mobile
 * @property string $area
 * @property integer $is_default
 */
class Address extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['member_id', 'is_default'], 'integer'],
                [['consignee', 'area'], 'string', 'max' => 50],
                [['address'], 'string', 'max' => 100],
                [['mobile'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'member_id' => '会员ID',
            'consignee' => '收货人姓名',
            'address' => '收货地址',
            'mobile' => '手机号',
            'area' => '所在地区',
            'is_default' => '是否默认',
        ];
    }

    public function afterSave($insert, $changedAttributes) {
        if($this->is_default){
            //去除其它默认的
            static::updateAll(['is_default'=>0], 'member_id= '.$this->member_id.' and id!='.$this->id);
        }elseif(static::find()->where(['member_id'=>$this->member_id, 'is_default'=>1])->count() == 0){
            static::updateAll(['is_default'=>1], 'id='.$this->id);
        }
    }
    
    /**
     * 设置默认快递
     */
    public static function setDefault($memberId, $addressId){
        static::updateAll(['is_default'=>0], 'member_id= '.$memberId);
        static::updateAll(['is_default'=>1], 'id='.$addressId);
    }
}
