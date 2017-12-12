<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\OrdersFenghong;
use app\models\Member;
use app\models\AccountLog;
use app\models\form\AccountForm;

/**
 * 理财订单
 *
 * @author Administrator
 */
class LicaiForm extends Model {

    public $memberId;
    public $orderInfo;

    public function rules() {
        return [
                [['memberId'], 'required'],
                [['memberId'], 'integer'],
                ['orderInfo', 'safe'],
        ];
    }

    public function attributeLabels() {
        return [
            'memberId' => '会员ID',
        ];
    }
    
    /**
     * 创建理财订单
     */
    public function build() {
        $orderMoney = Yii::$app->params['licaiMoney'];
        $memberInfo = Member::find()->select('id, balance, recommender, route')->asArray()->where(['id' => $this->memberId])->one();
        if (!$memberInfo || $memberInfo['balance'] < $orderMoney) {
            $this->addError('memberId', '账户余额不足');
            return false;
        }
        if($this->getTodayBuyCount($this->memberId) >= Yii::$app->params['dayMax']){
            $this->addError('memberId', '每日限购' . Yii::$app->params['dayMax']);
            return false;
        }
        $activeBuyCount = $this->getMemberActiveBuyCount($this->memberId) + 1;
        if($activeBuyCount > Yii::$app->params['memberMax']){
            $this->addError('memberId', '每会员限购' . Yii::$app->params['memberMax']);
            return false;
        }
        $allBuyCount = $this->getMemberBuyCount($this->memberId) + 1;
        
        if($allBuyCount > Yii::$app->params['memberMax']){
            $paihao = $this->getMinPaihao($this->memberId);
            $frequency = $this->getChujuCount($this->memberId, $paihao);
        }else{
            $paihao = $this->getChujuPaihao($this->memberId, $allBuyCount);
//            $paihao = $allBuyCount;
            $frequency = 0;
        }
        
//        if($allBuyCount == Yii::$app->params['memberMax']){
//            $paihao = Yii::$app->params['memberMax'];
//        }else{
//            $paihao = $allBuyCount % Yii::$app->params['memberMax'];
//        }
//        $frequency = floor($allBuyCount / (Yii::$app->params['memberMax'] + 1));
        
        $balance = $memberInfo['balance'] - $orderMoney;
        list($time, $millisecond) = explode('.', microtime(true));
        $orderNo = OrdersFenghong::buildOrderNo($this->memberId);
        $sql1 = "insert into {{%orders_fenghong}}(order_no, member_id, order_money, member_paihao, add_time, millisecond, frequency) "
                . "values('{$orderNo}', {$this->memberId}, {$orderMoney}, {$paihao}, {$time}, {$millisecond}, {$frequency})";
        $sql2 = "update {{%member}} set balance = balance - {$orderMoney} where id = {$this->memberId}";
        $sql3 = "insert into {{%account_log}}(`member_id`, `type`, `out`, `balance`, `desc`, `add_date`) VALUES({$this->memberId}, 0, {$orderMoney}, {$balance}, '血战订单', $time)";

        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $connection->createCommand($sql1)->execute();
            $connection->createCommand($sql2)->execute();
            $connection->createCommand($sql3)->execute();
            $transaction->commit();
//            $this->sendFenxiao($memberInfo);
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::error($e->message, 'app.LicaiForm.build');
            return false;
        }
    }
    
    /**
     * 获取今天购买数量
     */
    private function getTodayBuyCount($memberId){
        $startDate = strtotime(date('Y-m-d'));
        $endDate = strtotime(date('Y-m-d') . ' 23:59:59');
        return OrdersFenghong::find()->where("member_id = {$memberId} and add_time >= {$startDate} and add_time <= {$endDate} and status < 9")->count();
    }
    
    /**
     * 获取会员累计购买数
     * 
     * @param type $memberId
     */
    private function getMemberBuyCount($memberId){
        return OrdersFenghong::find()->where("member_id = {$memberId} and status < 9")->count();
    }
    
    /**
     * 获取会员累计购买的有效理财订单数
     * 
     * @param type $memberId
     */
    private function getMemberActiveBuyCount($memberId){
        return OrdersFenghong::find()->where("member_id = {$memberId} and status < 8")->count();
    }
    
    /**
     * 获取最小的空宝箱号
     */
    private function getMinPaihao($memberId){
        $paihao = 1;
        $sql = "select member_paihao from {{%orders_fenghong}} where member_id = {$memberId} and status < 8 order by member_paihao asc";
        $record = Yii::$app->db->createCommand($sql)->queryAll();
        if( ! $record){
            return 1;
        }
        $i = 1;
        foreach($record as $val){
            if(intval($val['member_paihao']) !== $i){
                $paihao = $i;
                break;
            }
            $i++;
        }
        return $paihao;
    }
    
    /**
     * 获取30内的排号
     * @param type $memberId
     * @param type $defaultPaihao
     * @return type
     */
    private function getChujuPaihao($memberId, $defaultPaihao){
        $sql = "select member_paihao from xz_orders_fenghong where member_id = {$memberId} and `status` = 9 and member_paihao not in (select member_paihao from xz_orders_fenghong where member_id = {$memberId} and `status` < 9) order by member_paihao asc limit 1";
        $data = Yii::$app->db->createCommand($sql)->queryOne();
        if($data){
            return $data['member_paihao'];
        }else{
            return $defaultPaihao;
        }
    }
    
    /**
     * 获取宝箱出局次数
     * 
     * @param type $memberId
     * @param type $paihao
     */
    private function getChujuCount($memberId, $paihao){
        return OrdersFenghong::find()->where("member_id = {$memberId} and member_paihao={$paihao} and chuju=1")->count();
    }
    
    /**
     * 发放分销收益
     */
    private function sendFenxiao(&$memberInfo){
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
    
    private function tjj($memberId, $money, $desc){
        $accountModel = new AccountForm();
        $accountModel->attributes = [
            'memberId' => $memberId,
            'desc' => $desc,
            'money' => $money,
            'type' => AccountLog::J5,
        ];
        if($accountModel->rechargeMoney()){
            return true;
        }else{
            //错误日志
            return false;
        }
    }
}
