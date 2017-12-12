<?php

namespace app\components;

use Yii;
use app\components\BaseController;

/**
 * Description of MemberAjaxController
 *
 * @author Administrator
 */
class MemberAjaxController extends BaseController {
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
            $this->ajaxResponse('error', '会员未登录', '90001');
            return false;
        }else{
            return true;
        }
    }
}
