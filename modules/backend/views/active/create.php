<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ad */

$this->title = '添加图片';
$this->params['breadcrumbs'][] = ['label' => '活动图', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-create">

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('活动图管理', ['index']) ?></li>
            <li role="presentation" class="active"><?= Html::a('添加活动图', ['create']) ?></li>
        </ul>
        <div class="tab-content">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
