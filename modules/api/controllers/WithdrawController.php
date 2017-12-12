<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\components\BaseController;
use app\models\form\WithdrawForm;
use app\models\Withdraw;

/**
 * @apiDefine WithdrawGroup
 *
 * 提现管理
 */

/**
 * Description of WithdrawController
 *
 * @author Administrator
 */
class WithdrawController extends BaseController {

    /**
     * 
     * @api {get} withdraw/index 1、会员提现记录
     * @apiName 会员提现记录
     * @apiGroup WithdrawGroup
     * @apiVersion 1.0.0
     * @apiDescription 会员提现记录 
     * 
     * @apiParam {String} token 会员TOKEN 
     * @apiParam {String} [pages] 当前页
     * @apiParam {String} [pageSize] 每页显示数量
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明
     * @apiSuccess {String} data   返回数据
     * @apiSuccess {String} data.total   总记录数
     * @apiSuccess {String} data.pageSize   每页显示数量
     * @apiSuccess {String} data.currentPage   当前页
     * @apiSuccess {String} data.lists   日志详情
     * @apiSuccess {String} data.lists.draw_money   提现金额
     * @apiSuccess {String} data.lists.add_time   提现时间
     * @apiSuccess {String} data.lists.statusName   状态
     * @apiSuccess {String} data.lists.withdraw_type   提现类型 alipay 支付宝 bank 银行卡
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
        $total = Withdraw::find()->where(['member_id' => Yii::$app->member->id])->count();
        $logList = Withdraw::find()->select('draw_money, add_time, status, withdraw_type')->asArray()->where(['member_id' => Yii::$app->member->id])->orderBy('id desc')->limit($this->pageSize)->offset($this->currentPage * $this->pageSize)->all();
        if($logList){
            foreach($logList as $key => $val){
                $logList[$key]['statusName'] = Withdraw::getStatusValByKey($val['status']);
                $logList[$key]['add_time'] = date('Y-m-d', $val['add_time']);
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
     * @api {get} withdraw/create 2、创建会员提现记录
     * @apiName 创建会员提现记录
     * @apiGroup WithdrawGroup
     * @apiVersion 1.0.0
     * @apiDescription 创建会员提现记录
     * 
     * @apiParam {String} token 会员TOKEN 
     * @apiParam {String} drawMoney 提现金额
     * @apiParam {String} withdrawType 提现方式 alipay 支付宝 bank 银行卡
     * @apiParam {String} bankName 开户行
     * @apiParam {String} cardNo 卡号
     * @apiParam {String} trueName 真实姓名
     * @apiParam {String} alipayNo 支付宝账号
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明
     * @apiSuccess {String} data   返回数据
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
    public function actionCreate(){
        $model = new WithdrawForm();
        if ($model->load(Yii::$app->request->post(), '')) {
            $model->memberId = Yii::$app->member->id;
            if ($model->validate() && $model->save()) {
                return [];
            }
        }
        $this->buildValidateError($model->getFirstErrors());
    }

}
