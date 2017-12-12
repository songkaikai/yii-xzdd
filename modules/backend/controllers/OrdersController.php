<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\Orders;
use app\modules\backend\models\OrdersSearch;
use app\modules\backend\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\dwz\DwzHelper;
use app\extend\PHPExcel\Excel;
use yii\web\UploadedFile;
use app\models\form\RepeatOrderForm;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends BackendController {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 导出数据
     * 
     * @param type $search
     */
    public function actionExport() {
        $search = Yii::$app->request->get('OrdersSearch');
        $whereStr = '';
        if($search){
            $where = array_filter($search);
            foreach ($where as $key => $val) {
                if (!empty($whereStr)) {
                    $whereStr .= ' AND ';
                }
                if (in_array($key, ['status', 'order_type'])) {
                    $whereStr .= "{{%orders}}.{$key} = {$val}";
                } elseif (in_array($key, ['mobile'])) {
                    $whereStr .= "{{%orders}}.{$key} = '{$val}'";
                }
            }
        }
        if (empty($whereStr)) {
            $whereStr .= "{{%orders}}.status = 1";
        } else {
            $whereStr .= " and {{%orders}}.status = 1";
        }
        $model = Orders::find()->select('order_no, goods_id, goods_name, price, buy_count, total, area, consignee, mobile, address, {{%member}}.nick_name')->leftJoin('{{%member}}', '{{%orders}}.member_id = {{%member}}.id')->where($whereStr)->asArray()->orderBy('pay_time asc')->limit(1000)->all();
        $final = [['物流订单号(唯一标识)', '商户单号', '商品名称(必填)', '数量（必填）', '买家姓名（必填）', '买家收货省（必填）', '买家收货市（必填', '买家收货区（必填）', '买家收货地址（必填）', '买家手机号码（必填）']];
        foreach ($model as $val) {
            if($val['goods_id'] == 0){
                $sql = "select goods_name, buy_count, price from {{%orders_detail}} where order_no = '{$val['order_no']}'";
                $info = Yii::$app->db->createCommand($sql)->queryAll();
                foreach($info as $key1 => $detail){
                    if($key1 == 0){
                        $temp = explode('-', $val['area']);
                        $final[] = [
                            ' ',
                            ' ' . $val['order_no'],
                            $detail['goods_name'],
                            $detail['buy_count'],
                            $val['consignee'],
                            ''.\yii\helpers\ArrayHelper::getValue($temp, 0, ''),
                            ''.\yii\helpers\ArrayHelper::getValue($temp, 1, ''),
                            ''.\yii\helpers\ArrayHelper::getValue($temp, 2, ''),
                            $val['address'],
                            ' ' . $val['mobile'],
                        ];    
                    }else{
                        $final[] = [
                            ' ',
                            ' ',
                            $detail['goods_name'],
                            $detail['buy_count'],
                            ' ',
                            ' ',
                            ' ',
                            ' ',
                            ' ',
                            ' ',
                        ];
                    }
                }
            }else{
                $temp = explode('-', $val['area']);
                $final[] = [
                    ' ',
                    ' ' . $val['order_no'],
                    $val['goods_name'],
                    $val['buy_count'],
                    $val['consignee'],
                    ''.\yii\helpers\ArrayHelper::getValue($temp, 0, ''),
                    ''.\yii\helpers\ArrayHelper::getValue($temp, 1, ''),
                    ''.\yii\helpers\ArrayHelper::getValue($temp, 2, ''),
                    $val['address'],
                    ' ' . $val['mobile'],
                ]; 
            }
        }
        $outFile = \Yii::$app->getRuntimePath() . '/fh/发货地址.xls';
        $ret = Excel::getInstance()->saveSheet($outFile, $final);
    }

    /**
     * 订单查看
     * 
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        $log = '';
        $expressName = '';
        $detail = [];
        $orderModel = $this->findModel($id);
        if ($orderModel->express) {
            $expressName = \yii\helpers\ArrayHelper::getValue(Yii::$app->params['express'], $orderModel->express, '');
        }
        if ($orderModel->order_type == 2) {
            $detail = \app\models\OrdersDetail::find()->asArray()->where(['order_no' => $orderModel->order_no])->all();
        }
        return $this->render('view', [
                    'model' => $orderModel,
                    'expressName' => $expressName,
                    'detail' => $detail,
        ]);
    }

    /**
     * 卖家发货填写快递
     * @param $id
     * @param int $dialog
     * @throws NotFoundHttpException
     */
    public function actionShipments($id) {
        $model = $this->findModel($id);
        return $this->render('shipments', [
                    'model' => $model,
        ]);
    }

    /**
     * 发货
     * 
     * @param type $id
     * @param type $dialog
     */
    public function actionShipmentsConfirm($id, $dialog = 1) {
        $model = $this->findModel($id);
        if ($model->status == $model::PENDINGSHIPPED) {
            $chgModel = new \app\models\form\ChangeOrderForm();
            $chgModel->scenario = 'fahuo';
            $chgModel->attributes = [
                'orderNo' => $id,
                'express' => Yii::$app->request->post('shipping'),
                'expressNo' => trim(Yii::$app->request->post('invoice_no')),
            ];
            Yii::$app->cache->set('shippingId', $chgModel->express);
            if ($chgModel->chgToShip()) {
                //同步支付订单状态
                return $this->showFlash('发货成功', 'success', ['index']);
            } else {
                return $this->showFlash('发货失败', 'error', ['index']);
            }
        } else {
            return $this->showFlash('该订单目前是不可以发货状态', 'error', ['index']);
        }
    }

    /**
     * Excel导入发货
     */
    public function actionImport() {
        if (Yii::$app->request->isPost) {
            $fileModel = UploadedFile::getInstanceByName('excel');
            if ($fileModel) {
                $filename = date('YmdHis') . rand(1000, 9999) . '.' . $fileModel->extension;
                $filePath = Yii::getAlias('@app/web') . '/upload/';
                $fileModel->saveAs($filePath . $filename);
                $this->readExcel($filePath . $filename, Yii::$app->request->post('export'));
            }
            return $this->showFlash('发货成功', 'success');
        }
        return $this->render('import');
    }

    private function readExcel($file, $express) {
        $excelData = Excel::getInstance()->readSheet($file);
        $sql = '';
        foreach ($excelData as $val) {
            $sql .= "update {{%orders}} set status = " . Orders::PENDINGRECEIVING . ", express='{$express}', express_no='{$val[1]}', fh_time=" . time() . " where order_no = '" . trim($val[0]) . "' and status = 1;";
        }
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * Deletes an existing Orders model.
     * 
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        if ($this->findModel($id)->delete()) {
            DwzHelper::ok('删除成功', 200, '', '', '');
        } else {
            DwzHelper::error('删除失败');
        }
    }

    /**
     * 会员购买报单
     * @return type
     */
    public function actionFutou(){
        $model = new RepeatOrderForm();
        $post = Yii::$app->request->post();
        if ($post) {
            if ($model->load($post) && $model->validate() && $model->repeat()) {
                return $this->showFlash('报单成功', 'success');
            }
        }
        return $this->render('futou', [
                    'model' => $model,
        ]);
    }
    
    /**
     * Finds the Orders model based on its primary key value.
     * 
     * @param string $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
