<?php

namespace app\models\form;

use Yii;
use app\models\PublicRowB;
use app\models\form\AccountForm;
use app\models\AccountLog;
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
class PublicRowBForm extends \yii\base\Model {

    public $memberId;
    private $column;

    public function rules() {
        return [
            [['memberId'], 'required'],
            [['memberId'], 'integer'],
        ];
    }

    public function attributes() {
        return [
            'memberId' => '会员ID',
        ];
    }

    /**
     * 排号
     */
    public function paiHao() {
        $model = new PublicRowB();
        $model->attributes = [
            'member_id' => $this->memberId,
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
        $parentInfo = PublicRowB::findOne(['id' => $position['parentNode']]);
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
     * 发放见点奖
     */
    private function sendJdj($queueId){
        $sql = "select id, member_id, parent_route, layer from {{%public_row_b}} where id = {$queueId}";
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
        $sql = "select id, member_id from {{%public_row_b}} where id in (".implode(',', $newRoute).") order by id desc";
        $rowNode = Yii::$app->db->createCommand($sql)->queryAll();
        foreach($rowNode as $key => $val){
            $layer = $key + 1;
            $this->tjj($val['member_id'], Yii::$app->params['jdjMoneyB'][$layer], "B网{$layer}层见点奖", $val['id'], AccountLog::J8);
        }
        return true;
    }
    
    private function tjj($memberId, $money, $desc, $queueId = 0, $type = 0){
        if($queueId){
            $sql = "update {{%public_row_b}} set send_money = send_money + {$money} where id = {$queueId}";
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
