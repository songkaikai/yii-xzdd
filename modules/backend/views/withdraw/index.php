<?php

use yii\helpers\Html;
use app\modules\backend\widgets\GridView;
use app\models\Withdraw;
use yii\helpers\Url;

$this->title = '提现列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><?= Html::a('提现列表', ['index']) ?></li>
        </ul>
        <div class="tab-content">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'withdraw_type',
                        'value' => function($model) {
                            return $model->getWithdrawTypeValByKey($model['withdraw_type']);
                        }
                    ],
                    'uname',
                    'nick_name',
                    'draw_money:currency',
                    'pay_money:currency',
                    'add_time:datetime',
                    [
                        'attribute' => 'cash_time',
                        'value' => function($model) {
                            return $model['cash_time'] ? date('Y-m-d H:i:s', $model['cash_time']) : '';
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function($model) {
                            return $model->getStatusValByKey($model['status']);
                        }
                    ],
                    'pay_no',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'buttons' => [
                            'send-red' => function ($url, $model, $key) {
                                return $model->status === Withdraw::WAIT && $model->withdraw_type === 'wechat' ? Html::a('发红包', $url, ['data-pjax'=>0]) : '';
                            },
                            'chuli' => function ($url, $model, $key) {
                                return $model->status === Withdraw::WAIT ? Html::a('手动处理', $url, ['data-pjax'=>0]) : '';
                            },
                        ],
                        'template' => '{send-red} {chuli}',
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>