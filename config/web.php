<?php
use yii\helpers\ArrayHelper;

$appPath = dirname(__DIR__);
$params = require(__DIR__ . '/params.php');
if(is_file($appPath . '/runtime/config/params.php')){
    $params = ArrayHelper::merge($params, require ($appPath . '/runtime/config/params.php'));
}
$view = require(__DIR__ . '/view.php');
if(is_file($appPath . '/runtime/config/view.php')){
    $view = ArrayHelper::merge($view, require($appPath . '/runtime/config/view.php'));
}

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'timeZone' => 'Asia/Shanghai',
    'language' => 'zh-CN',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Q-TAjtqKlLrK2nQLbeDDHBI00UPsApCB',
        ],
        'user' => [
            'class'=>'yii\web\User',
            'identityClass' => 'app\modules\backend\models\AdminUserIdentity',
            'enableAutoLogin' => false,
            'loginUrl'=>['backend/default/login']
        ],
        'member' => [
            'class'=>'yii\web\User',
            'identityClass' => 'app\models\Member',
            'enableAutoLogin' => false,
            'loginUrl'=>['site/index']
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'alipay' => [
            'class' => 'app\extend\alipay\Alipay',
            'appId' => '2017062107534490',
            'rsaPrivateKey' => 'MIIEpAIBAAKCAQEA6F2xhgmRfG+dXmmJpPOQR3G37y3Pxf9prS4LRCOdeSdHv2hh5evH0ZLqxQVz+KBr43wzuYX7fwyjIEl1HeD4HzvnUAzLEDHpYiVnCqUVodWOFwFWb2wV5XTFbgqWbj2w6KiWwtGCobDeS+RBrMLsIJtNNa+vjwKHUXPmFz3yKUhSton6fpsDTWaTo+sOrftDdcwGAOoNz7Lj7Sy9uLKW+TvQm2txXmxPuRm77jxc8300mOdsg/4MZUMpRFfBlQViBt9Kk2p254kNISu/IG4n5P7BU3PWphydcTKQXHfhiC/SLXjlFU0kz3hTM3oZlrDwLG9239MXswsmO+db2NYeAQIDAQABAoIBAFBcPs3VN0xqqWkCZMj4NviOWodMN6QJHfn3h4vsKUTCEe0fY2QJs9RF1A2JQj9E86r7xEOwE3cv3qaG4QsRR549sFSd6AhUyprXxpgG2cFbQsWv/72PCs+NH85buQStLyZ3T5RWsq/KpEZozVG7I8BvFTew5600uamwxG1bTgl6QeP0aMAE0Lgr5GYhRebVgLCiWZDBivBVag2z2flxZH8P6vbCzUUg2t/zoWI5Bvse4tq5g154UhZpea1ArHV0xOhD6bD8NiN3ANUIpxjJtxrhOJNzAZqSj9Tw1fZIJMMHF3h6G7bhXZ5PGtpqt4mWN6a4ZuFiqmuGvHSlyGIWOGUCgYEA+wVqryqwD6P0uxOlUBo+9FYs2Rq18IOLq2QlhjqmvaU681ZXNChida9U+sigDlHO1/tNDVW3i2LCpT+vDKp7UTGhaUoCpE/el+ttHrnzx+J8NUjPW8u31oHCAKsszNkbu5a9xnrRigau9qz+kygCyRrMQNYt4kUoZqaxQfBsRacCgYEA7PmNqRf4Fz26q1mBxtgCTEaQ+bKyh+xVjGBYSMUzR8DzJAODuEr9PDdN2UkvXXXNPhEz4WC43st0k3BaNcddQSzKd/8TGQrt38E4cOwzd3CqeDM3+uLXJSnTuILbyoq7pKZ1UInd93lub21bKmXOIyCui1+X/u3PgIHtnCD4xBcCgYAkPtD7wAcyCvOQe7K4EUIb18GcC55Pvz7QnaJJcniXE5+ieUoYLuigo5N6rrNlvexHBXNHxKO/DaCbacml44vw2mC7KkOdZCb4+raD5EfOCebzbrL6Rz0hTRUtMYpDfeniOU7ntN5CttpWpf4QU4urbCIoDoULkf7Wa6VWpxeLKwKBgQCAG4S2heurfMZ+PVwIB9xuKbPUGQOksWGqCqePZ3QKdUe8D15U8c0mkWs3bPX7G2UCCcC3NVebsfdqgVFzQzypsDIgXrePUTY5QTZm7XoBNtohMucvbRQL1inL1IpHW2qHXymKiY2CbJYEDOU87V5b5R4W4G3F9f+4JAU04yo4rwKBgQDv7yt/yh8MwNWZk/DsaxADcof6NDYfYL0y1gPP45iGXMK3gPrzorfZn8uGRo9uTNWRHh4S5CwuF221rKsBgBArxjV1zjNL5eMp32LDCCfft5YFOwlYi8H4lfxPeF34gEfuDHvJCnGPIOIwDpnClUG98XJ/OsnDXD0B9h9huf2Z8w==',
            'alipayrsaPublicKey' => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                   
            ],
        ],
        'formatter'=>[
            'class'=>'yii\i18n\Formatter',
            'defaultTimeZone'=>'Asia/Shanghai',
            'dateFormat'=>'php:Y-m-d',
            'timeFormat'=>'php:H:i:s',
            'currencyCode' => '￥',
            'datetimeFormat'=>'php:Y-m-d H:i:s'
        ],
        'view' =>&$view,
        'i18n' => [
            'class'=>'yii\i18n\I18N',
            'translations' => [
                'rbac-admin' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@mdm/admin/messages', // if advanced application, set @frontend/messages
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
        ],
    ],
    'params' => &$params,
    'language'=>'zh-CN',
    'modules' => [
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
        'backend' => [
            'class' => 'app\modules\backend\Module',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

if(isset($params['appName'])){
    $config['name'] = $params['appName'];
}
return $config;
