<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%lottery}}".
 *
 * @property string $period
 * @property string $add_date
 * @property string $first_member_id
 */
class Lottery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lottery}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['period', 'add_date'], 'required'],
            [['add_date', 'first_member_id'], 'integer'],
            [['period'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'period' => '开奖期数',
            'add_date' => '开奖时间',
            'first_member_id' => '头奖会员',
        ];
    }
}
