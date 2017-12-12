<?php

namespace app\validator;

use yii\validators\Validator;

/**
 * 货币金额验证
 *
 * @filename MoneyValidator.php 
 * @encoding UTF-8 
 * @copyright Copyright (C) 2016 浙江皮趣皮网络科技有限公司
 * @link http://www.zjpqp.com 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2016-4-29 11:09:31
 */
class MoneyValidator extends Validator {

    public function init() {
        parent::init();
        $this->message = '金额格式不正确,最多两位小数';
    }

    public function validateAttribute($model, $attribute) {
        $value = $model->$attribute;
        if (!preg_match('#^(([0-9]|([1-9][0-9]{0,9}))((\.[0-9]{1,2})?))$#', $value)) {
            $model->addError($attribute, $this->message);
        }
    }

    public function clientValidateAttribute($model, $attribute, $view) {
        $message = json_encode($this->message);
        return <<<JS
        var money_reg = /^(([0-9]|([1-9][0-9]{0,9}))((\.[0-9]{1,2})?))$/;
if (!money_reg.test(value)) {
    messages.push($message);
}
JS;
    }

}
