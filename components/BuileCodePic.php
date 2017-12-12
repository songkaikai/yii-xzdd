<?php

namespace app\components;

use Yii;
use yii\helpers\Url;
use app\components\qrcode\buildCode;
use yii\imagine\Image;
use app\models\Member;

/**
 * 生成会员二维码图片
 *
 * @author Administrator
 */
class BuileCodePic {

    public $baseFile;
    public $codePath;
    public $codePicPath;
    public $avatarPath;
    
    public function __construct() {
        $this->baseFile = Yii::getAlias('@app/web/upload/base.jpg');
        $this->codePicPath = Yii::getAlias('@app/web/upload/code/');
        $this->avatarPath = Yii::getAlias('@app/web/upload/avatar/');
        $this->codePath = Yii::getAlias('@app/web/code/');
    }
    
    /**
     * 生成二维码图片(非关注)
     * 
     * @param type $memberId
     * @param type $avatarUrl
     * @return string
     */
    public function buildCode($memberId, $avatarUrl, $nickName = '') {
        $codePicFile = $this->codePicPath . md5($memberId) . '.png';
        if( ! is_file($codePicFile)){
            $avatarFile = $this->saveAvatar($memberId, $avatarUrl);
            $imageModel = new Image();
            $imageModel->watermark($this->baseFile, $avatarFile, [250, 190])->save($codePicFile);
            $codeFile = $this->getCodeUrl($memberId);
            $imageModel->watermark($codePicFile, $codeFile, [150,450])->save($codePicFile);
            $imageModel->text($codePicFile, $nickName,'@app/web/upload/msyh.ttf', [250,380], ['color'=>'000', 'size'=>20])->save($codePicFile);
        }
        return $codePicFile;
    }
    
    /**
     * 生成关注的二维码图片
     * 
     * @param type $memberId
     * @param type $avatarUrl
     * @param type $nickName
     */
    public function buildFollowCode($memberId, $avatarUrl, $nickName = ''){
        $codePicFile = $this->codePicPath . md5($memberId) . '.png';
        $memberInfo = Member::find()->asArray()->select('id, code_url, code_expire')->where(['id'=>$memberId])->one();
        if($memberInfo['code_expire'] < time()){
            if(is_file($codePicFile)){
                @unlink ($codePicFile);
            }
            $avatarFile = $this->saveAvatar($memberId, $avatarUrl);
            $imageModel = new Image();
            $imageModel->watermark($this->baseFile, $avatarFile, [280, 190])->save($codePicFile);
            $codeFile = $this->getFollowCode($memberId);
            $imageModel->watermark($codePicFile, $codeFile, [180,450])->save($codePicFile);
            $imageModel->text($codePicFile, $nickName,'@app/web/upload/msyh.ttf', [280,380], ['color'=>'000', 'size'=>20])->save($codePicFile);
        }
        return '/upload/code/' . md5($memberId) . '.png';
    }

    /**
     * 获取非关注的二维码地址
     * 
     * @param type $memberId
     * @return boolean
     */
    public function getCodeUrl($memberId){
        $fileName = md5($memberId).'.png';
        if (!is_file($this->codePath . $fileName)) {
            $wxConfig = Yii::$app->params['wechat'];
            $baseUrl = Url::toRoute(['/wechat/accesstoken'], TRUE);
            $codeUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$wxConfig['appid'].'&redirect_uri='.urlencode($baseUrl).'&response_type=code&scope=snsapi_userinfo&state='.$memberId.'#wechat_redirect';
            buildCode::code($codeUrl, $this->codePath . $fileName);
        }
        return $this->codePath . $fileName;
    }
    
    /**
     * 获取关注的二维码
     * 
     * @param type $memberId
     * @param type $logo
     */
    public function getFollowCode($memberId, $logo = false){
        $fileName = md5($memberId).'.png';
        if (is_file($this->codePath . $fileName)) {
            //删除图片
            @unlink ($this->codePath . $fileName);
        }
        //获取二维码
        $expire = strtotime(date('Y-m-d', strtotime('+7 day')));
//        $expire = time() + 3600;
        $wechatInfo = $this->getWechatCode($memberId, 604800);
        $sql = "update {{%member}} set code_url = '{$wechatInfo['url']}', code_expire = {$expire} where id = {$memberId}";
        Yii::$app->db->createCommand($sql)->execute();
        buildCode::code($wechatInfo['url'], $this->codePath . $fileName, 14);
        return $this->codePath . $fileName;
    }
    
    /**
     * 获取微信二维码数据
     * 
     * @param type $memberId
     * @param type $qrType  QR_SCENE 临时二维码  QR_LIMIT_SCENE永久
     */
    private function getWechatCode($memberId, $expire = 604800,  $qrType = 'QR_SCENE'){
        $params = [
            'action_name' => 'QR_SCENE',
            'expire_seconds' => $expire,
            'action_info' => [
                'scene' => [
                    'scene_id' => $memberId,
                ],
            ],
        ];
        $result = Yii::$app->wechat->createQrCode($params);
        return $result;
    }
    
    /**
     * 保存头像
     * 
     * @param type $memberId
     * @param type $avatarUrl
     */
    public function saveAvatar($memberId, $avatarUrl) {
        $fileName = $memberId . '.png';
        $thumbFileName = $memberId . '_150.png';
        if (!is_file($this->avatarPath . $fileName)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $avatarUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $avatoData = curl_exec($ch);
            curl_close($ch);
            file_put_contents($this->avatarPath . $fileName, $avatoData);
            $imageModel = new Image();
            $imageModel->thumbnail($this->avatarPath . $fileName, 150, 150)->save($this->avatarPath . $thumbFileName);
        }
        return $this->avatarPath . $thumbFileName;
    }

}
