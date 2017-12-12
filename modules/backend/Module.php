<?php

namespace app\modules\backend;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\helpers\Url;
use yii\web\Response;

/**
 * backend module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\backend\controllers';
    public $layout = 'main.php';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        Yii::configure($this, require(__DIR__ . '/config.php'));

        $this->resetErrorHandler();
        $this->rbacConfInit();

        /**
         * 注册时间 记录下用户回退地址
         */
        $this->on(self::EVENT_AFTER_ACTION, function(){
            if(!Yii::$app->request->isAjax) {
                Url::remember();
            }
        });
    }

    /**
     * 初始化rbac 配置初始化
     */
    protected function rbacConfInit()
    {
        Yii::$container->set('mdm\admin\components\Configs',
            [
//                'db' => 'customDb',
                'menuTable' => '{{%admin_menu}}',
                'userTable' => '{{%admin_user}}',
            ]
        );
    }
    /**
     * 重新设置异常捕获页面
     */
    protected function resetErrorHandler()
    {
        Yii::$app->set(
            'errorHandler', [
                'class'=>'yii\web\ErrorHandler',
                'errorAction' => 'backend/default/error',
            ]
        );
        Yii::$app->errorHandler->register();
    }
}
