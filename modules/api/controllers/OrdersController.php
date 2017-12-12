<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\components\BaseController;
use app\models\Orders;
use app\models\form\ChangeOrderForm;
use app\models\form\RegOrderForm;

/**
 * @apiDefine OrdersGroup
 *
 * 订单管理
 */

/**
 * 订单管理
 *
 * @author Administrator
 */
class OrdersController extends BaseController {

    /**
     * 
     * @api {get} orders/index 1、会员订单列表
     * @apiName 会员订单列表
     * @apiGroup OrdersGroup
     * @apiVersion 1.0.0
     * @apiDescription 会员订单列表 
     * 
     * @apiParam {String} token 会员TOKEN 
     * @apiParam {integer} [status] 状态 1 待付款 2 待发货 3 待收货 4 交易完成
     * @apiParam {integer} [pages] 当前页
     * @apiParam {integer} [pageSize] 每页显示数量
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明
     * @apiSuccess {String} data   返回数据
     * @apiSuccess {String} data.total   总记录数
     * @apiSuccess {String} data.pageSize   每页显示数量
     * @apiSuccess {String} data.currentPage   当前页
     * @apiSuccess {String} data.lists   日志详情
     * @apiSuccess {String} data.lists.order_no   订单编号
     * @apiSuccess {String} data.lists.add_time   提现时间
     * @apiSuccess {String} data.lists.goods_name 产品名称
     * @apiSuccess {String} data.lists.buy_count 购买数量
     * @apiSuccess {String} data.lists.price 单价
     * @apiSuccess {String} data.lists.total 总价
     * @apiSuccess {String} data.lists.status 状态
     * @apiSuccess {String} data.lists.goods_id 产品id
     * @apiSuccess {String} data.lists.image 产品图片
     * @apiSuccess {String} data.lists.order_type 订单类型 1 报单订单 2 兑换订单
     * 
     * @apiSuccessExample 成功返回样例: 
     *  HTTP/1.1 200 OK 
     * { 
     * code:200, 
     * data:'', 
     * message:''
     *  } 
     *    
     */
    public function actionIndex() {
        $status = Yii::$app->request->get('status');
        $where = 'a.member_id=' . Yii::$app->member->id;
        if ($status == 1) {
            $where .= ' and a.status = 0';
        } elseif ($status == 2) {
            $where .= ' and a.status = 1';
        } elseif ($status == 3) {
            $where .= ' and a.status = 2';
        } elseif ($status == 4) {
            $where .= ' and a.status = 8';
        }
        $total = Orders::find()->alias('a')->where($where)->count();
        $orderList = Orders::find()
                ->select('a.order_no, from_unixtime(a.add_time) as add_time, a.goods_name, a.buy_count, a.price, a.total, a.status, a.goods_id, b.image, a.order_type')
                ->alias('a')
                ->leftJoin('{{%content}} b', 'a.goods_id=b.id')
                ->asArray()
                ->where($where)
                ->orderBy('a.add_time desc')
                ->limit($this->pageSize)
                ->offset(($this->currentPage - 1) * $this->pageSize)
                ->all();
        foreach ($orderList as $key => $val) {
            if ($val['goods_id'] == 0) {
                $sql = "select a.goods_name, a.buy_count, b.image from {{%orders_detail}} a left join {{%content}} b on a.goods_id = b.id where a.order_no = '{$val['order_no']}'";
                $info = Yii::$app->db->createCommand($sql)->queryAll();
                $orderList[$key]['goods_name'] = $info[0]['goods_name'] . '等';
                $orderList[$key]['image'] = $info[0]['image'];
                $orderList[$key]['buy_count'] = count($info);
            }
        }
        $returnData = [
            'total' => $total,
            'pageSize' => $this->pageSize,
            'currentPage' => $this->currentPage+1,
            'lists' => $orderList,
        ];
        return $returnData;
    }

