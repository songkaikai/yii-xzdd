<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\components\BaseController;
use app\models\AccountLog;
use app\models\form\AccountForm;

/**
 * @apiDefine AccountGroup
 *
 * 账户日志
 */

/**
 * Description of AccountController
 *
 * @author Administrator
 */
class AccountController extends BaseController {

    /**
     * 
     * @api {get} account/index 1、账户日志
     * @apiName 账户日志
     * @apiGroup AccountGroup
     * @apiVersion 1.0.0
     * @apiDescription 账户日志 
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
     * @apiSuccess {String} data.lists.in   进账
     * @apiSuccess {String} data.lists.out   出账
     * @apiSuccess {String} data.lists.desc   说明
     * @apiSuccess {String} data.lists.add_date   时间
     * @apiSuccess {String} data.lists.type   类型
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
        $total = AccountLog::find()->where(['member_id' => Yii::$app->member->id])->count();
        $logList = AccountLog::find()->select('type, in, out, desc, add_date')
                ->asArray()
                ->where(['member_id' => Yii::$app->member->id])
                ->orderBy('id desc')
                ->limit($this->pageSize)
                ->offset($this->currentPage * $this->pageSize)
                ->all();
        if($logList){
            foreach($logList as $key => $val){
                $logList[$key]['type'] = AccountLog::getTypeByKey($val['type']);
                $logList[$key]['add_date'] = date('Y-m-d', $val['add_date']);
            }
        }
        $returnData = [
            'total' => $total,
            'pageSize' => $this->pageSize,
            'currentPage' => $this->currentPage,
            'lists' => $logList,
            'status' => 1,
        ];
        return $returnData;
    }

    /**
     * 
     * @api {get} account/trans 2、会员账户转账
     * @apiName 会员账户转账
     * @apiGroup AccountGroup
     * @apiVersion 1.0.0
     * @apiDescription 会员账户转账，目前只支持向直推会员转账 
     * 
     * @apiParam {String} token 会员TOKEN 
     * @apiParam {String} targetMobile 收款人手机号
     * @apiParam {String} money 转账金额
     * @apiParam {String} desc 转账说明
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
    public function actionTrans(){
        $model = new AccountForm();
        $model->scenario = 'trans';
        if(empty(Yii::$app->request->post('targetMobile'))){
            $this->buildValidateError('收款人不可为空');
        }
        if($model->load(Yii::$app->request->post(), '')){
            $model->memberId = Yii::$app->member->id;
            //获取收款人信息
//            $sql = "select id from {{%member}} where uname = '" . Yii::$app->request->post('targetMobile') . "' and recommender = " . Yii::$app->member->id;
            $sql = "select id from {{%member}} where uname = '" . Yii::$app->request->post('targetMobile') . "'";
            $targetUser = Yii::$app->db->createCommand($sql)->queryOne();
            if( ! $targetUser){
                $this->buildValidateError('不存在的收款人');
            }
            $model->targetId = $targetUser['id'];
            if($model->trans()){
                return [];
            }
        }
        $this->buildValidateError($model->getFirstErrors());
    }
    
    /**
     * 
     * @api {get} account/tongji 3、获取业绩统计数据
     * @apiName 获取业绩统计数据
     * @apiGroup AccountGroup
     * @apiVersion 1.0.0
     * @apiDescription 获取业绩统计数据 
     * 
     * @apiParam {String} token 会员TOKEN 
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明
     * @apiSuccess {String} data   返回数据
     * @apiSuccess {String} data.1   推荐奖
     * @apiSuccess {String} data.2   A公排见点奖
     * @apiSuccess {String} data.3   中奖
     * @apiSuccess {String} data.4   静态分红
     * @apiSuccess {String} data.5   分销收益
     * @apiSuccess {String} data.6   轰炸奖
     * @apiSuccess {String} data.7   领导奖
     * @apiSuccess {String} data.8   B公排见点奖
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
    public function actionTongji(){
        $result = [];
        $sql = "select `type`, sum(`in`) as total from {{%account_log}} where member_id = " . Yii::$app->member->id . " and `type` > 0 and `in` > 0 group by `type`";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        if($data){
            foreach($data as $val){
                $result[$val['type']] = $val['total'];
            }
        }
        return $result;
    }
}
