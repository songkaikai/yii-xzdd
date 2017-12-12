<?php

namespace app\models\form;

use Yii;
use app\models\PublicRow;
use app\models\Member;
use app\models\form\AccountForm;
use app\models\AccountLog;
use app\components\Tool;
use app\components\TwoCopy;

/**
 * 公排池
 *
 * @filename PublicRowForm.php 
 * @encoding UTF-8 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2016-11-27 21:11:39
 */
class PublicRowForm extends \yii\base\Model {

    public $memberId;
    public $orderId;
    public $isBuy = 1;
    private $column;

    public function rules() {
        return [
            [['memberId', 'orderId'], 'required'],
            [['memberId', 'isBuy'], 'integer'],
            [['orderId'], 'string'],
        ];
    }

    public function attributes() {
        return [
            'memberId' => '会员ID',
            'orderId' => '订单编号',
        ];
    }

    /**
     * 排号
     */
    public function paiHao() {
        $model = new PublicRow();
        $model->attributes = [
            'member_id' => $this->memberId,
            'order_id' => $this->orderId,
        ];
        if ($model->validate() && $model->save()) {
            return $this->setPublicRowNo($model->id, $model);
        }
        return false;
    }

    /**
     * 设置公排编号相关信息
     * 
     * @param type $queueId
     */
    private function setPublicRowNo($queueId, &$rowInfo) {
        $position = TwoCopy::getNodePosition($queueId);
        $parentRoute = $this->changeParentChild($position);
        $rowInfo->attributes = [
            'layer' => $position['layer'],
            'parent_node' => $position['parentNode'],
            'parent_route' => $parentRoute . $queueId . ',',
            'column' => $this->column,
        ];
        if( ! $rowInfo->save()){
            return false;
        }
        if($this->isBuy){
        //发放推荐奖
            $memberInfo = Member::find()->select('id, recommender, route, nick_name, level')->asArray()->where(['id'=>$rowInfo->member_id])->one();
            $this->sendTjj($memberInfo);
        }
        $queueId > 1 && $this->sendJdj($queueId);
        return true;
    }
    
    /**
     * 更改上级节点的左右节点
     * 
     * @param type $position
     * @return boolean|string
     */
    private function changeParentChild($position){
        if($position['parentNode'] == 0){
            $this->column = 1;
            return ',';
        }
        $parentInfo = PublicRow::findOne(['id' => $position['parentNode']]);
        if($parentInfo){
            if ($position['leftNode']) {
                $this->column = $parentInfo['column'] * 2 - 1;
            }
            if ($position['rightNode']) {
                $this->column = $parentInfo['column'] * 2;
            }
            return $parentInfo['parent_route'];
        }
        return ',';
    }
    
    /**
     * 发放推荐奖
     */
    private function sendTjj($memberInfo){
        if($memberInfo['recommender'] == 0){
            return false;
        }
        $recommInfo = Member::findOne($memberInfo['recommender']);
        if($recommInfo->level < Member::LEVEL_TWO){
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
        foreach($newRoute as $key => $val){
            $layer = $key;
            $this->tjj($val, Yii::$app->params['tjjMoney'][$layer], "{$layer}层推荐奖", 0, AccountLog::J1);
        }
    }
    
    /**
     * 发放见点奖
     */
    private function sendJdj($queueId){
        $sql = "select id, member_id, parent_route, layer from {{%public_row}} where id = {$queueId}";
        $publicRowInfo = Yii::$app->db->createCommand($sql)->queryOne();
        if($publicRowInfo['layer'] == 1){
            return false;
        }
        $routeArr = explode(',', trim($publicRowInfo['parent_route'], ','));
        if(count($routeArr) > 13){
            $many = count($routeArr) - 13;
            for($i = 0; $i < $many; $i++){
                unset($routeArr[$i]);
            }
        }
        $newRoute = array_reverse($routeArr);
        unset($newRoute[0]);
        $sql = "select a.id, a.member_id, b.recomm_count from {{%public_row}} a left join {{%member}} b on a.member_id = b.id where a.id in (".implode(',', $newRoute).") order by a.id desc";
        $rowNode = Yii::$app->db->createCommand($sql)->queryAll();
        foreach($rowNode as $key => $val){
            $layer = $key + 1;
            if($layer < 7 || ($layer > 6 && $val['recomm_count'] >= 2)){
                $this->tjj($val['member_id'], Yii::$app->params['jdjMoney'][$layer], "{$layer}层见点奖", $val['id'], AccountLog::J2);
            }
        }
        return true;
    }
    
    private function tjj($memberId, $money, $desc, $queueId = 0, $type=0){
        if($queueId){
            $sql = "update {{%public_row}} set send_money = send_money + {$money} where id = {$queueId}";
            Yii::$app->db->createCommand($sql)->execute();
        }
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
