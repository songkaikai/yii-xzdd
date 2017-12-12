<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = '提现列表';
$this->params['breadcrumbs'][] = ['label' => '提现列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('提现列表', ['index']) ?></li>
            <li role="presentation" class="active"><?= Html::a('提现单处理', ['chuli']) ?></li>
        </ul>
        <div class="tab-content">
            <div class="content-form">
                <?php $form = ActiveForm::begin(['action' => ['/backend/withdraw/confirm', 'id' => $model['id'], 'lastpage' => $lastpage]]); ?>
                <div class="form-group field-products-title required">
                    <label class="control-label" for="products-title">会员用户名</label>
                    <?= $model['uname']; ?>
                </div>
                <div class="form-group field-products-title required">
                    <label class="control-label" for="products-title">会员昵称</label>
                    <?= $model['nick_name']; ?>
                </div>
                <div class="form-group field-products-title required">
                    <label class="control-label" for="products-title">提现金额</label>
                    <?= Yii::$app->formatter->asCurrency($model['draw_money']); ?>
                </div>
                <div class="form-group field-products-title required">
                    <label class="control-label" for="products-title">实付金额</label>
                    <?= Yii::$app->formatter->asCurrency($model['pay_money']); ?>
                </div>
                <?php
                    if($model['withdraw_type'] == 'bank'){
                ?>
                <div class="form-group field-products-title required">
                    <label class="control-label" for="products-title">开户行</label>
                    <?= $model['bank_name']; ?>
                </div>
                <div class="form-group field-products-title required">
                    <label class="control-label" for="products-title">姓名</label>
                    <?= $model['true_name']; ?>
                </div>
                <div class="form-group field-products-title required">
                    <label class="control-label" for="products-title">账号</label>
                    <?= $model['card_no']; ?>
                </div>
                <?php
                    }elseif($model['withdraw_type'] == 'alipay'){
                ?>
                <div class="form-group field-products-title required">
                    <label class="control-label" for="products-title">姓名</label>
                    <?= $model['true_name']; ?>
                </div>
                <div class="form-group field-products-title required">
                    <label class="control-label" for="products-title">账号</label>
                    <?= $model['alipay_no']; ?>
                </div>
                <?php   
                    }
                ?>
                <div class="form-group field-products-title required">
                    <label class="control-label" for="products-title">转账单号</label>
                    <input type="text" name="invoice_no" id="invoice_no"/>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('确定', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

