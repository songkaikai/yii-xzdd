<?php

namespace app\models;

use Yii;
use app\components\AppActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $name
 * @property string $label
 * @property string $value
 * @property integer $created_at
 * @property integer $updated_at
 */
class Config extends AppActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['name', 'label', 'value'], 'required'],
                ['name', 'string', 'max' => 20],
                ['label', 'string', 'max' => 50],
                ['value', 'string', 'max' => 3000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => '配置字段',
            'label' => '配置字段名',
            'value' => '配置值',
            'created_at' => '创建时间',
            'updated_at' => '最后修改',
        ];
    }

    /**
     * 获取配置值
     * 
     * @param type $no
     */
    public static function getConfigVal($no) {
        $configVal = Yii::$app->cache->get($no);
        if (!$configVal) {
            $record = static::find()->asArray()->where(['name' => $no])->one();
            $configVal = ArrayHelper::getValue($record, 'value', '');
            Yii::$app->cache->set($no, $configVal, 3600 * 365);
        }
        return $configVal;
    }

}
