<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\components\BaseController;
use app\models\Member;

/**
 * @apiDefine TeamGroup
 *
 * 团队接口
 */

/**
 * 团队
 *
 * @author Administrator
 */
class TeamController extends BaseController {

    /**
     * 
     * @api {get} team/index 1、团队列表
     * @apiName 团队列表
     * @apiGroup TeamGroup
     * @apiVersion 1.0.0
     * @apiDescription 团队列表 
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
     * @apiSuccess {String} data.lists.avatar   头像
     * @apiSuccess {String} data.lists.nick_name   昵称
     * @apiSuccess {String} data.lists.uname   手机号
     * @apiSuccess {String} data.lists.depth   代数
     * @apiSuccess {String} data.lists.reg_time   注册时间
     * @apiSuccess {String} data.lists.level   会员等级
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
        $memberRoute = Yii::$app->member->identity['route'];
        $memberDepth = Yii::$app->member->identity['depth'];
        $maxDepth = $memberDepth + 10;
        $start = $this->currentPage * $this->pageSize;
        $total = Member::find()->where("route like '{$memberRoute}%' and depth > {$memberDepth} and depth < {$maxDepth}")->count();
        $sql = "select avatar, nick_name, uname, depth-{$memberDepth} as depth, reg_time, level from {{%member}} where route like '{$memberRoute}%' and depth > {$memberDepth} and depth < {$maxDepth} order by depth asc limit {$start},{$this->pageSize}";
        $record = Yii::$app->db->createCommand($sql)->queryAll();
        if($record){
            foreach($record as $key => $val){
//                $record[$key]['uname'] = preg_replace('/(\d{4})\d{4}(\d{3})/', '$1...$2', $val['uname']);
                $record[$key]['reg_time'] = date('Y-m-d', $val['reg_time']);
            }
        }
        $returnData = [
            'result' => 1,
            'tatal' => $total,
            'current' => $this->currentPage + 1,
            'pages' => ceil($total/$this->pageSize),
            'lists' => $record,
        ];
        return $returnData;
    }

}
