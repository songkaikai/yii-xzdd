<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%orders_fenghong}}".
 *
 * @property string $id
 * @property string $member_id
 * @property string $order_no
 * @property string $order_money
 * @property integer $member_paihao
 * @property string $add_time
 * @property integer $millisecond
 * @property integer $lottery_number
 * @property string $lottery_time
 * @property string $period
 * @property string $fh_money
 * @property string $day_money
 * @property string $split_time
 * @property integer $chuju
 * @property string $chuju_date
 */
class OrdersFenghong extends \yii\db\ActiveRecord {

    const WAIT = 0;
    const OPEN = 1;
    const FENGHONG = 2;
    const OVER = 8;
    const DELETE = 9;
    
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%orders_fenghong}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['member_id', 'member_paihao', 'add_time', 'millisecond', 'lottery_number', 'lottery_time', 'split_time', 'chuju', 'chuju_date'], 'integer'],
                [['order_no', 'period'], 'required'],
                [['order_money', 'fh_money', 'day_money'], 'number'],
                [['order_no', 'period'], 'string', 'max' => 30],
                [['order_no'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'member_id' => '会员ID',
            'order_no' => '订单编号',
            'order_money' => '订单金额',
            'member_paihao' => '会员订单排号',
            'add_time' => '添加时间',
            'millisecond' => '毫秒',
            'lottery_number' => '开奖号',
            'lottery_time' => '开奖时间',
            'period' => '开奖期数',
            'fh_money' => '分红金额',
            'day_money' => '当天分红金额',
            'split_time' => '最后一次分账时间',
            'chuju' => '是否出局',
            'chuju_date' => '出局时间',
        ];
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
            $orderNo = \app\components\Tool::getOrderNo($memberId, '2');
            if (!static::find()->where(['order_no' => $orderNo])->count()) {
                $flag = false;
            }
        }
        return $orderNo;
    }

    /**
     * 获取状态数据
     * 
     * @return type
     */
    public static function getStatusData(){
        return [
            self::WAIT => '待开奖',
            self::OPEN => '已开奖',
            self::FENGHONG => '收益分红',
            self::OVER => '订单完结',
            self::DELETE => '订单删除',
        ];
    }
    
    /**
     * 根据关键字获取状态名称
     * 
     * @param type $key
     * @return type
     */
    public static function getStatusNameByKey($key){
        return ArrayHelper::getValue(self::getStatusData(), $key, '');
    }
}
