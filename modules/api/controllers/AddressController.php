<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\components\BaseController;
use app\models\form\AddressForm;

/**
 * @apiDefine AddressGroup
 *
 * 地址接口
 */

/**
 * 地址管理
 *
 * @author Administrator
 */
class AddressController extends BaseController {

    /**
     * 
     * @api {get} address/index 1、获取会员的全部收货地址
     * @apiName 获取会员的全部收货地址
     * @apiGroup AddressGroup
     * @apiVersion 1.0.0
     * @apiDescription 获取会员收货地址 
     * 
     * @apiParam {String} token 会员TOKEN 
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明 
     * @apiSuccess {String} data 
     * @apiSuccess {String} data.id 地址id
     * @apiSuccess {String} data.consignee 收货人
     * @apiSuccess {String} data.address 地址
     * @apiSuccess {String} data.mobile 手机号
     * @apiSuccess {String} data.area 所在地区
     * @apiSuccess {String} data.is_default 是否默认 1是 0 不是
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
        $sql = "select id, consignee, address, mobile, area, is_default "
                . "from {{%address}} where member_id = " . Yii::$app->member->id . " order by is_default desc, id desc";
        $record = Yii::$app->db->createCommand($sql)->queryAll();
        return $record;
    }

    /**
     * 
     * @api {post} address/create 2、添加收货地址
     * @apiName 添加收货地址
     * @apiGroup AddressGroup
     * @apiVersion 1.0.0
     * @apiDescription 添加收货地址 
     * 
     * @apiParam {String} token 会员TOKEN
     * @apiParam {String} consignee 收货人
     * @apiParam {String} address 地址
     * @apiParam {String} mobile 手机号
     * @apiParam {String} area 所在地区
     * @apiParam {integer} isDefault 是否设为默认
     * @apiParam {integer} isFirst 是否首次加
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明 
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
    public function actionCreate() {
        $model = new AddressForm();
        $model->scenario = 'add';
        if($model->load(Yii::$app->request->post(), '')){
            $model->memberId = Yii::$app->member->id;
            if($model->validate() && $model->create()){
                return ['addressId'=>$model->addressId];
            }
        }
        $this->buildValidateError($model->getFirstErrors());
    }

    /**
     * 
     * @api {post} address/update 3、编辑会员的收货地址
     * @apiName 编辑会员的收货地址
     * @apiGroup AddressGroup
     * @apiVersion 1.0.0
     * @apiDescription 编辑会员的收货地址 
     * 
     * @apiParam {String} token 会员TOKEN
     * @apiParam {integer} addressId 收货地址ID
     * @apiParam {String} consignee 收货人
     * @apiParam {String} address 地址
     * @apiParam {String} mobile 手机号
     * @apiParam {String} area 所在地区
     * @apiParam {integer} isDefault 是否设为默认
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明 
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
    public function actionUpdate() {
        $model = new AddressForm();
        $model->scenario = 'edit';
        if($model->load(Yii::$app->request->post(), '')){
            $model->memberId = Yii::$app->member->id;
            if($model->validate() && $model->update()){
                return [];
            }
        }
        $this->buildValidateError($model->getFirstErrors());
    }
    
    /**
     * 
     * @api {post} address/delete 4、删除会员收货地址
     * @apiName 删除会员收货地址
     * @apiGroup AddressGroup
     * @apiVersion 1.0.0
     * @apiDescription 删除收货地址 
     * 
     * @apiParam {String} token 会员TOKEN
     * @apiParam {integer} addressId 收货地址ID
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明 
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
    public function actionDelete() {
        $model = new AddressForm();
        $model->scenario = 'delete';
        if($model->load(Yii::$app->request->post(), '')){
            $model->memberId = Yii::$app->member->id;
            if($model->validate() && $model->delete()){
                return [];
            }
        }
        $this->buildValidateError($model->getFirstErrors());
    }
}
