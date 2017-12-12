<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\components\BaseController;
use app\models\form\LicaiForm;

/**
 * @apiDefine LicaiOrderGroup
 *
 * 血战订单接口
 */

/**
 * 理财订单
 *
 * @filename LicaiOrderController.php 
 * @encoding UTF-8 
 * @copyright Copyright (C) 2017 免蛋生活
 * @link http://www.meggLife.com 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2017-6-18 17:30:13
 */
class LicaiOrderController extends BaseController {

    /**
     * 
     * @api {get} licai-order/index 1、获取会员已购买的血战单
     * @apiName 获取会员已购买的血战单
     * @apiGroup LicaiOrderGroup
     * @apiVersion 1.0.0
     * @apiDescription 获取会员已购买的血战单 
     * 
     * @apiParam {String} token 会员TOKEN 
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明 
     * @apiSuccess {String} data 
     * @apiSuccess {String} data.order_no 订单编号
     * @apiSuccess {String} data.member_paihao 宝箱序号
     * @apiSuccess {String} data.add_time 购买时间
     * @apiSuccess {String} data.lottery_number 中奖号
     * @apiSuccess {String} data.lottery_time 开奖时间
     * @apiSuccess {String} data.period 开奖期数
     * @apiSuccess {String} data.lottery_name 所中奖项
     * @apiSuccess {String} data.fh_money 已分金额
     * @apiSuccess {String} data.day_money 今日分金额
     * @apiSuccess {String} data.status 状态 0 待开奖 1 已开奖 2 分红中 8 交易完成 9 删除 
     * @apiSuccess {String} data.frequency 出局次数
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
        $sql = "select order_no, member_paihao, add_time, millisecond, lottery_number, lottery_time, period, fh_money, day_money, status, frequency "
                . "from {{%orders_fenghong}} where member_id = " . Yii::$app->member->id . " and status < 8 order by member_paihao asc";
        $record = Yii::$app->db->createCommand($sql)->queryAll();
        if( ! $record){
            foreach($record as $key => $val){
                $record[$key]['add_time'] = date('Y-m-d H:i:s', $val['add_time']) . ' ' . $val['millisecond'];
                $record[$key]['lottery_time'] = date('Y-m-d H:i:s', $val['lottery_time']);
                $record[$key]['lottery_name'] = $this->getJiangName($val['lottery_number']);
                unset($record[$key]['millisecond']);
            }
        }
        return $record;
    }
    
    /**
     * 获取中奖名称
     */
    private function getJiangName($paihao){
        if($paihao == 1){
            $jiangName = '一等奖';
        }elseif($paihao >= 2 && $paihao <= 3){
            $jiangName = '二等奖';
        }elseif($paihao >= 4 && $paihao <= 7){
            $jiangName = '三等奖';
        }elseif($paihao >= 8 && $paihao <= 15){
            $jiangName = '四等奖';
        }elseif($paihao >= 16 && $paihao <= 31){
            $jiangName = '五等奖';
        }else{
            $jiangName = '';
        }
        return $jiangName;
    }

    /**
     * 
     * @api {post} licai-order/create 2、添加血战订单
     * @apiName 添加血战订单
     * @apiGroup LicaiOrderGroup
     * @apiVersion 1.0.0
     * @apiDescription 添加血战订单 
     * 
     * @apiParam {String} token 会员TOKEN
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明 
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
        $model = new LicaiForm();
        if($model->load(Yii::$app->request->post(), '')){
            $model->memberId = Yii::$app->member->id;
            if($model->validate() && $model->build()){
                return [];
            }
        }
        $this->buildValidateError($model->getFirstError('memberId'));
    }

}
