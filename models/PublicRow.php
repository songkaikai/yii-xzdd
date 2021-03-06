<?php

namespace app\models;

use Yii;

/**
 * 公排池
 *
 * @property string $id
 * @property string $order_id
 * @property string $member_id
 * @property string $send_money
 */
class PublicRow extends \yii\db\ActiveRecord {

    public $nick_name;
    
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%public_row}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['member_id', 'is_chu', 'layer', 'parent_node', 'column'], 'integer'],
            [['send_money'], 'number'],
            [['order_id', 'parent_route'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => '公排号',
            'order_id' => '订单ID',
            'member_id' => '会员ID',
            'parent_node' => '上一级点',
            'parent_route' => '路由',
            'layer' => '层数',
            'send_money' => '发放金额',
            'is_chu' => '是否出局',
            'nick_name' => '会员昵称',
            'column' => '第几个',
        ];
    }

}
