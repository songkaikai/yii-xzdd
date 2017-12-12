<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Orders;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = '订单发货';
$this->params['breadcrumbs'][] = ['label' => '订单列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('订单列表', ['index']) ?></li>
            <li role="presentation" class="active"><?= Html::a('订单发货', '#') ?></li>
        </ul>
        <div class="tab-content">
            <div class="content-form">

                <?php $form = ActiveForm::begin(['action' => ['/backend/orders/shipments-confirm', 'id' => $model->order_no]]); ?>
                <div class="form-group field-products-title required">
                    <label class="control-label" for="products-title">快递公司</label>
                    <select name="shipping" id="shipping_opt">
                        <?php
                        $shippingId = Yii::$app->cache->get('shippingId');
                        foreach (Yii::$app->params['express'] as $k => $v) {
                            if ($shippingId == $k) {
                                $selected = "selected='selected'";
                            } else {
                                $selected = '';
                            }
                            echo "<option value='" . $k . "' {$selected}>" . $v . "</option>";
                        }
                        ?>
                    </select>
                    <div class="help-block"></div>
                </div>
                <div class="form-group field-products-title required">
                    <label class="control-label" for="products-title">物流单号</label>
                    <input type="text" name="invoice_no" id="invoice_no"/>
                    <div class="help-block"></div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('提交', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>