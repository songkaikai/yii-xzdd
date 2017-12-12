<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;

/**
 * Default controller for the `api` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        echo 'over';
    }

    public function actionError(){
        echo Yii::$app->getErrorHandler()->exception;
    }
}
