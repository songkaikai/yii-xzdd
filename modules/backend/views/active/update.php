<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ad */

$this->title = '修改轮播图: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '活动图管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="ad-update">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('活动图管理', ['index']) ?></li>
            <li role="presentation"><?= Html::a('添加活动图', ['create']) ?></li>
            <li role="presentation" class="active"><?= Html::a('修改活动图', ['#']) ?></li>
        </ul>
        <div class="tab-content">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
