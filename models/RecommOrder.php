<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%recomm_order}}".
 *
 * @property string $id
 * @property string $today
 * @property string $member_id
 * @property string $recom
 */
class RecommOrder extends \yii\db\ActiveRecord {

    public $nick_name;
    public $avatar;
    
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%recomm_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['today', 'member_id', 'recom'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'today' => '统计日期',
            'member_id' => '会员ID',
            'nick_name' => '昵称',
            'recom' => '推荐数量',
        ];
    }

}
