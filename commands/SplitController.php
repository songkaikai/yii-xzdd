<?php

namespace app\commands;

use yii\console\Controller;
use app\components\Tool;
use app\models\form\SplitForm;

/**
 * 静态分红
 *
 * @author Administrator
 */
class SplitController extends Controller {

    /**
     * 关闭出局的分红订单
     */
    public function actionClose() {
        $model = new SplitForm();
//        $model->splitDay = '2017-06-22';
        $model->splitDay = date('Y-m-d', strtotime('-1 day'));
        $model->closeChuju();
        Tool::log('关闭出局的分红订单', 'console');
    }

    /**
     * 订单静态分红
     */
    public function actionFengHong(){
        $model = new SplitForm();
//        $model->splitDay = '2017-06-22';
        $model->splitDay = date('Y-m-d', strtotime('-1 day'));
        $model->splitOrder();
        Tool::log('订单静态分红', 'console');
    }

    
    /**
     * 领导奖
     */
    public function actionLdj(){
        $model = new SplitForm();
//        $model->splitDay = '2017-06-22';
        $model->splitDay = date('Y-m-d', strtotime('-1 day'));
        $model->sendLdj();
        Tool::log('领导奖', 'console');
    }
}
