<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\OrdersFenghong;
use app\models\form\LotteryForm;
use app\models\AccountLog;
use app\models\Member;

/**
 * 关闭未满足开奖条件的宝箱
 *
 * @author Administrator
 */
class LicaiCloseForm extends Model {

    public $splitDay;

    public function rules() {
        return [
                [['splitDay'], 'required'],
                [['splitDay'], 'integer']
        ];
    }

    public function attributeLabels() {
        return [
            'splitDay' => '统计日期',
        ];
    }

    public function close(){
        $startUnix = strtotime($this->splitDay);
        $endUnix = strtotime($this->splitDay . ' 23:59:59');
        $this->lottery($endUnix);
        $this->deleteOrder($endUnix);
        return true;
    }
    
    /**
     * 订单退款
     * 
     * @param type $endUnix
     * @return boolean
     */
    private function deleteOrder($endUnix){
        $sql = "select id, member_id, order_no, order_money from {{%orders_fenghong}} where status = 0 and lottery_time = 0 and lottery_number = 0 and add_time <= {$endUnix}";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        if( ! $data){
            return true;
        }
        $execSql = '';
        foreach($data as $val){
            if($this->recharge($val['member_id'], $val['order_money'], $val['order_no'] . '自动退款')){
                $execSql .= "update {{%orders_fenghong}} set status = 9 where id = {$val['id']};";
            }
        }
        if( ! empty($execSql)){
            Yii::$app->db->createCommand($execSql)->execute();
        }
    }
    
    /**
     * 对当天满足条件的进行开奖
     * 
     * @param type $endUnix
     */
    private function lottery($endUnix){
        $flag = true;
        while($flag){
            if($this->getOrderCount($endUnix) < 63){
                $flag = false;
            }
            $this->kaijiang();
        }
    }
    
    private function kaijiang(){
        $model = new LotteryForm();
        $model->open();
        return true;
    }
    
    /**
     * 统计未开奖的订单数
     * 
     * @return type
     */
    private function getOrderCount($endUnix){
        return OrdersFenghong::find()->where("lottery_time = 0 and lottery_number = 0 and status = 0 and add_time <= {$endUnix}")->count();
    }
    
    /**
     * 账户充值
     * 
     * @return boolean
     */
    public function recharge($memberId, $money, $desc = ''){
        $userModel = Member::find()->select('id, balance, nick_name')->asArray()->where(['id'=>$memberId])->one();
        $blance = $userModel['balance'] + $money;
        $addTime = time();
        //添加账户变动日志
        $sql1 = "INSERT INTO {{%account_log}}(`member_id`, `type`, `in`, `balance`, `desc`, `add_date`) VALUES({$userModel['id']}, ".AccountLog::J13.", {$money}, {$blance}, '{$desc}', {$addTime})";
        //更改账户余额
        $sql2 = "UPDATE {{%member}} SET balance = balance + {$money} WHERE id = {$userModel['id']}";
        $connection = \Yii::$app->db;
        
        $transaction = $connection->beginTransaction();
        try {
            $connection->createCommand($sql1)->execute();
            $connection->createCommand($sql2)->execute();
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
}
