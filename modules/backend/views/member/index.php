<?php

use yii\helpers\Html;
use app\modules\backend\widgets\GridView;
use yii\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pagination yii\data\Pagination */

$this->title = '会员列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><?= Html::a('会员列表', ['index']) ?></li>
            <li role="presentation"><?= Html::a('会员注册', ['create']) ?></li>
            <li role="presentation"><?= Html::a('会员充值', ['recharge']) ?></li>
        </ul>
        <div class="tab-content">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                        ['class' => CheckboxColumn::className()],
                    'id',
                    'uno',
                    'uname',
                    'nick_name',
                    'recommend_name',
                    [
                        'attribute' => 'level',
                        'value' => function ($model, $key, $index, $column) {
                            return $model->getLevelValByKey($model['level']);
                        }
                    ],
                    'commissions:currency',
                    'balance:currency',
                    'integral_balance',
                    'vouchers',
                    'team',
                    'recomm_count',
                    'reg_time:datetime',
                        [
                        'attribute' => 'status',
                        'value' => function ($model, $key, $index, $column) {
                            return $model->getStatusValByKey($model['status']);
                        }
                    ],
                        [
                        'class' => 'yii\grid\ActionColumn',
                        'buttons' => [
                            'lock' => function ($url, $model, $key) {
                                $options = [
                                    'title' => '您确认要锁定该会员吗',
                                    'aria-label' => '锁定',
                                    'target' => 'ajaxTodo',
                                ];
                                return $model->status == 1 ? Html::a('锁定', $url, $options) : '';
                            },
                            'unlock' => function ($url, $model, $key) {
                                $options = [
                                    'title' => '您确认要解锁该会员吗',
                                    'aria-label' => '解锁',
                                    'target' => 'ajaxTodo',
                                ];
                                return $model->status == 0 ? Html::a('解锁', $url, $options) : '';
                            },
                            'chg-recomm' => function ($url, $model, $key) {
                                return Html::a('改推荐人', $url, ['data-pjax'=>0]);
                            },
                            'reset-pass' => function ($url, $model, $key) {
                                return Html::a('重置密码', $url, ['data-pjax'=>0]);
                            },
                        ],
                        'template' => '{lock} {unlock} {chg-recomm} {reset-pass}',
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
