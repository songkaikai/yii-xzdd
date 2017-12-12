<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use app\models\Cart;

$this->beginContent('@app/views/layouts/main.php');
?>
<?= $content; ?>
<!-- 底部导航 -->
<div class="bottom-nav border-top-1px">
    <a href="<?= Url::toRoute(['/guide/index']) ?>" class="home index">
        <i></i>
        <p>首页</p>
    </a>
    <a href="<?= Url::toRoute(['/cart/add']) ?>" class="shopcart">
        <i></i>
        <p>购物车</p>
    </a>
    <a href="<?= Url::toRoute(['/home/index']) ?>" class="my">
        <i></i>
        <p>我的</p>
    </a>
</div>
<?php $this->endContent(); ?>