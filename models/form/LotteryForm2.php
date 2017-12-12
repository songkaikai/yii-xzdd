<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\OrdersFenghong;
use app\models\Lottery;
use app\models\form\AccountForm;
use app\models\AccountLog;

/**
 * 理财开奖
 *
 * @author Administrator
 */
class LotteryForm extends Model {
    
    public function open(){
        if($this->getOrderCount() < 63){
            //人数不足
            return false;
        }
        $lotteryNo = $this->buildLotteryNo();
        $this->tiaopai();
        $this->paihao($lotteryNo);
        $this->sendJiang($lotteryNo);
    }
    
    /**
     * 排号
     */
    private function paihao($lotteryNo){
        $sql = "select a.id, a.member_id, b.recommender, b.route from {{%orders_fenghong}} a left join {{%member}} b on a.member_id = b.id "
                . "where a.lottery_time = 0 and a.lottery_number = 0 and a.status = 0 order by a.add_time asc, a.millisecond asc limit 63";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        if( ! $data){
            return false;
        }
        $execSql = '';
        foreach($data as $key => $val){
            $paihao = $key + 1;
            $execSql .= "update {{%orders_fenghong}} set lottery_number = {$paihao}, period = '{$lotteryNo}' where id = {$val['id']};";
            $this->sendFenxiao($val);
        }
        if( ! empty($execSql)){
            Yii::$app->db->createCommand($execSql)->execute();
        }
    }
    
    /**
     * 统计未开奖的订单数
     * 
     * @return type
     */
    private function getOrderCount(){
        return OrdersFenghong::find()->where("lottery_time = 0 and lottery_number = 0 and status = 0")->count();
    }
    
    /**
     * 发奖
     */
    private function sendJiang($lotteryNo){
        $sql = "select id, member_id, lottery_number from {{%orders_fenghong}} where period = '{$lotteryNo}' and lottery_time = 0 order by lottery_number asc limit 31";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        if( ! $data){
            return false;
        }
        $time = time();
        foreach($data as $val){
            $jiang = $this->getJiang($val['lottery_number']);
            $sql = "update {{%orders_fenghong}} set lottery_time = {$time}, fh_money = {$jiang} where id = {$val['id']}";
            Yii::$app->db->createCommand($sql)->execute();
            $this->tjj($val['member_id'], $jiang, "{$lotteryNo}中奖", AccountLog::J3);
            $this->bombingAward($val['member_id'], $jiang);
            if($val['lottery_number'] == 1){
                $sql = "update {{%lottery}} set first_member_id = {$val['member_id']} where period = '{$lotteryNo}'";
                Yii::$app->db->createCommand($sql)->execute();
            }
        }
        $sql = "update {{%orders_fenghong}} set lottery_time = {$time}, status = 1 where period = '{$lotteryNo}'";
        Yii::$app->db->createCommand($sql)->execute();
    }
    
    /**
     * 获取奖编号
     */
    private function buildLotteryNo(){
        $startDate = strtotime(date('Y-m-d'));
        $endDate = strtotime(date('Y-m-d') . ' 23:59:59');
        $todayCount = Lottery::find()->where("add_date >= {$startDate} and add_date <= {$endDate}")->count();
        $currendNo = date('Ymd') . str_pad($todayCount+1, 4, '0', STR_PAD_LEFT);
        $sql = "insert into {{%lottery}}(period, add_date, first_member_id) values('{$currendNo}', ".time().", 0)";
        Yii::$app->db->createCommand($sql)->execute();
        return $currendNo;
    }
    
    /**
     * 获取奖金
     */
    private function getJiang($paihao){
        if($paihao == 1){
            $jiang = 310;
        }elseif($paihao >= 2 && $paihao <= 3){
            $jiang = 150;
        }elseif($paihao >= 4 && $paihao <= 7){
            $jiang = 70;
        }elseif($paihao >= 8 && $paihao <= 15){
            $jiang = 30;
        }elseif($paihao >= 16 && $paihao <= 31){
            $jiang = 10;
        }else{
            $jiang = 0;
        }
        return $jiang;
    }
    
    /**
     * 轰炸奖
     * 
     * @param type $memberId
     * @param type $jiang
     */
    private function bombingAward($memberId, $jiang){
        $sql = "select id from {{%member}} where recommender = {$memberId} and level > 0 and status = 1";
        $memberList = Yii::$app->db->createCommand($sql)->queryAll();
        if( ! $memberList){
            return false;
        }
        $permoney = round($jiang * 0.1 / count($memberList), 2);
        if($permoney > 0){
            foreach($memberList as $val){
                $this->tjj($val['id'], $permoney, '轰炸奖', AccountLog::J6);
            }
        }
    }
    
    /**
     * 发放分销收益
     */
    private function sendFenxiao($memberInfo){
        if($memberInfo['recommender'] == 0){
            return false;
        }
        $routeArr = explode(',', trim($memberInfo['route'], ','));
        if(count($routeArr) > 6){
            $many = count($routeArr) - 6;
            for($i = 0; $i < $many; $i++){
                unset($routeArr[$i]);
            }
        }
        $newRoute = array_reverse($routeArr);
        unset($newRoute[0]);
        $sql = "select id, recomm_count, level from {{%member}} where id in (".implode(',', $newRoute).") order by depth desc";
        $rowNode = Yii::$app->db->createCommand($sql)->queryAll();
        foreach($rowNode as $key => $val){
            $layer = $key + 1;
            $this->tjj($val['id'], Yii::$app->params['fxMoney'][$layer], "分销收益");
        }
    }
    
    private function tjj($memberId, $money, $desc, $type=0){
        $accountModel = new AccountForm();
        $accountModel->attributes = [
            'memberId' => $memberId,
            'desc' => $desc,
            'money' => $money,
            'type' => $type,
        ];
        if($accountModel->rechargeMoney()){
            return true;
        }else{
            //错误日志
            return false;
        }
    }
    
    private function tiaopai(){
        $userId = [];
        if(count($userId) == 0){
            return true;
        }
        $sql = "select id, member_id from {{%orders_fenghong}} where lottery_time = 0 and lottery_number = 0 and status = 0 order by add_time asc, millisecond asc limit 63";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        foreach($data as $val){
            if(in_array($val['member_id'], $userId)){
                $sql = "select add_time, millisecond from {{%orders_fenghong}} where lottery_time > 0 and lottery_number > 0 order by id desc limit 1";
                $maxData = Yii::$app->db->createCommand($sql)->queryOne();
                if($maxData){
                    $millisecond = $maxData['millisecond'] + 2;
                    $sql = "update {{%orders_fenghong}} set add_time = {$maxData['add_time']}, millisecond = {$millisecond} where id = {$val['id']}";
                    Yii::$app->db->createCommand($sql)->execute();
                }
                break;
            }
        }
    }
}
