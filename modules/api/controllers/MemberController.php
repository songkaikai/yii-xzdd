<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\components\BaseController;
use app\models\LoginForm;
use app\models\form\MemberRegForm;
use app\models\Orders;
use app\models\Member;
use app\models\form\ChgPasswordForm;
use app\models\OrdersFenghong;
use app\models\form\UserRegForm;

/**
 * @apiDefine MemberGroup
 *
 * 会员接口
 */

/**
 * Description of MemberController
 *
 * @author Administrator
 */
class MemberController extends BaseController {

    /**
     * 
     * @api {post} member/login 1、会员登录
     * @apiName 1、会员登录 
     * @apiGroup MemberGroup
     * @apiVersion 1.0.0
     * @apiDescription 会员登录，获取token 
     * 
     * @apiParam {String} username 用户名 
     * @apiParam {String} password 密码
     *  
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明
     * @apiSuccess {Object} data
     * @apiSuccess {String} data.token 用户token
     * @apiSuccess {String} data.haveAdd 是否补全订单收货地址 1 已补全 0 未补
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
    public function actionLogin() {
        $model = new LoginForm;
        $model->setAttributes(Yii::$app->request->post());
        if ($user = $model->login()) {
            if ($user) {
//                $orderInfo = Orders::find()->select('order_no, consignee')->where(['member_id'=>$user->id])->one();
//                if($orderInfo && $orderInfo['consignee']){
//                    $haveAdd = 1;
//                }else{
//                    $haveAdd = 0;
//                }
                $haveAdd = \app\models\Address::find()->where(['member_id'=>$user->id, 'is_default'=>1])->count();
                return ['token' => $user->api_token, 'haveAdd'=>$haveAdd];
            } else {
                $this->buildValidateError($user->getFirstErrors());
            }
        }
        $this->buildValidateError($model->getFirstErrors());
    }
    
    /**
     * 
     * @api {post} member/register 11、会员注册
     * @apiName 11、会员注册 
     * @apiGroup MemberGroup
     * @apiVersion 1.0.0
     * @apiDescription 会员注册 
     * 
     * @apiParam {String} mobile 手机号 
     * @apiParam {String} password 密码
     * @apiParam {String} confirmPassword  确认密码
     * @apiParam {String} trueName 真实姓名
     * @apiParam {String} recommName 推荐人手机号或编号
     *  
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明
     * @apiSuccess {Object} data
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
    public function actionRegister(){
        $model = new UserRegForm();
        if ($model->load(Yii::$app->request->post(), '')) {
            if($model->validate() && $model->register()){
                return '';
            }
        }
        $this->buildValidateError($model->getFirstErrors());
    }

    
    /**
     * 
     * @api {post} member/create 2、开通会员
     * @apiName 开通会员
     * @apiGroup MemberGroup
     * @apiVersion 1.0.0
     * @apiDescription 开通会员 
     * 
     * @apiParam {string} token  添加会员TOKEN 
     * @apiParam {string} mobile 手机号
     * @apiParam {string} trueName 昵称
     * @apiParam {string} recommName 推荐人姓名
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
        $model = new MemberRegForm();
        if($model->load(Yii::$app->request->post(), '')){
            $model->memberId = Yii::$app->member->id;
            if($model->validate() && $model->register()){
                return [];
            }
        }
        $this->buildValidateError($model->getFirstErrors());
    }

    /**
     * 
     * @api {post} member/set-pass 3、设置登录密码
     * @apiName 设置登录密码
     * @apiGroup MemberGroup
     * @apiVersion 1.0.0
     * @apiDescription 设置登录密码 
     * 
     * @apiParam {string} token 会员TOKEN
     * @apiParam {string} oldPassword 原密码
     * @apiParam {string} newPassword 新密码
     * @apiParam {string} newPasswordConfirm 确认新密码
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
    public function actionSetPass() {
        $errorMsg = '';
        $model = new ChgPasswordForm();
        if ($model->load(Yii::$app->request->post(), '')) {
            $model->memberId = Yii::$app->member->id;
            if ($model->validate() && $model->changePassword()) {
                return [];
            } else {
                $errors = $model->errors;
                if (isset($errors['oldPassword'][0])) {
                    $errorMsg = $errors['oldPassword'][0];
                } elseif (isset($errors['newPasswordConfirm'][0])) {
                    $errorMsg = $errors['newPasswordConfirm'][0];
                } else {
                    $errorMsg = '密码不符';
                }
                $this->buildValidateError($errorMsg);
            }
        }
    }

    /**
     * 
     * @api {get} member/logout 4、会员注销登录11
     * @apiName 会员注销登录11
     * @apiGroup MemberGroup
     * @apiVersion 1.0.0
     * @apiDescription 注销会员登录 
     * 
     * @apiParam {string} token 会员TOKEN
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明
     * @apiSuccess {String} data   返回数据
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
    public function actionLogout() {
        Member::updateAll(['api_token'=>''], ['id'=>Yii::$app->member->id]);
        return [];
    }

    /**
     * 
     * @api {get} member/get-member-info 5、获取会员基本信息
     * @apiName 获取会员基本信息
     * @apiGroup MemberGroup
     * @apiVersion 1.0.0
     * @apiDescription 获取会员信息 
     * 
     * @apiParam {string} token 会员TOKEN
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明
     * @apiSuccess {String} data   返回数据
     * @apiSuccess {String} data.uno   会员编号
     * @apiSuccess {String} data.uname   会员手机号
     * @apiSuccess {String} data.nick_name   会员昵称
     * @apiSuccess {String} data.true_name   真实姓名
     * @apiSuccess {String} data.commissions   累计获得收益
     * @apiSuccess {String} data.balance   收益余额
     * @apiSuccess {String} data.integral_balance   公排积分
     * @apiSuccess {String} data.vouchers   代金券金额
     * @apiSuccess {String} data.report_center   是否可以跨级报单, 1可以 0不可以
     * @apiSuccess {String} data.buyBoxCount  购买宝箱数量
     * @apiSuccess {String} data.openBoxCount   已开奖宝箱数量
     * @apiSuccess {String} data.level  会员级别 0 注册会员 1 正式会员
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
    public function actionGetMemberInfo() {
        $memberInfo = Member::find()
                ->asArray()
                ->select('uno, uname, level, nick_name, true_name, commissions, balance, integral_balance, vouchers, report_center')
                ->where(['id' => Yii::$app->member->id])
                ->one();
        //获取已购买宝箱数量
        $memberInfo['buyBoxCount'] = OrdersFenghong::find()->where("member_id= ". Yii::$app->member->id ." and status < 8")->count();
        //获取已开奖宝箱数量
        $memberInfo['openBoxCount'] = OrdersFenghong::find()->where(['member_id'=>Yii::$app->member->id, 'status'=>1])->count();
        return $memberInfo;
    }

    /**
     * 
     * @api {post} member/chg-nick-name 6、更改会员的昵称
     * @apiName 更改会员的昵称
     * @apiGroup MemberGroup
     * @apiVersion 1.0.0
     * @apiDescription 更改会员昵称 
     * 
     * @apiParam {string} token 会员TOKEN
     * @apiParam {string} nickName 会员昵称
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明
     * @apiSuccess {String} data   返回数据
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
    public function actionChgNickName() {
        $nickName = Yii::$app->request->post('nickName');
        if (!empty($nickName) && strlen($nickName) < 30) {
            $sql = "update {{%member}} set nick_name = '{$nickName}' where id = " . Yii::$app->member->id;
            Yii::$app->db->createCommand($sql)->execute();
            return [];
        } else {
            $this->buildValidateError('昵称不可为空');
        }
    }
    
    /**
     * 
     * @api {post} member/get-info-by-mobile 6、根据手机号获取会员信息
     * @apiName 根据手机号获取会员信息
     * @apiGroup MemberGroup
     * @apiVersion 1.0.0
     * @apiDescription 更改会员昵称 
     * 
     * @apiParam {string} token 会员TOKEN
     * @apiParam {string} mobile 会员手机号
     * 
     * @apiSuccess {integer} code 结果码 200 为成功
     * @apiSuccess {String} message 消息说明
     * @apiSuccess {String} data   返回数据
     * @apiSuccess {String} data.id   会员ID号
     * @apiSuccess {String} data.uname  手机号
     * @apiSuccess {String} data.nick_name   昵称
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
    public function actionGetInfoByMobile(){
        if(empty(Yii::$app->request->post('mobile'))){
            $this->buildValidateError('手机号不可为空');
        }
        //获取收款人信息
        $sql = "select id,uname,nick_name from {{%member}} where uname = '" . Yii::$app->request->post('mobile') . "'";
        $targetUser = Yii::$app->db->createCommand($sql)->queryOne();
        if( ! $targetUser){
            $this->buildValidateError('不存在的收款人');
        }
        return $targetUser;
    }
}
