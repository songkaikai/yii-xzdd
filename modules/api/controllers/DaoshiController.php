<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\components\BaseController;
use app\models\Daoshituan;

/**
 * @apiDefine DaoshiGroup
 *
 * 导师接口
 */

/**
 * Description of PublicRowController
 *
 * @author Administrator
 */
class DaoshiController extends BaseController {

    /**
     * 
     * @api {post} daoshi/index 1、导师团
     * @apiName 1、导师团 
     * @apiGroup DaoshiGroup
     * @apiVersion 1.0.0
     * @apiDescription 导师团
     * 
     * @apiParam {String} token 会员TOKEN
     * @apiParam {integer} [pages] 当前页
     * @apiParam {integer} [pageSize] 每页显示数量 
     *  
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明
     * @apiSuccess {Object} data
     * @apiSuccess {String} data.total   总记录数
     * @apiSuccess {String} data.pageSize   每页显示数量
     * @apiSuccess {String} data.currentPage   当前页
     * @apiSuccess {String} data.lists   详情
     * @apiSuccess {String} data.lists.nick_name 昵称
     * @apiSuccess {String} data.lists.wechat_no 微信号
     * @apiSuccess {String} data.lists.wechat_code 微信二维码
     * @apiSuccess {String} data.lists.avatar 头像
     * @apiSuccess {String} data.lists.team_name 团队名称
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
        $total = Daoshituan::find()->count();
        $rowList = Daoshituan::find()
                ->select('nick_name, wechat_no, wechat_code, avatar, team_name')
                ->asArray()
                ->orderBy('sorts desc')
                ->limit($this->pageSize)
                ->offset($this->currentPage * $this->pageSize)
                ->all();
        $returnData = [
            'total' => $total,
            'pageSize' => $this->pageSize,
            'currentPage' => $this->currentPage+1,
            'lists' => $rowList,
        ];
        return $returnData;
    }
}
