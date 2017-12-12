<?php

namespace app\models\form;

use Yii;
use app\models\Orders;
use app\models\form\PublicRowForm;
use app\models\Member;
use app\models\RecommOrder;
use yii\helpers\ArrayHelper;
use app\models\form\AccountForm;
use app\models\AccountLog;

/**
 * 更改订单状态
 *
 * @filename ChangeOrderForm.php 
 * @encoding UTF-8 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2016-10-30 21:19:16
 */
class ChangeOrderForm extends \yii\base\Model {
    public $orderNo;
    public $memberId;
    private $_orderInfo;
    public $express;
    public $expressNo;
    
    public function scenarios() {
        return [
            'default' => ['memberId', 'orderNo'],
            'fahuo' => ['orderNo', 'express', 'expressNo'],
        ];
    }
    
    public function rules() {
        return [
            [['memberId', 'orderNo'], 'required'],
            [['memberId'], 'integer'],
            [['orderNo', 'express', 'expressNo'], 'string'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'memberId' => '会员ID',
            'orderNo' => '订单编号',
            'express' => '快递公司',
            'expressNo' => '快递单号',
        ];
    }
    
    /**
     * 订单状态更改为已付款
     */
    public function chgToPay(){
        if( ! $this->_getOrderInfo()){
            return false;
        }
        if($this->_orderInfo->member_id != $this->memberId){
            $this->addError('orderNo', '对不起，你无权更改订单');
            return false;
        }
        if($this->_orderInfo->status != Orders::PENDINGPAYMENT){
            $this->addError('orderNo', '对不起，订单不是待付款状态');
            return false;
        }
        $this->_orderInfo->pay_time = time();
        $this->_orderInfo->status = Orders::PENDINGSHIPPED;
        if($this->_orderInfo->save()){
            if($this->_orderInfo->order_type == Orders::MEMBER_UPGRADE){
                //更新推荐人数
                $this->updateRecommCount();
                //更新团队业绩
                $this->updateTeamPerformance($this->_orderInfo->total);
                //会员升级
                $this->upgradeMember();
                //公排排号
                $publicRowCount = intval($this->_orderInfo->total / 100);
                if($publicRowCount > 3){
                    $publicRowCount = 3;
                }elseif($publicRowCount == 0){
                    $publicRowCount = 1;
                }
                for($i = 1; $i <= $publicRowCount; $i++){
                    $this->setPublicRow($this->memberId, $this->_orderInfo->order_no);
                }
                //发放激励奖
                $this->sendJlj($this->_orderInfo->total);
                //创建分红订单
                $this->buildFenghong($this->_orderInfo->order_no, $this->_orderInfo->total, $this->memberId);
                //扣库存
                $sql = "update {{%content}} set stock = stock - 1 where id = {$this->_orderInfo->goods_id}";
                Yii::$app->db->createCommand($sql)->execute();
            }
            return true;
        }
        return false;
    }
    
    /**
     * 订单状态更改为待发货
     */
    public function chgToShip(){
        if( ! $this->_getOrderInfo()){
            return false;
        }
        if($this->_orderInfo->status != Orders::PENDINGSHIPPED){
            $this->addError('orderNo', '对不起，订单不是待收货状态');
            return false;
        }
        $this->_orderInfo->express = $this->express;
        $this->_orderInfo->express_no = $this->expressNo;
        $this->_orderInfo->fh_time = time();
        $this->_orderInfo->status = Orders::PENDINGRECEIVING;
        if($this->_orderInfo->save()){
            return true;
        }
        return false;
    }
    
    /**
     * 订单状态更改为交易完成
     */
    public function chgToSuccess(){
        if( ! $this->_getOrderInfo()){
            return false;
        }
        if($this->_orderInfo->status != Orders::PENDINGRECEIVING){
            $this->addError('orderNo', '对不起，订单不是待收货状态');
            return false;
        }
        $this->_orderInfo->over_time = time();
        $this->_orderInfo->status = Orders::TRADINGSUCCESS;
        if($this->_orderInfo->save()){
            return true;
        }
        return false;
    }
    
    /**
     * 订单状态更改为关闭
     */
    public function chgToClose(){
        if( ! $this->_getOrderInfo()){
            return false;
        }
        if($this->_orderInfo->member_id != $this->memberId){
            $this->addError('orderNo', '对不起，你无权更改订单');
            return false;
        }
        if($this->_orderInfo->status != Orders::PENDINGPAYMENT){
            $this->addError('orderNo', '对不起，订单不是待付款状态，不可关闭');
            return false;
        }
        $this->_orderInfo->over_time = time();
        $this->_orderInfo->status = Orders::TRADINGCLOSE;
        if($this->_orderInfo->save()){
            return true;
        }
        return false;
    }
    
    /**
     * 获取订单详情
     */
    private function _getOrderInfo(){
        $orderInfo = Orders::find()->where(['order_no'=>$this->orderNo])->one();
        if($orderInfo){
            $this->_orderInfo = $orderInfo;
            return true;
        }else{
            $this->addError('orderNo', '不存在的订单');
            return false;
        }
    }
    
    /**
     * 设置公排号
     * 
     * @param type $memberId
     * @param type $orderId
     * @return boolean
     */
    private function setPublicRow($memberId, $orderId){
        $publicModel = new PublicRowForm();
        $publicModel->attributes = [
            'memberId' => $memberId,
            'orderId' => $orderId,
        ];
        if($publicModel->validate() && $publicModel->paiHao()){
            return true;
        }
        return false;
    }
    
    /**
     * 更新团队业绩
     */
    private function updateTeamPerformance($money = 0){
        $userInfo = Member::find()->select('recommender, route')->asArray()->where(['id'=>$this->memberId])->one();
        $sql = "update {{%member}} set consumption = consumption + {$money} where id = {$this->memberId}";
        Yii::$app->db->createCommand($sql)->execute();
        $recommender = ArrayHelper::getValue($userInfo, 'recommender', 0);
        if($recommender){
            //更新推荐人团队业绩
            $routeArr = explode(',', trim($userInfo['route'], ','));
            $newRoute = array_reverse($routeArr);
            $teamIds = '';
            if(isset($newRoute[1])){
                $teamIds .= $newRoute[1] . ',';
            }
            if(isset($newRoute[2])){
                $teamIds .= $newRoute[2] . ',';
            }
            if(isset($newRoute[3])){
                $teamIds .= $newRoute[3] . ',';
            }
            if( ! empty($teamIds)){
                $sql = "update {{%member}} set team = team + {$money} where id in (".trim($teamIds, ',').");";
                Yii::$app->db->createCommand($sql)->execute();
            }
        }
    }
    
    /**
     * 会员升级
     */
    private function upgradeMember(){
        $newLevel = 0;
        $userInfo = Member::find()
                ->select('id, level, consumption, team, recomm_count')
                ->asArray()
                ->where(['id'=>$this->memberId])
                ->one();
        if($userInfo['recomm_count'] >= 50 && $userInfo['team'] >= 80000){
            $newLevel = Member::FOUR_STAR;
        }elseif($userInfo['recomm_count'] >= 30 && $userInfo['team'] >= 30000){
            $newLevel = Member::THREE_STAR;
        }elseif($userInfo['recomm_count'] >= 20 && $userInfo['team'] >= 10000){
            $newLevel = Member::TWO_STAR;
        }elseif($userInfo['recomm_count'] >= 10 && $userInfo['team'] >= 3000){
            $newLevel = Member::ONE_STAR;
        }elseif($userInfo['consumption'] >= 300){
            $newLevel = Member::LEVEL_THREE;
        }elseif($userInfo['consumption'] >= 100){
            $newLevel = Member::LEVEL_TWO;
        }
//        if($userInfo['level'] == Member::LEVEL_ONE && $userInfo['consumption'] >= 100){
//            $newLevel = Member::LEVEL_TWO;
//        }elseif($userInfo['level'] == Member::LEVEL_TWO && $userInfo['consumption'] >= 300){
//            $newLevel = Member::LEVEL_THREE;
//        }elseif($userInfo['level'] == Member::LEVEL_THREE && $userInfo['recomm_count'] >= 10 && $userInfo['team'] >= 3000){
//            $newLevel = Member::ONE_STAR;
//        }elseif($userInfo['level'] == Member::ONE_STAR && $userInfo['recomm_count'] >= 20 && $userInfo['team'] >= 10000){
//            $newLevel = Member::TWO_STAR;
//        }elseif($userInfo['level'] == Member::TWO_STAR && $userInfo['recomm_count'] >= 30 && $userInfo['team'] >= 30000){
//            $newLevel = Member::THREE_STAR;
//        }elseif($userInfo['level'] == Member::THREE_STAR && $userInfo['recomm_count'] >= 50 && $userInfo['team'] >= 80000){
//            $newLevel = Member::FOUR_STAR;
//        }
        if($newLevel > 0){
            $sql = "update {{%member}} set level = {$newLevel} where id = {$this->memberId};";
            Yii::$app->db->createCommand($sql)->execute();
        }
    }
    
    /**
     * 更新推荐人数
     */
    private function updateRecommCount(){
        $orderCount = Orders::find()->where("member_id = {$this->memberId} and status in (1,2,8)")->count();
        if(intval($orderCount) === 1){
            //更新推荐人数
            $memberInfo = Member::find()->asArray()->select('recommender')->where(['id'=>$this->memberId])->one();
            if($memberInfo && $memberInfo['recommender']){
                $sql = "update {{%member}} set recomm_count = recomm_count + 1 where id = {$memberInfo['recommender']}";
                Yii::$app->db->createCommand($sql)->execute();
            }
        }
    }
    
    /**
     * 创建分红订单
     */
    private function buildFenghong($orderNo, $orderMoney, $memberId){
        $time = time();
        switch(intval($orderMoney)){
            case 200:
                $orderType = 2;
                break;
            case 300:
                $orderType = 3;
                break;
            default:
                $orderType = 1;
                break;
        }
        $sql = "insert into {{%orders_fenghong}}(order_id, member_id, order_type, add_time) "
                . "values('{$orderNo}', {$memberId}, {$orderType}, {$time})";
        Yii::$app->db->createCommand($sql)->execute();
    }
    
    /**
     * 发放激励奖
     */
    private function sendJlj($orderMoney){
        $memberInfo = Member::find()->asArray()->select('recommender, route, level, recomm_count')->where(['id'=>$this->memberId])->one();
        if($memberInfo['recommender'] == 0){
            return false;
        }
        $routeArr = explode(',', trim($memberInfo['route'], ','));
        if(count($routeArr) > 11){
            $many = count($routeArr) - 11;
            for($i = 0; $i < $many; $i++){
                unset($routeArr[$i]);
            }
        }
        $newRoute = array_reverse($routeArr);
        unset($newRoute[0]);
        $jlj = Yii::$app->params['jlj'];
        $sql = "select id, recomm_count, level from {{%member}} where id in (".implode(',', $newRoute).") order by depth desc";
        $rowNode = Yii::$app->db->createCommand($sql)->queryAll();
        foreach($rowNode as $key => $val){
            $layer = $key + 1;
            if($val['level'] >= $jlj[$layer]['level'] && $val['recomm_count'] >= $jlj[$layer]['recommCount']){
//                $this->tjj($val['id'], round(100 * $jlj[$layer]['money'], 2), "激励奖");
                $this->tjj($val['id'], round($orderMoney * $jlj[$layer]['money'], 2), "激励奖");
            }
        }
    }
    
    private function tjj($memberId, $money, $desc){
        $accountModel = new AccountForm();
        $accountModel->attributes = [
            'memberId' => $memberId,
            'desc' => $desc,
            'money' => $money,
            'type' => AccountLog::J3,
        ];
        if($accountModel->rechargeMoney()){
            return true;
        }else{
            //错误日志
            return false;
        }
    }
}
