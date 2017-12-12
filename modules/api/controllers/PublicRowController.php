<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\components\BaseController;
use app\models\PublicRow;
use app\models\PublicRowB;

/**
 * @apiDefine PublicRowGroup
 *
 * 公排接口
 */

/**
 * Description of PublicRowController
 *
 * @author Administrator
 */
class PublicRowController extends BaseController {

    /**
     * 
     * @api {post} public-row/index 1、A网公排
     * @apiName 1、A网公排 
     * @apiGroup PublicRowGroup
     * @apiVersion 1.0.0
     * @apiDescription A网公排
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
     * @apiSuccess {String} data.lists.send_money 已发金额
     * @apiSuccess {String} data.lists.layer 第几层
     * @apiSuccess {String} data.lists.column 第几列
     * @apiSuccess {String} data.lists.is_chu 是否出局
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
        $where = ['member_id'=>Yii::$app->member->id];
        $total = PublicRow::find()->where($where)->count();
        $rowList = PublicRow::find()
                ->select('send_money, layer, column, is_chu')
                ->asArray()
                ->where($where)
                ->orderBy('id asc')
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

    /**
     * 
     * @api {post} public-row/blist 2、B网公排
     * @apiName 2、B网公排 
     * @apiGroup PublicRowGroup
     * @apiVersion 1.0.0
     * @apiDescription B网公排
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
     * @apiSuccess {String} data.lists.send_money 已发金额
     * @apiSuccess {String} data.lists.layer 第几层
     * @apiSuccess {String} data.lists.column 第几列
     * @apiSuccess {String} data.lists.is_chu 是否出局
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
    public function actionBlist() {
        $where = ['member_id'=>Yii::$app->member->id];
        $total = PublicRowB::find()->where($where)->count();
        $rowList = PublicRowB::find()
                ->select('send_money, layer, column, is_chu')
                ->asArray()
                ->where($where)
                ->orderBy('id asc')
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
