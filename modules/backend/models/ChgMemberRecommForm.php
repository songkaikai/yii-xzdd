<?php

namespace app\modules\backend\models;

use yii\base\Model;
use Yii;
use app\models\Member;

/**
 * 修改会员推荐关系
 *
 * @author xxx
 */
class ChgMemberRecommForm extends Model {

    public $memberId;
    public $recommMobile;

    public function rules() {
        return [
            [['memberId', 'recommMobile'], 'required'],
            ['memberId', 'integer'],
            ['recommMobile', 'string'],
        ];
    }

    public function attributeLabels() {
        return [
            'memberId' => '会员ID',
            'recommMobile' => '推荐人账号',
        ];
    }
    
    public function change(){
        $memberInfo = Member::findOne($this->memberId);
        $newRecomm = Member::find()->where(['uname'=>$this->recommMobile])->one();
        if( ! $newRecomm){
            $this->addError('recommMobile', '不存在的推荐人');
            return false;
        }
        $sql = '';
        if($memberInfo->level > Member::LEVEL_ONE){
            //去除旧推荐人的推荐人数
            if($memberInfo->recommender){
                $sql .= "Update {{%member}} set recomm_count = recomm_count - 1 where id = {$memberInfo->recommender};";
            }
            $sql .= "Update {{%member}} set recomm_count = recomm_count + 1 where id = {$newRecomm->id};";
        }
        $newdepth = $newRecomm->depth + 1;
        $diffdepth = $newdepth - $memberInfo->depth;
        //更新子节点
        if($diffdepth > 0){
            $sql .= "Update {{%member}} set route = replace(route, '{$memberInfo['route']}', '{$newRecomm->route}{$memberInfo->id},'), depth = depth + {$diffdepth} where route like '{$memberInfo['route']}%' and id != {$memberInfo->id};";
        }else{
            $sql .= "Update {{%member}} set route = replace(route, '{$memberInfo['route']}', '{$newRecomm->route}{$memberInfo->id},'), depth = depth {$diffdepth} where route like '{$memberInfo['route']}%' and id != {$memberInfo->id};";
        }
        $sql .= "Update {{%member}} set recommender = {$newRecomm->id}, route = '{$newRecomm->route}{$memberInfo->id},', depth = {$newdepth} where id = {$memberInfo->id};";
        Yii::$app->db->createCommand($sql)->execute();
        return true;
    }
}
