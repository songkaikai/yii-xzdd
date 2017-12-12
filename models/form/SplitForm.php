<?php

namespace app\models\form;

use Yii;
use app\models\form\AccountForm;
use app\models\AccountLog;

/**
 * 静态分红
 *
 * @author Administrator
 */
class SplitForm {
    
    public $splitDay;

    public function rules() {
        return [
            [['splitDay'], 'required'],
            [['splitDay'], 'integer']
        ];
    }
    
    public function attributeLabels() {
        return [
            'splitDay' => '分账日期',
        ];
    }
    
    /**
     * 关闭出局订单
     */
    public function closeChuju(){
        $sql = "update {{%orders_fenghong}} set chuju = 1, chuju_date = ".time().", day_money = 0, status = 8 where fh_money >= 150 and chuju = 0;";
        $sql .= "update {{%member}} set day_fenghong = 0 where day_fenghong > 0;";
        $sql .= "update {{%orders_fenghong}} set status = 2 where status = 1 and lottery_number > 0;";
        Yii::$app->db->createCommand($sql)->execute();
        return true;
    }
    
    /**
     * 静态收益
     */
    public function splitOrder(){
        $perMoney = 7.5;
        $maxMoney = 150;
        $this->fenghong($perMoney, $maxMoney);
        return true;
    }
    
    /**
     * 分红
     * 
     * @param type $orderType
     * @param type $perMoney
     * @param type $maxMoney
     * @return boolean
     */
    private function fenghong($perMoney, $maxMoney){
        $startUnix = strtotime($this->splitDay);
        $endUnix = strtotime($this->splitDay . ' 23:59:59');
        $sql = "select id, member_id, fh_money from {{%orders_fenghong}} where fh_money < {$maxMoney} and split_time < {$startUnix} and add_time <= {$endUnix} and status = 2 order by id asc limit 500";
        $record = Yii::$app->db->createCommand($sql)->queryAll();
        if( ! $record){
            return false;
        }
        $minId = $record[0]['id'];
        $maxId = $record[count($record)-1]['id'];
        $sql = "update {{%orders_fenghong}} set fh_money = fh_money + {$perMoney}, day_money = {$perMoney}, split_time = {$startUnix} where id >= {$minId} and id <= {$maxId} and fh_money < {$maxMoney} and split_time < {$startUnix} and add_time <= {$endUnix} and status = 2";
        Yii::$app->db->createCommand($sql)->execute();
        $sql = "update {{%orders_fenghong}} set fh_money = 150, day_money = day_money + 150 - fh_money where id >= {$minId} and id <= {$maxId} and fh_money > 150 and fh_money < 160 and split_time = {$startUnix} and add_time <= {$endUnix} and status = 2";
        Yii::$app->db->createCommand($sql)->execute();
        $execSql = '';
        foreach($record as $val){
            if(($val['fh_money'] + $perMoney) > 150){
                $sendMoney = 150 - $val['fh_money'];
            }else{
                $sendMoney = $perMoney;
            }
            $execSql .= "update {{%member}} set day_fenghong = day_fenghong + {$sendMoney} where id = {$val['member_id']};";
            $this->tjj($val['member_id'], $sendMoney, "订单收益", AccountLog::J4);
        }
        Yii::$app->db->createCommand($execSql)->execute();
        return true;
    }
    
    /**
     * 领导奖
     */
    public function sendLdj(){
        $startUnix = strtotime($this->splitDay);
        $endUnix = strtotime($this->splitDay . ' 23:59:59');
        $sql = "select id, level, recomm_count, depth, route from {{%member}} where recomm_count > 0 and level > 0 and split_time < {$startUnix} and reg_time <= {$endUnix} order by id asc limit 500";
        $memberList = Yii::$app->db->createCommand($sql)->queryAll();
        if( ! $memberList){
            return false;
        }
        $fhj = Yii::$app->params['ldj'];
        $minId = $memberList[0]['id'];
        $maxId = $memberList[count($memberList)-1]['id'];
        $sql = "update {{%member}} set split_time = {$startUnix} where id >= {$minId} and id <= {$maxId} and split_time < {$startUnix} and reg_time <= {$endUnix} and recomm_count > 0 and level > 0";
        Yii::$app->db->createCommand($sql)->execute();
        foreach($memberList as $val){
            $sumMoney = 0;
            for($i = 1; $i < 11; $i++){
                $targetDepth = $val['depth'] + $i;
                $tempMoney = $this->cualTotal($val['route'], $targetDepth);
                $sumMoney = round($sumMoney + $tempMoney * $fhj[$i], 2);
            }
            $this->tjj($val['id'], $sumMoney, "{$this->splitDay}领导奖", AccountLog::J7);
        }
        return true;
    }
    
    /**
     * 计算团队某层分红总额
     * 
     * @param type $route   路由
     * @param type $depth   深度
     * @return int
     */
    private function cualTotal($route, $depth){
        $sql = "select sum(day_fenghong) as day_fenghong from {{%member}} where depth = {$depth} and route like '{$route}%';";
        $sumMoney = Yii::$app->db->createCommand($sql)->queryScalar();
        if( ! $sumMoney){
            $sumMoney = 0;
        }
        return $sumMoney;
    }
    
    
    /**
     * 添加奖金
     * 
     * @param type $memberId
     * @param type $money
     * @param type $desc
     * @return boolean
     */
    private function tjj($memberId, $money, $desc, $type){
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
    
}