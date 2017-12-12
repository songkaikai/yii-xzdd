<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\components\BaseController;

/**
 * @apiDefine LotteryGroup
 *
 * 中奖名单
 */

/**
 * 中奖名单
 *
 * @author Administrator
 */
class LotteryController extends BaseController {

    /**
     * 
     * @api {get} lottery/index 1、中奖名单
     * @apiName 中奖名单
     * @apiGroup LotteryGroup
     * @apiVersion 1.0.0
     * @apiDescription 中奖名单 
     * 
     * @apiParam {String} token 会员TOKEN 
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明
     * @apiSuccess {String} data   返回数据
     * @apiSuccess {String} data.period   中奖期数
     * @apiSuccess {String} data.uname   手机号
     * @apiSuccess {String} data.nick_name   昵称
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
        $sql = "select a.period, b.uname, b.nick_name from {{%lottery}} a left join {{%member}} b on a.first_member_id = b.id order by add_date desc limit 50";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }

}
