<?php

namespace app\controllers;

use Yii;

/**
 * 支付宝支付
 *
 * @author Administrator
 */
class AlipayController extends \yii\web\Controller {
    
    /**
     * 支付成功跳转页
     */
    public function actionSuccess() {
        $postData = $_GET;
        $alipay = Yii::$app->alipay;
        if($alipay->notify($postData)){
            $model = new \app\models\form\ChgRechargeForm();
            $model->orderNo = $postData['out_trade_no'];
            $model->orderMoney = $postData['total_amount'];
            $model->payType = 'alipay';
            $model->payNo = $postData['trade_no'];
            $model->pay();
        }
        return $this->redirect(Yii::$app->params['alipayReturnUrl']);
    }
}
