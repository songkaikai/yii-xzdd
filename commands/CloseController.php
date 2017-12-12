<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\components\Tool;
use app\models\form\LicaiCloseForm;

/**
 * 关闭当天未满足开奖条件的订单
 *
 * @author Administrator
 */
class CloseController extends Controller {

    /**
     * 关闭未满足开奖条件的宝箱
     */
    public function actionIndex() {
        $model = new LicaiCloseForm();
        $model->splitDay = date('Y-m-d', strtotime('-1 day'));
        $model->close();
        Tool::log('关闭未满足开奖条件的宝箱', 'console');
    }

}
