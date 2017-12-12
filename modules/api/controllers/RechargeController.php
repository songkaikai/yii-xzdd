<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\components\BaseController;
use app\models\form\RechargeForm;
use yii\helpers\Url;
use app\models\Recharge;
/**
 * @apiDefine RechargeGroup
 *
 * 充值订单接口
 */
/**
 * Description of RechargeController
 *
 * @author Administrator
 */
class RechargeController extends BaseController {

    /**
     * 
     * @api {get} recharge/index 1、获取充值单列表
     * @apiName 获取充值单列表
     * @apiGroup RechargeGroup
     * @apiVersion 1.0.0
     * @apiDescription 获取充值单列表 
     * 
     * @apiParam {String} token 会员TOKEN 
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明 
     * @apiSuccess {String} data 
     * @apiSuccess {String} data.total   总记录数
     * @apiSuccess {String} data.pageSize   每页显示数量
     * @apiSuccess {String} data.currentPage   当前页
     * @apiSuccess {String} data.lists   日志详情
     * @apiSuccess {String} data.lists.order_no    订单号
     * @apiSuccess {String} data.lists.recharge_money   充值金额
     * @apiSuccess {String} data.lists.statusName   状态
     * @apiSuccess {String} data.lists.add_time   时间
     * 
     * @apiSuccessExample 成功返回样例: 
     *  HTTP/1.1 200 OK 
     * { 
     * code:200, 
     * data:'', 
     * message:''
     *  } 
     *    
     */
    public function actionIndex() {
        $total = Recharge::find()->where(['member_id' => Yii::$app->member->id])->count();
        $logList = Recharge::find()->select('order_no, recharge_money, add_time, pay_type, status')->asArray()->where(['member_id' => Yii::$app->member->id])->orderBy('id desc')->limit($this->pageSize)->offset($this->currentPage * $this->pageSize)->all();
        if($logList){
            foreach($logList as $key => $val){
                $logList[$key]['statusName'] = $val['status'] ? '成功' : '待付款';
                $logList[$key]['add_time'] = date('m-d', $val['add_time']);
            }
        }
        $returnData = [
            'total' => $total,
            'pageSize' => $this->pageSize,
            'currentPage' => $this->currentPage+1,
            'lists' => $logList,
            'status' => 1,
        ];
        return $returnData;
    }

    /**
     * 
     * @api {post} recharge/create 2、添加充值订单
     * @apiName 添加充值订单
     * @apiGroup RechargeGroup
     * @apiVersion 1.0.0
     * @apiDescription 添加充值订单 
     * 
     * @apiParam {String} token 会员TOKEN
     * @apiParam {integer} rechargeMoney 充值金额
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明 
     * @apiSuccess {String} data 支付宝支付串 
     * 
     * @apiSuccessExample 成功返回样例: 
     *  HTTP/1.1 200 OK 
     * { 
     * code:200, 
     * data:'', 
     * message:''
     *  } 
     *    
     */
    public function actionCreate() {
        $model = new RechargeForm();
        if($model->load(Yii::$app->request->post(), '')){
            $model->memberId = Yii::$app->member->id;
            if($model->validate() && $model->save()){
                $alipayForm = $this->buildPayStr($model->orderNo, $model->rechargeMoney);
                return $alipayForm;
            }
        }
        $this->buildValidateError($model->getFirstError('rechargeMoney'));
    }

    private function buildPayStr($orderNo, $orderMoney){
        $alipay = Yii::$app->alipay;
        $returnUrl = Url::toRoute(['/alipay/success'], true);
        $notifyUrl = Url::toRoute(['/notice/alipay'], true);
        return $alipay->tradeAppPay('购买血战币', $orderMoney, $orderNo, $returnUrl, $notifyUrl);
    }
}
