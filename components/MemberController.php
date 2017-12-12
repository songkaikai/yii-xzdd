<?php

namespace app\components;

use Yii;
use app\components\BaseController;

/**
 * Description of MemberController
 *
 * @filename MemberController.php 
 * @encoding UTF-8 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2016-10-30 20:57:45
 */
class MemberController extends BaseController {
    public $uinfo;
    public $noLogin;

    public function init() {
        $this->layout = 'content';
        parent::init();
    }

    public function beforeAction($action) {
        parent::beforeAction($action);
        $this->noLogin = [
            'site/index',
//            'guide/index',
        ];
        if( ! in_array(Yii::$app->controller->route, $this->noLogin)){
            if( ! self::isLogin()){
                return false;
            }
        }
        return true;
    }
    
    /**
     * 判断会员是否已登录，未登录则返回登录页
     */
    public static function isLogin() {
        if (Yii::$app->member->isGuest) {
            //未登录，返回登录页
            Yii::$app->controller->redirect(['/site/index']);
            return false;
        }else{
            return true;
        }
    }
}
