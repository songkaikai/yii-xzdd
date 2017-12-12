<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\components\Tool;
use yii\web\View;

$this->title = '查看订单详情';

$this->params['breadcrumbs'][] = ['label' => '订单列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row" style="margin: 0px 10px;">
    <div class="box box-info">
        <div class="box-header">
            <p>订单编号：<?= $model->order_no; ?></p>
            <p>客户名称：<?= $model->member->nick_name; ?></p>
            <p>订单状态：<?= $model->getStatusByKey($model->status); ?></p>
            <p>下单时间：<?= date('Y-m-d H:i:s', $model->add_time); ?></p>
            <p>完成时间：<?= $model->over_time ? date('Y-m-d H:i:s', $model->over_time) : ''; ?></p>
            <p>收货人：<?= $model->consignee; ?></p>
            <p>手机：<?= $model->mobile; ?></p>
            <p>地址：<?= $model->area . ' ' . $model->address; ?></p>
            <p>快递公司：<?= $expressName; ?></p>
            <p>快递单号：<?= $model->express_no; ?></p>
        </div>
        <div class="box-body" style="margin-bottom: 0;">
            <table class="table table-bordered" style="margin-bottom: 0;">
                <tr>
                    <th>产品名称</th>
                    <th width="150">单价</th>
                    <th width="150">购买数量</th>
                    <th width="150">小计</th>
                </tr>
                <?php
                if($model->order_type == 1){
                ?>
                <tr>
                    <td><?php echo $model->goods_name; ?></td>
                    <td><?php echo $model->price; ?></td>
                    <td><?php echo $model->buy_count; ?></td>
                    <td><?php echo $model->total; ?></td>
                </tr>
                <?php
                }else{
                foreach ($detail as $val) {
                    ?>
                    <tr>
                        <td><?= $val['goods_name']; ?></td>
                        <td><?= $val['price']; ?></td>
                        <td><?= $val['buy_count']; ?></td>
                        <td><?= $val['total']; ?></td>
                    </tr>
                    <?php
                }
                }
                ?>
            </table>
        </div>
        <div class="box-footer text-right">
            <p>米抵现：<?= $model->point_amount; ?></p>
            <p>实收: <?= Yii::$app->formatter->asCurrency($model->total); ?></p>
        </div>
    </div>
</div>