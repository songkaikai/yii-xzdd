<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%account_log}}".
 *
 * @property string $id
 * @property string $member_id
 * @property integer $type
 * @property string $in
 * @property string $out
 * @property string $balance
 * @property string $desc
 * @property string $order_no
 * @property string $add_date
 */
class AccountLog extends \yii\db\ActiveRecord {

    const J1 = 1;
    const J2 = 2;
    const J3 = 3;
    const J4 = 4;
    const J5 = 5;
    const J6 = 6;
    const J7 = 7;
    const J8 = 8;
    const J9 = 9;
    const J10 = 10;
    const J11 = 11;
    const J12 = 12;
    const J13 = 13;
    
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%account_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['member_id', 'type', 'add_date'], 'integer'],
            [['in', 'out', 'balance'], 'number'],
            [['desc'], 'string', 'max' => 100],
            [['order_no'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'member_id' => '会员ID',
            'type' => '日志类型',
            'in' => '入账',
            'out' => '出账',
            'balance' => '累计结余',
            'desc' => '说明',
            'order_no' => '订单号',
            'add_date' => '添加时间',
        ];
    }

    /**
     * 获取类型值
     * @return type
     */
    public static function getTypeData(){
        return [
            self::J1 => '推荐奖',
            self::J2 => 'A公排见点奖',
            self::J3 => '中奖',
            self::J4 => '静态分红',
            self::J5 => '分销收益',
            self::J6 => '轰炸奖',
            self::J7 => '领导奖',
            self::J8 => 'B公排见点奖',
            self::J9 => '转账',
            self::J10 => '充值',
            self::J11 => '开户充值',
            self::J12 => '后台充值',
            self::J13 => '退款',
        ];
    }
    
    /**
     * 根据主键获取类型值
     * 
     * @param type $key
     * @return type
     */
    public static function getTypeByKey($key){
        return ArrayHelper::getValue(self::getTypeData(), $key, '');
    }
    
    /**
     * 获取操作类型主键
     * 
     * @return type
     */
    public function getTypeKeys(){
        return array_keys(self::getTypeData());
    }
}
