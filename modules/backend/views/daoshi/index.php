<?php

use yii\helpers\Html;
use app\modules\backend\widgets\GridView;
use app\models\Daoshituan;
use yii\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pagination yii\data\Pagination */

$this->title = '导师管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><?= Html::a('导师管理', ['index']) ?></li>
            <li role="presentation"><?= Html::a('添加导师', ['create']) ?></li>
        </ul>
        <div class="tab-content">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => CheckboxColumn::className()],
                    [
                        'attribute' => 'id',
                        'options' => ['style' => 'width:50px']
                    ],
                    'nick_name',
                    'team_name',
                    'wechat_no',
                    'sorts',
                    [
                        'class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',
                        'options' => ['style' => 'width:60px']
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>