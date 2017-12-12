<?php

namespace app\components;

use Yii;
use yii\web\Controller;
use yii\helpers\Json;

/**
 * Description of BaseController
 *
 * @filename BaseController.php 
 * @encoding UTF-8 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2015-11-16 20:28:44
 */
class BaseController extends Controller {
    
    public $keywords;
    public $description;
    
    public function init() {
        parent::init();
    }
 
    public function beforeAction($action) {
        return true;
    }

    /**
     * AJAX结果输出
     * 
     * @param type $result
     * @param type $message
     * @param type $data
     */
    public function ajaxResponse($result, $message='', $data='', $redirectUrl = ''){
        $ajaxResult = [
            'result' => $result,
            'message' => $message,
            'data' => $data,
            'redirectUrl' => $redirectUrl,
        ];
        echo Json::encode($ajaxResult);
        Yii::$app->end();
    }
}
