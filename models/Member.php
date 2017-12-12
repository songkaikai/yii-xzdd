<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use app\components\Tool;
use app\components\Code;

/**
 * This is the model class for table "hzw_member".
 *
 * @property string $id
 * @property string $uno
 * @property string $uname
 * @property string $nick_name
 * @property string $password_hash
 * @property string $true_name
 * @property string $reg_time
 * @property integer $status
 * @property string $recommender
 * @property integer $level
 * @property string $route
 * @property string $commissions
 * @property string $balance
 * @property string $password_reset_token
 * @property string $avatar
 * @property string $openid
 * @property string $access_token
 * @property string $refresh_token
 * @property integer $sex
 * @property integer $imazamox
 */
class Member extends \yii\db\ActiveRecord implements IdentityInterface {

    public $recommend_name;

    const LEVEL_ONE = 0;
    const LEVEL_TWO = 1;
    const LEVEL_THREE = 2;
    const ONE_STAR = 3;
    const TWO_STAR = 4;
    const THREE_STAR = 5;
    const FOUR_STAR = 6;
    const MEMBER_ON = 1;
    const MEMBER_OFF = 0;
    const MAN = 0;
    const WOMAN = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%member}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['reg_time', 'status', 'recommender', 'level', 'sex'], 'integer'],
                [['commissions', 'balance', 'integral_balance', 'vouchers'], 'number'],
                [['uno', 'uname'], 'string', 'max' => 20],
                [['nick_name'], 'string', 'max' => 50],
                [['password_hash', 'auth_key', 'password_reset_token'], 'string', 'max' => 100],
                [['true_name'], 'string', 'max' => 30],
                [['route'], 'string', 'max' => 2000],
                [['avatar'], 'string', 'max' => 150],
                [['uno'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'uno' => '会员编号',
            'uname' => '用户名',
            'nick_name' => '昵称',
            'password_hash' => '密码',
            'auth_key' => 'Auth Key',
            'true_name' => '真实姓名',
            'reg_time' => '注册时间',
            'status' => '会员状态',
            'recommender' => '推荐人',
            'level' => '会员等级',
            'route' => '路由',
            'commissions' => '累计金额',
            'balance' => '账户余额',
            'password_reset_token' => '重置密码TOKEN',
            'avatar' => '头像',
            'openid' => 'Openid',
            'access_token' => 'Access Token',
            'refresh_token' => 'Refresh Token',
            'sex' => '性别',
            'integral_balance' => '积分余额',
            'recomm_count' => '推荐人数',
            'recommend_name' => '推荐人姓名',
            'integral_balance' => '公排积分',
            'vouchers' => '代金券金额',
            'team' => '三级团队',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::MEMBER_ON]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        // 如果token无效的话，
        if (!static::apiTokenIsValid($token)) {
//            throw new \yii\web\UnauthorizedHttpException("token is invalid.");
            throw new \yii\web\HttpException(200, 'TOKEN过期', 401);
        }

        return static::findOne(['api_token' => $token, 'status' => self::MEMBER_ON]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['uname' => $username, 'status' => self::MEMBER_ON]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::MEMBER_ON,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    /**
     * 生成 api_token
     */
    public function generateApiToken() {
        $this->api_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * 校验api_token是否有效
     */
    public static function apiTokenIsValid($token) {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.apiTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function beforeSave($insert) {
        if ($insert) {
            $this->reg_time = time();
            $this->status = self::MEMBER_ON;
            $this->level = self::LEVEL_ONE;
        }
        return true;
    }

    public function afterSave($insert, $changedAttributes) {
        if ($insert) {
//            $uno = '8' . str_pad($this->id, 8, '0', STR_PAD_LEFT);
            $uno = $this->buildMemberNo($this->id);
            //加路由
            if ($this->recommender) {
                $recommInfo = static::findOne($this->recommender);
                $depth = intval($recommInfo->depth) + 1;
                if ($recommInfo) {
                    static::updateAll(['route' => $recommInfo->route . $this->id . ',', 'uno' => $uno, 'depth' => $depth], ['id' => $this->id]);
                }
            } else {
                static::updateAll(['route' => ',' . $this->id . ',', 'uno' => $uno], ['id' => $this->id]);
            }
        }
    }

    /**
     * 生成会员卡号
     * 
     * @param type $memberId
     * @return type
     */
    private function buildMemberNo($memberId) {
        $code = new Code();
        $card_no = $code->encodeID($memberId, 5);
        $card_pre = '888';
        $card_vc = substr(md5($card_pre . $card_no), 0, 2);
        $card_vc = strtoupper($card_vc);
        return $card_pre . $card_no . $card_vc;
    }

    /**
     * 获取会员等级数据
     * 
     * @return type
     */
    public static function getLevelData() {
        return [
            self::LEVEL_ONE => '注册会员',
            self::LEVEL_TWO => '正式会员',
        ];
    }

    /**
     * 获取会员值
     * @param type $key
     * @return type
     */
    public static function getLevelValByKey($key) {
        return ArrayHelper::getValue(self::getLevelData(), $key, '');
    }

    public static function getLevelTree() {
        return array_keys(self::getLevelData());
    }

    /**
     * 获取会员状态数据
     * 
     * @return type
     */
    public static function getStatusData() {
        return [
            self::MEMBER_ON => '正常',
            self::MEMBER_OFF => '关闭',
        ];
    }

    /**
     * 获取状态值
     * @param type $key
     * @return type
     */
    public static function getStatusValByKey($key) {
        return ArrayHelper::getValue(self::getStatusData(), $key, '');
    }

    public static function getStatusTree() {
        return array_keys(self::getStatusData());
    }

    /**
     * 获取性别数据
     * 
     * @return type
     */
    public static function getSexTree() {
        return [
            self::MAN => '男',
            self::WOMAN => '女',
        ];
    }

    /**
     * 根据关键字获取性别值
     * 
     * @param type $key
     * @return type
     */
    public static function getSexValByKey($key) {
        return ArrayHelper::getValue(self::getSexTree(), $key);
    }

    /**
     * 获取性别关键词
     */
    public static function getSexKeys() {
        return array_keys(self::getSexTree());
    }

}
