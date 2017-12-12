<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/themes/default/css/reset.css',
        '/themes/default/css/common.css',
        '/themes/default/css/swiper.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

    //加载微信支付脚本
    public static function loadWeixinPay($view) {
        $view->registerJsFile('http://res.wx.qq.com/open/js/jweixin-1.0.0.js', ['depends' => 'app\assets\AppAsset']);
    }

    //导入当前页的功能js文件，注意加载顺序，这个应该最后调用
    public static function addPageScript($view, $jsfile) {
        $view->registerJsFile($jsfile, ['depends' => 'app\assets\AppAsset']);
    }

}
