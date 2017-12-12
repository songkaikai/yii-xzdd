<?php

namespace app\modules\api\components;

use yii\filters\auth\QueryParamAuth;
use yii\web\HttpException;

/**
 * Description of MyQueryParamAuth
 *
 * @filename MyQueryParamAuth.php 
 * @encoding UTF-8 
 * @copyright Copyright (C) 2017 免蛋生活
 * @link http://www.meggLife.com 
 * @author xxh <xxh44@qq.com>
 * @version 1.0.0
 * @datetime 2017-11-30 15:40:00
 */
class MyQueryParamAuth extends QueryParamAuth {

    public $tokenParam = 'userToken';

    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response) {
        $accessToken = $request->post($this->tokenParam);
        if (empty($accessToken)) {
            $accessToken = $request->get($this->tokenParam);
        }
        if (is_string($accessToken)) {
            $identity = $user->loginByAccessToken($accessToken, get_class($this));
            if ($identity !== null) {
                return $identity;
            }
        }
        if ($accessToken !== null) {
//            $this->handleFailure($response);
            throw new HttpException(200, '不存在的TOKEN', 401);
        }

        return null;
    }

}
