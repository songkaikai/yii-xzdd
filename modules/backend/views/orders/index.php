<?php

use yii\helpers\Html;
use app\modules\backend\widgets\GridView;
use yii\grid\CheckboxColumn;
use app\models\Orders;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><?= Html::a('订单列表', ['index']) ?></li>
        </ul>
        <div class="tab-content">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                        [
                        'attribute' => 'order_type',
                        'value' => function ($model, $key, $index, $column) {
                            return $model->getOrderTypeByKey($model['order_type']);
                        }
                    ],
                    'order_no',
                        [
                        'header' => '会员名称',
                        'value' => function ($model, $key, $index, $column) {
                            return $model['nick_name'];
                        }
                    ],
                    'goods_name',
                    'price',
                    'buy_count',
                    'total',
                    'add_time:datetime',
                    'pay_time:datetime',
                    'consignee',
                    // 'address',
                    'mobile',
                        [
                        'attribute' => 'status',
                        'value' => function ($model, $key, $index, $column) {
                            return $model->getStatusByKey($model['status']);
                        }
                    ],
                        [
                        'class' => 'yii\grid\ActionColumn',
                        'buttons' => [
                            'shipments' => function ($url, $model, $key) {
                                return $model->status === Orders::PENDINGSHIPPED ? Html::a('发货', $url) : '';
                            },
                        ],
                        'template' => '{view} {shipments}',
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
