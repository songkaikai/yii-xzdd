<?php

use yii\helpers\Html;
use app\modules\backend\widgets\GridView;
use yii\grid\CheckboxColumn;

$this->title = '公排池';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><?= Html::a('公排池', ['index']) ?></li>
        </ul>
        <div class="tab-content">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    'nick_name',
                    'order_id',
                    'send_money',
                    'layer',
                    'column',
                    [
                        'header' => '是否出局',
                        'value' => function ($model, $key, $index, $column) {
                            return $model['is_chu'] ? '是':'';
                        }
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
