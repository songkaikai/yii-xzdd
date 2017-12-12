<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="content-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'nick_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'team_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'wechat_no')->textarea() ?>
    <?= $form->field($model, 'avatarFile')->widget(
        FileInput::class,
        [
            'pluginOptions' => [
                'showUpload' => false,
                'initialPreview' => empty($model->avatar)?'':[\yii\helpers\Url::to($model->avatar)],
                'initialPreviewAsData' => true,
            ],
            'pluginEvents' => [
                "fileclear" => "function() { $('#daoshi-avatar').val('');}",
            ],
        ]
    ) ?>
    <?= $form->field($model, 'avatar',['options'=>['style'=>'display:none']])->hiddenInput(['id'=>'daoshi-avatar'])?>
    <?= $form->field($model, 'codeFile')->widget(
        FileInput::class,
        [
            'pluginOptions' => [
                'showUpload' => false,
                'initialPreview' => empty($model->wechat_code)?'':[\yii\helpers\Url::to($model->wechat_code)],
                'initialPreviewAsData' => true,
            ],
            'pluginEvents' => [
                "fileclear" => "function() { $('#daoshi-code').val('');}",
            ],
        ]
    ) ?>
    <?= $form->field($model, 'wechat_code',['options'=>['style'=>'display:none']])->hiddenInput(['id'=>'daoshi-code'])?>
    <?= $form->field($model, 'sorts')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>