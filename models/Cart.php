<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%cart}}".
 *
 * @property string $id
 * @property string $member_id
 * @property string $goods_id
 * @property string $goods_name
 * @property string $buy_count
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cart}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'goods_id', 'buy_count'], 'integer'],
            [['goods_name'], 'required'],
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
            'member_id' => '会员ID',
            'goods_id' => '产品ID',
            'goods_name' => '产品名称',
            'buy_count' => '购买数量',
        ];
    }
}
