<?php

namespace app\controllers;

use Yii;
use app\components\BaseController;
use app\components\payment\WechatPay;
use app\models\Member;
use app\models\form\ChangeOrderForm;
use app\components\Tool;
use yii\helpers\Json;


/**
 * Description of NoticeController
 *
 * @filename NoticeController.php 
 * @encoding UTF-8 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2016-10-30 21:09:10
 */
class NoticeController extends BaseController {

    public function actionNotify() {
        $postData = ''; 
        if (file_get_contents("php://input")) { 
            $postData = file_get_contents("php://input"); 
        }
        $postObj = simplexml_load_string($postData, 'SimpleXMLElement', LIBXML_NOCDATA);
        Tool::log('异步通知：'. Json::encode($postObj), 'weixin');
        if ($postObj === false) {
            Tool::log('异步通知：parse xml error', 'weixin');
            die('parse xml error');
        }
        if ($postObj->return_code != 'SUCCESS') {
            Tool::log('异步通知：'.$postObj->return_msg, 'weixin');
            die($postObj->return_msg);
        }
        if ($postObj->result_code != 'SUCCESS') {
            Tool::log('异步通知：'.$postObj->err_code, 'weixin');
            die($postObj->err_code);
        }

        //微信支付参数
        $appid = Yii::$app->params['wechat']['appid'];
        $mchid = Yii::$app->params['wechat']['mchid'];
        $key = Yii::$app->params['wechat']['key'];
        $wx_pay = new WechatPay($mchid, $appid, $key);

        //验证签名
        $arr = (array) $postObj;
        unset($arr['sign']);
        unset($arr['type']);
        if ($wx_pay->getSign($arr, $key) != $postObj->sign) {
            Tool::log('异步通知：签名错误', 'weixin');
            die("签名错误");
        }

        $memberInfo = Member::find()->where(['openid'=>$postObj->openid])->one();
        if($postObj->type == 'orders'){
            $chgModel = new ChangeOrderForm();
            $chgModel->memberId = $memberInfo['id'];
            $chgModel->orderNo = $postObj->out_trade_no;
            if($chgModel->chgToPay()){
                return '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
            }
        }
        //订单状态已更新，直接返回
        return '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
    }

    /**
     * 支付宝异步通知
     */
    public function actionAlipay(){
        $postData = $_POST;
        $alipay = Yii::$app->alipay;
        Tool::log('异步通知：'. Json::encode($postData), 'alipay');
        if($alipay->notify($postData)){
            $tradeStatus = $postData['trade_status'];
            if($tradeStatus === 'TRADE_SUCCESS' || $tradeStatus === 'TRADE_FINISHED'){
                //付款成功
                $model = new \app\models\form\ChgRechargeForm();
                $model->orderNo = $postData['out_trade_no'];
                $model->orderMoney = $postData['total_amount'];
                $model->payType = 'alipay';
                $model->payNo = $postData['trade_no'];
                $model->pay();
            }
            echo "success";
        }
        echo "fail";
    }
}
