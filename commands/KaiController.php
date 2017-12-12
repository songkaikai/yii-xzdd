<?php

namespace app\commands;

use yii\console\Controller;
use app\components\Tool;
use app\models\form\LotteryForm;

/**
 * 理财开奖
 *
 * @author Administrator
 */
class KaiController extends Controller {
    public function actionIndex(){
        if(date('H') == 0 && date('i') < 31){
            return false;
        }
        $model = new LotteryForm();
        $model->open();
        Tool::log('宝箱开奖', 'console');
    }
}