    /**
     * 
     * @api {get} orders/view 2、查看会员订单详情
     * @apiName 查看会员订单详情
     * @apiGroup OrdersGroup
     * @apiVersion 1.0.0
     * @apiDescription 查看会员订单详情 
     * 
     * @apiParam {String} token 会员TOKEN 
     * @apiParam {String} orderNo 订单编号 
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明
     * @apiSuccess {String} data   返回数据
     * @apiSuccess {String} data.order_no   订单编号
     * @apiSuccess {String} data.status   状态
     * @apiSuccess {String} data.add_time   添加时间
     * @apiSuccess {String} data.pay_time   支付时间
     * @apiSuccess {String} data.over_time   完成时间
     * @apiSuccess {String} data.consignee   收货人姓名
     * @apiSuccess {String} data.area  收货地区
     * @apiSuccess {String} data.address   收货地址
     * @apiSuccess {String} data.mobile   手机号
     * @apiSuccess {String} data.express   快递公司
     * @apiSuccess {String} data.express_no   快递编号
     * @apiSuccess {String} data.fh_time   发货时间
     * @apiSuccess {String} data.total   合计金额
     * @apiSuccess {String} data.goods_name   产品名称
     * @apiSuccess {String} data.price   单价
     * @apiSuccess {String} data.buy_count   购买数量
     * @apiSuccess {String} data.point_amount   抵金券
     * @apiSuccess {String} data.order_money   订单总额
     * @apiSuccess {String} data.order_type   订单类型
     * @apiSuccess {String} data.image   产品图片
     * @apiSuccess {String} data.detail.goods_name   产品名称
     * @apiSuccess {String} data.detail.price   单价
     * @apiSuccess {String} data.detail.buy_count   购买数量
     * @apiSuccess {String} data.detail.total   小计
     * @apiSuccess {String} data.detail.image   产品图片
     * 
     * @apiSuccessExample 成功返回样例: 
     *  HTTP/1.1 200 OK 
     * { 
     * code:200, 
     * data:'', 
     * message:''
     *  } 
     *    
     */
    public function actionView(){
        $orderNo = Yii::$app->request->get('orderNo');
        if(empty($orderNo)){
            $this->buildValidateError('订单号不可为空');
        }
        $orderInfo = Orders::find()
                ->select('a.order_no, a.status, a.add_time, a.pay_time, a.over_time, a.consignee, a.address, a.mobile, a.express, a.express_no, a.fh_time, a.total, a.goods_name, a.price, a.buy_count, a.point_amount, a.order_money, a.order_type, a.area, b.image')
                ->alias('a')
                ->leftJoin('{{%content}} b', 'a.goods_id=b.id')
                ->asArray()
                ->where(['order_no'=>$orderNo])
                ->one();
        if($orderInfo['order_type'] == Orders::SALE_ORDER){
            $orderInfo['detail'] = \app\models\OrdersDetail::find()
                    ->select('a.id, a.goods_id, a.goods_name, a.price, a.buy_count, a.total, b.image')
                    ->asArray()
                    ->alias('a')
                    ->leftJoin('{{%content}} b', 'a.goods_id=b.id')
                    ->where(['order_no' => $orderNo])
                    ->all();
        }
        if($orderInfo['add_time']){
            $orderInfo['add_time'] = date('Y-m-d H:i:s', $orderInfo['add_time']);
        }
        if($orderInfo['pay_time']){
            $orderInfo['pay_time'] = date('Y-m-d H:i:s', $orderInfo['pay_time']);
        }
        if($orderInfo['over_time']){
            $orderInfo['over_time'] = date('Y-m-d H:i:s', $orderInfo['over_time']);
        }
        return $orderInfo;
    }
    
    /**
     * 
     * @api {get} orders/confirm 3、会员订单确认收货66
     * @apiName 会员订单确认收货66
     * @apiGroup OrdersGroup
     * @apiVersion 1.0.0
     * @apiDescription 订单确认收货 
     * 
     * @apiParam {String} token 会员TOKEN 
     * @apiParam {String} orderNo 订单编号 
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明
     * @apiSuccess {String} data   返回数据
     * @apiSuccess {String} data.result   1 成功 0 失败
     * 
     * @apiSuccessExample 成功返回样例: 
     *  HTTP/1.1 200 OK 
     * { 
     * code:200, 
     * data:'', 
     * message:''
     *  } 
     *    
     */
    public function actionConfirm(){
        $orderNo = Yii::$app->request->post('orderNo');
        if(empty($orderNo)){
            $this->buildValidateError('订单号不可为空');
        }
        $model = new ChangeOrderForm();
        $model->attributes = [
            'memberId' => Yii::$app->member->id,
            'orderNo' => $orderNo
        ];
        if($model->validate() && $model->chgToSuccess()){
            $result = 1;
        }else{
            $result = 0;
        }
        return ['result'=>$result];
    }
    
    /**
     * 
     * @api {get} orders/create 4、创建报单订单
     * @apiName 创建报单订单
     * @apiGroup OrdersGroup
     * @apiVersion 1.0.0
     * @apiDescription 创建报单订单 
     * 
     * @apiParam {String} token 会员TOKEN 
     * @apiParam {String} mobile 收货人手机号
     * @apiParam {String} consignee 收货人 
     * @apiParam {String} area 所在地区 
     * @apiParam {String} address 详细地址  
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明
     * @apiSuccess {String} data   返回数据
     * @apiSuccess {String} data.result   1 成功 0 失败
     * 
     * @apiSuccessExample 成功返回样例: 
     *  HTTP/1.1 200 OK 
     * { 
     * code:200, 
     * data:'', 
     * message:''
     *  } 
     *    
     */
    public function actionCreate(){
        $model = new RegOrderForm();
        if($model->load(Yii::$app->request->post(), '')){
            $model->memberId = Yii::$app->member->id;
            if($model->validate() && $model->build()){
                return '';
            }
        }
        $this->buildValidateError($model->getFirstErrors());
    }
}
