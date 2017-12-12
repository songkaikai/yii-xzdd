<?php

namespace app\modules\backend\controllers;

use Yii;
use app\modules\backend\components\BackendController;
use app\modules\backend\models\WithdrawSearch;
use app\models\Withdraw;
use app\components\payment\WechatCash;

/**
 * 提现管理
 *
 * @author Administrator
 */
class WithdrawController extends BackendController {

    public function actionIndex() {
        $searchModel = new WithdrawSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $page = intval(Yii::$app->request->get('page'));
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 发放红包
     * 
     * @param type $withdrawId
     */
    public function actionSendRed($id){
        $withdrawInfo = Withdraw::find()->asArray()->where(['id'=>$id, 'status'=>0])->one();
        if($withdrawInfo){
            $memberInfo = \app\models\Member::findOne($withdrawInfo['member_id']);
            if($memberInfo->status == 0){
                $this->addFlash('会员已锁定，无需发放', 'error');
            }else{
                $cashModel = new WechatCash();
                $result = $cashModel->send($withdrawInfo['id'], $withdrawInfo['member_id'], $withdrawInfo['pay_money']);
                if($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
                    //成功
                    $sql = "update {{%withdraw}} set pay_no = '{$result['send_listid']}', cash_time = " . time() . ", status = " . Withdraw::SUCCESS . " where id = {$id}";
                    \Yii::$app->db->createCommand($sql)->execute();
                    $this->addFlash('发放成功', 'success');
                }else{
    //                $this->errorMsg = $result['return_msg'];
                    $result['err_code'] = 'SYSTEMERROR';
                    //提现失败，添加日志
                    \app\components\Tool::log(json_encode($result), 'cash');
                    $this->addFlash($result['return_msg'], 'error');
    //                $errorCode = ['SYSTEMERROR', 'NOTENOUGH', 'PROCESSING'];
    //                if( ! in_array($result['err_code'], $errorCode)){
    //                    $sql1 = "UPDATE {{%withdraw}} SET status = " . Withdraw::CLOSE . " WHERE id = {$orderId}";
    //                    $sql2 = "UPDATE {{%member}} set balance = balance + {$money} where id = {$memberId}";
    //                    $connection = \Yii::$app->db;
    //                    $transaction = $connection->beginTransaction();
    //                    try {
    //                        $connection->createCommand($sql1)->execute();
    //                        $connection->createCommand($sql2)->execute();
    //                        $transaction->commit();
    //                        return false;
    //                    } catch (Exception $e) {
    //                        $transaction->rollBack();
    //                        \common\components\Tool::log("返钱失败|{$sql1}|{$sql2}", 'cash');
    //                        return false;
    //                    }
    //                }
                }
            }
        }else{
            $this->addFlash('不存在的提现单', 'error');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    
    /**
     * 手动处理
     * 
     * @param type $id
     * @return type
     */
    public function actionChuli($id) {
        $sql = "select a.id, a.draw_money, a.pay_money, a.status, a.withdraw_type, a.bank_name, a.card_no, a.true_name, a.alipay_no, a.friend_no, b.nick_name, b.uname from {{%withdraw}} a left join {{%member}} b on a.member_id = b.id where a.id = {$id}";
        $record = Yii::$app->db->createCommand($sql)->queryOne();
        return $this->render('chuli', [
            'model' => $record,
            'lastpage' => urlencode(Yii::$app->request->referrer),
        ]);
    }
    
    public function actionConfirm($id, $lastpage, $dialog = 1) {
        $model = Withdraw::findOne($id);
        if ($model->status == 0) {
            $model->status = 8;
            $model->cash_time = time();
            $model->pay_no = Yii::$app->request->post("invoice_no");
            if ($model->save()) {
                //同步支付订单状态
                $this->showFlash('处理成功', 'success');
                return $this->redirect(urldecode($lastpage));
//                return $this->redirect(['index']);
            } else {
                $this->showFlash('处理失败', 'error');
                return $this->redirect(urldecode($lastpage));
            }
        } else {
            $this->showFlash('该订单目前是不可以处理', 'error');
            return $this->redirect(urldecode($lastpage));
        }
    }
}
