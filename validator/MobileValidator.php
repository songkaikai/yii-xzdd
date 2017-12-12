<?php

namespace app\validator;

use yii\validators\Validator;

/**
 * 手机号验证
 * 
 * 移动：134、135、136、137、138、139、150、151、152、157、158、159、182、183、184、187、188、178(4G)、147(上网卡)
 * 联通：130、131、132、155、156、185、186、176(4G)、145(上网卡)
 * 电信：133、153、180、181、189 、177(4G)
 * 卫星通信：1349
 * 虚拟运营商：170
 *
 * @filename MobileValidator.php
 * @encoding UTF-8 
 * @copyright Copyright (C) 2015 浙江皮趣皮网络科技有限公司
 * @link http://www.zjpqp.com 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2015-10-20 14:37:44
 */
class MobileValidator extends Validator {

    public function init() {
        parent::init();
        $this->message = '手机号码格式不正确';
    }

    public function validateAttribute($model, $attribute) {
        $value = $model->$attribute;
        if ( ! is_numeric($value) || ! preg_match('/^1[34578][0-9]{9}$/', $value)) {
            $model->addError($attribute, $this->message);
        }
    }

    public function clientValidateAttribute($model, $attribute, $view) {
        $message = json_encode($this->message);
        return <<<JS
        var mobile_reg = /^1[34578][0-9]{9}$/;
if (!mobile_reg.test(value)) {
    messages.push($message);
}
JS;
    }

}
