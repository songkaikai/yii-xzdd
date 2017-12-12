<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%daoshituan}}".
 *
 * @property string $id
 * @property string $nick_name
 * @property string $wechat_no
 * @property string $wechat_code
 * @property string $avatar
 * @property string $team_name
 * @property integer $sorts
 */
class Daoshituan extends \yii\db\ActiveRecord {

    public $avatarFile;
    public $codeFile;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%daoshituan}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nick_name', 'wechat_no'], 'required'],
            [['sorts'], 'integer'],
            [['nick_name', 'team_name'], 'string', 'max' => 50],
            [['wechat_no'], 'string', 'max' => 30],
            [['wechat_code', 'avatar'], 'string', 'max' => 100],
            [['avatarFile', 'codeFile'], 'file', 'extensions' => 'gif, jpg, png, jpeg', 'mimeTypes' => 'image/jpeg, image/png',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'nick_name' => '昵称',
            'wechat_no' => '微信号',
            'wechat_code' => '微信二维码',
            'avatar' => '头像',
            'team_name' => '团队名称',
            'sorts' => '排序号',
            'codeFile' => '微信二维码(280*280)',
            'avatarFile' => '头像(80*80)',
        ];
    }

    public function beforeSave($runValidation = true) {
        $file = $this->uploadFile();
        $codefile = $this->uploadCodeFile();
        if ($file) {
            $this->avatar = $file;
            $this->wechat_code = $codefile;
        }
        return true;
    }

    public function uploadFile() {
        /** @var UploadedFile imageFile */
        $this->avatarFile = current(UploadedFile::getInstances($this, 'avatarFile'));
        if (empty($this->avatarFile)) {
            return '';
        }
        try {
            $fileName = $this->createUploadFilePath() . uniqid('avatar_') . '.' . $this->avatarFile->extension;
        } catch (\Exception $e) {
            $this->addError('avatarFile', $e->getMessage());
            return false;
        }
        if ($this->avatarFile->saveAs(\Yii::getAlias('@webroot') . $fileName)) {
            return $fileName;
        }
        return '';
    }
    
    public function uploadCodeFile() {
        /** @var UploadedFile imageFile */
        $this->codeFile = current(UploadedFile::getInstances($this, 'codeFile'));
        if (empty($this->codeFile)) {
            return '';
        }
        try {
            $fileName = $this->createUploadFilePath() . uniqid('code_') . '.' . $this->codeFile->extension;
        } catch (\Exception $e) {
            $this->addError('codeFile', $e->getMessage());
            return false;
        }
        if ($this->codeFile->saveAs(\Yii::getAlias('@webroot') . $fileName)) {
            return $fileName;
        }
        return '';
    }

    public function createUploadFilePath() {
        $rootPath = \Yii::getAlias('@webroot');
        $path = '/uploads/daoshi-img/';
        if (!is_dir($rootPath . $path)) {
            FileHelper::createDirectory($rootPath . $path);
        }
        return $path;
    }

}
