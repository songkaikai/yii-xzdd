<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use app\models\Products;

$this->title = '会员报单复投';
$this->params['breadcrumbs'][] = ['label' => '订单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="content-create">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('订单管理', ['index']) ?></li>
            <li role="presentation" class="active"><?= Html::a('会员报单', ['futou']) ?></li>
        </ul>
        <div class="tab-content">
            <div class="content-form">

                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'goodsId')->dropDownList(Products::getTree()) ?>
                <?= $form->field($model, 'payPass')->passwordInput() ?>
                <div class="form-group">
                    <?= Html::submitButton('提交', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>