<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use app\models\Products;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = '更改会员推荐人';
$this->params['breadcrumbs'][] = ['label' => '会员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('会员列表', ['index']) ?></li>
            <li role="presentation" class="active"><?= Html::a('更改会员推荐人', ['chg-recomm']) ?></li>
        </ul>
        <div class="tab-content">
            <div class="content-form">
                <p><label>会员账号：</label><?= $memberInfo['uname']; ?></p>
                <p><label>会员昵称：</label><?= $memberInfo['nick_name']; ?></p>
                <p><label>原推荐人：</label><?= $memberInfo['recomm_name']; ?></p>
                <?php $form = ActiveForm::begin(['options' => ['class' => 'layui-form']]); ?>
                <?= $form->field($model, 'memberId')->hiddenInput()->label(''); ?>
                <?= $form->field($model, 'recommMobile')->textInput(['maxlength' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('提交', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>