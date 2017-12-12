<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MemberSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pageHeader">
    <div class="searchBar">
<ul class="searchContent member-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
        'enableClientScript' => FALSE,
        'options' => ['onsubmit' => 'return navTabSearch(this);'],
        'fieldConfig' => [
                    'options' => ['tag' => 'li'],
                    'inputOptions' => ['class' => 'scinput']
                ]
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'uno') ?>

    <?= $form->field($model, 'uname') ?>

    <?= $form->field($model, 'nick_name') ?>

    <?= $form->field($model, 'password_hash') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'true_name') ?>

    <?php // echo $form->field($model, 'reg_time') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'recommender') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'route') ?>

    <?php // echo $form->field($model, 'commissions') ?>

    <?php // echo $form->field($model, 'balance') ?>

    <?php // echo $form->field($model, 'password_reset_token') ?>

    <?php // echo $form->field($model, 'avatar') ?>

    <?php // echo $form->field($model, 'openid') ?>

    <?php // echo $form->field($model, 'access_token') ?>

    <?php // echo $form->field($model, 'refresh_token') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <li>
        <?= Html::submitButton('查询', ['class' => 'sure']) ?>
    </li>

    <?php ActiveForm::end(); ?>

</ul>
    </div>
</div>