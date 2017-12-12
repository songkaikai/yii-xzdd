<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = '批量导入发货';
$this->params['breadcrumbs'][] = ['label' => '订单列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('订单列表', ['index']) ?></li>
            <li role="presentation" class="active"><?= Html::a('批量导入发货', '#') ?></li>
        </ul>
        <div class="tab-content">
            <div class="content-form">

                <?php $form = ActiveForm::begin(['action' => Url::toRoute(['/backend/orders/import']), 'method' => 'post', 'options' => ['enctype' => 'multipart/form-data', 'novalidate'=>'novalidate']]); ?>
                <div class="form-group field-products-title required">
                    <label class="control-label" for="products-title">默认快递</label>
                    <?= Html::dropDownList('export', '', Yii::$app->params['express']) ?>
                </div>
                <div class="form-group field-products-title required">
                    <label class="control-label" for="products-title">Excel文件</label>
                    <?= Html::fileInput('excel') ?>
                    <div class="help-block">表格共两列，第一列订单号，第二列快递单号,格式xls</div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('提交', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>