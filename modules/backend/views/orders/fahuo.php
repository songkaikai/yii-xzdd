<?php

use yii\helpers\Html;
use yii\dwz\DwzGridView;
use common\models\Orders;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '订单列表';
$this->params['breadcrumbs'][] = $this->title;
echo Html::hiddenInput('csrfvalue', Yii::$app->request->getCsrfToken(), ['id' => 'csrfvalue']);

?>


<?=

DwzGridView::widget([
    'dataProvider' => $dataProvider,
    'toolBtn' => '',
    'dialogWidth' => 1000,
    'dialogHeight' => 600,
//    'toolBtn' => '{excel}',
//    'excleUrl' => Url::toRoute(['/orders/export']),
    'pager' => array(
        'class' => 'yii\dwz\DwzPager',
        'showWrap' => true,
        'extparam' => [
            'OrdersSearch[order_no]' => $searchModel->order_no,
            'OrdersSearch[order_type]' => $searchModel->order_type,
            'OrdersSearch[status]' => $searchModel->status,
            'OrdersSearch[supplier_id]' => $searchModel->supplier_id,
        ]
    ),
    'quickCnt' => array(
        array(
            'name' => '<label>订单编号:</label>',
            'value' => Html::textInput('OrdersSearch[order_no]', $searchModel->order_no)
        ),
        array(
            'name' => '<label>订单类型:</label>',
            'value' => Html::dropDownList('OrdersSearch[order_type]',$searchModel->order_type,$searchModel->getOrderTypeData(), ['class'=>'combox', 'prompt'=>'全部']),
        ),
        array(
            'name' => '<label>订单状态:</label>',
            'value' => Html::dropDownList('OrdersSearch[status]',$searchModel->status,$searchModel->getStatusData(), ['class'=>'combox', 'prompt'=>'全部']),
        ),
        array(
            'name' => '<label>供货商:</label>',
            'value' => Html::dropDownList('OrdersSearch[supplier_id]',$searchModel->supplier_id, \common\models\Supplier::getTreeData(), ['class'=>'combox', 'prompt'=>'全部']),
        ),
    ),
    'columns' => [
        'id',
        'order_no',
        [
            'attribute' => 'member_id',
            'value' => function($model){
                return !empty($model->member) ? $model->member->true_name : '';
            }
        ],
        [
            'attribute' => 'order_type',
            'value' => function($model){
                return Orders::getOrderTypeByKey($model->order_type);
            }
        ],
        'goods_name',
        'price',
        'buy_count',
        'total',
        'add_time:datetime',
        [
            'attribute' => 'pay_time',
            'value' => function($model){
                return $model->pay_time ? Yii::$app->formatter->asDatetime($model->pay_time) : '';
            }
        ],
        [
            'attribute' => 'status',
            'value' => function($model){
                return Orders::getStatusByKey($model->status);
            }
        ],
        [
            'class' => 'yii\dwz\DwzActionColumn',
            'dialogWidth'=>800,
            'dialogHeight'=>600,
            'buttons' => [
                'shipments' => function ($url, $model, $key) {
                    return $model->status === Orders::PENDINGSHIPPED ? Html::a('发货', $url, ['target'=>'dialog', 'title'=>'您确认要发货吗？','mask'=>'true']) : '';
                },
            ],
            'template' => '{view} {shipments}',
        ],

    ],
]);
?>

