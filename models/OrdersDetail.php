<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%orders_detail}}".
 *
 * @property string $id
 * @property string $order_no
 * @property string $goods_id
 * @property string $goods_name
 * @property string $price
 * @property string $buy_count
 * @property string $total
 */
class OrdersDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%orders_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_no'], 'required'],
            [['goods_id', 'buy_count'], 'integer'],
            [['price', 'total'], 'number'],
            [['order_no'], 'string', 'max' => 32],
            [['goods_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => '订单编号',
            'goods_id' => '产品ID',
            'goods_name' => '产品名称',
            'price' => '单价',
            'buy_count' => '购买数量',
            'total' => '小计',
        ];
    }
}
