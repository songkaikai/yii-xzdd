<?php

namespace app\modules\api\components;

use Yii;
use yii\rest\Controller;
use yii\helpers\ArrayHelper;
use app\modules\api\components\MyQueryParamAuth;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\filters\Cors;

/**
 * API基本控制器
 *
 * @filename BaseController.php 
 * @encoding UTF-8 
 * @copyright Copyright (C) 2017 免蛋生活
 * @link http://www.meggLife.com 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2017-10-30 14:27:32
 */
class BaseController extends Controller {

    public $pageSize = 20;
    public $currentPage = 1;
    public $orders;
    public $ordersType;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'list',
    ];
    
    public function init() {
        parent::init();
    }

    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
                    'authenticator' => [
                        'class' => MyQueryParamAuth::className(),
                        'tokenParam' => 'token',
                        'user' => Yii::$app->get('member'),
                        'optional' => [
                            'login',
                            'register',
                        ],
                    ],
                    [
                        'class' => Cors::className(),
                        'cors' => [
                            'Origin' => ['http://api.huichapu.cn', 'http://localhost:9999', 'http://192.168.88.125:9999', 'http://www.daxief.com', 'http://www.qumantang.net', 'http://www.lxqianbao.com', 'http://www.peacock-cn.cn'], //定义允许来源的数组
                            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'OPTIONS'], //允许动作的数组
                            'Access-Control-Allow-Credentials' => true,
//                            'Access-Control-Request-Headers' => ['X-Request-With'],
                        ],
                    ],
        ]);
    }

    public function beforeAction($action) {
        parent::beforeAction($action);
        $this->setPublics();
        return true;
    }

    /**
     * 设置全局参数
     */
    public function setPublics() {
        if (\Yii::$app->request->isPost) {
            $params = \Yii::$app->request->post();
        } else {
            $params = \Yii::$app->request->get();
        }
        $this->currentPage = ArrayHelper::getValue($params, 'pages', 1) - 1;
        $this->pageSize = ArrayHelper::getValue($params, 'pageSize', 10);
        $this->orders = ArrayHelper::getValue($params, 'orders', '');
        $this->ordersType = ArrayHelper::getValue($params, 'ordersType', 'DESC');
        if (!in_array($this->ordersType, ['ASC', 'DESC'])) {
            $this->ordersType = 'DESC';
        }
    }

    /**
     * 构建返回结果
     * 
     * @param type $result
     * @param type $message
     */
    public function buildResult($result, $message = '', $data = '') {
        return [
            'result' => $result,
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * 格式化苹果端生成的JSON
     * 
     * @param type $json
     */
    public function formatJson($json) {
        return str_replace(" ", "", str_replace("\n", '', $json));
    }

    /**
     * 构建数据验证错误返回文本
     * 
     * @param type $errors
     * @throws HttpException
     */
    public function buildValidateError($errors) {
        throw new HttpException(200, Json::encode($errors), 422);
    }

}
