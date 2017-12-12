<?php

namespace app\modules\api;

use Yii;

/**
 * api module definition class
 */
class Module extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\api\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        Yii::configure($this, require(__DIR__ . '/config/config.php'));
        $this->resetUrlManager();
        $this->resetResponse();
        $this->resetErrorHandler();
    }

    protected function resetResponse(){
        Yii::$app->set(
                'response', [
                    'class' => 'yii\web\Response',
                    'on beforeSend' => function ($event) {
                        $response = $event->sender;
                        $response->data = [
                            'code' => $response->getStatusCode(),
                            'data' => $response->data,
                            'message' => $response->statusText
                        ];
                        $response->format = \yii\web\Response::FORMAT_JSON;
                    },
                ]
        );
    }


    protected function resetUrlManager(){
        Yii::$app->set(
                'urlManager', [
                    'class' => 'yii\web\UrlManager',
                    'enablePrettyUrl' => true,
                    'showScriptName' => false,
                    'rules' => [
                            [
                            'class' => 'yii\rest\UrlRule',
                            'controller' => [
                                'member',
                                'account',
                                'address',
                                'licai-order',
                                'withdraw',
                                'public-row',
                                'team',
                                'orders',
                            ],
                            'extraPatterns' => [
                                'GET login' => 'login',
                                'GET index' => 'index',
                                'GET blist' => 'blist',
                                'GET logout' => 'logout',
                                'GET get-member-info' => 'get-member-info',
                                'GET get-info-by-mobile' => 'get-info-by-mobile', 
                                'GET view' => 'view',
                                
                                'POST create' => 'create',
                                'POST update' => 'update',
                                'POST delete' => 'delete',
                                'POST set-pass' => 'set-pass',
                                'POST chg-nick-name' => 'chg-nick-name',
                                'POST trans' => 'trans',
                            ],
                        ],
                    ],
                ]
        );
    }


    /**
     * 重新设置异常捕获页面
     */
    protected function resetErrorHandler() {
        Yii::$app->set(
                'errorHandler', [
            'class' => 'yii\web\ErrorHandler',
            'errorAction' => 'api/default/error',
                ]
        );
    }

}
