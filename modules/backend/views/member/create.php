<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use app\models\Products;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = '会员注册';
$this->params['breadcrumbs'][] = ['label' => '会员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('会员列表', ['index']) ?></li>
            <li role="presentation" class="active"><?= Html::a('会员注册', ['create']) ?></li>
            <li role="presentation"><?= Html::a('会员充值', ['recharge']) ?></li>
        </ul>
        <div class="tab-content">
            <div class="content-form">
                <?php $form = ActiveForm::begin(['options' => ['class' => 'layui-form']]); ?>
                <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'trueName')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'recommName')->textInput(['maxlength' => true]) ?>
                <div class="form-group">
                    <?= Html::submitButton('提交', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>