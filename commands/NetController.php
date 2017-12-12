<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\Member;
use app\models\form\PublicRowBForm;
use app\components\Tool;

/**
 * B网
 *
 * @author Administrator
 */
class NetController extends Controller {

    /**
     * 会员升级
     */
    public function actionIndex() {
        $point = 60;
        $sql = '';
        $userInfo = Member::find()
                ->select('id')
                ->asArray()
                ->where("integral_balance > {$point}")
                ->all();
        if( ! $userInfo){
            return false;
        }
        foreach($userInfo as $val){
            if($this->setPublicRow($val['id'])){
                $sql .= "update {{%member}} set integral_balance = integral_balance - {$point} where id = {$val['id']};";
            }
        }
        if( ! empty($sql)){
            Yii::$app->db->createCommand($sql)->execute();
        }
        Tool::log('开通B网', 'console');
    }
    
    /**
     * 设置公排号
     * 
     * @param type $memberId
     * @param type $orderId
     * @return boolean
     */
    private function setPublicRow($memberId){
        $publicModel = new PublicRowBForm();
        $publicModel->attributes = [
            'memberId' => $memberId,
        ];
        if($publicModel->validate() && $publicModel->paiHao()){
            return true;
        }
        return false;
    }
}
