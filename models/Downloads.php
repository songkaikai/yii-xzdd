<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2016/12/9
 * Time: 10:17
 * Email:liyongsheng@meicai.cn
 */

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\Expression;
use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class Downloads extends Content
{
    static $currentType = Parent::TYPE_DOWNLOADS;

    /**
     * @return \app\models\ContentDetail
     */
    public function detail()
    {
        if ($this->isNewRecord) {
            return new ContentDetail(['scenario' => ContentDetail::SCENARIO_DOWNLOADS]);
        } else {
            $model = $this->hasOne(ContentDetail::class, ['content_id' => 'id'])->one();
            $model->scenario = ContentDetail::SCENARIO_DOWNLOADS;
            return $model;
        }
    }
    /** @var  UploadedFile */
    public $file;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'type', 'status','category_id'], 'required'],
            [['file'], 'file', 'extensions' => 'zip,rar',],
            [['type', 'status', 'admin_user_id', 'category_id','created_at', 'updated_at'], 'integer'],
            [['title', 'image', 'description'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($runValidation = true)
    {
        if ($runValidation && !$this->validate()) {
            Yii::info('Model not updated due to validation error.', __METHOD__);
            return false;
        }
        try {
            $file = $this->uploadFile();
        } catch (\Exception $e) {
            $this->addError('file', $e->getMessage());
            return false;
        }
        if($file){
            $this->detail->file_url = $file;
        }
        if(empty($this->detail->file_url)){
            $this->addError('file', '文件能为空');
            return false;
        }
        return true;
    }

    public function uploadFile()
    {
        /** @var UploadedFile file */
        $this->file = current(UploadedFile::getInstances($this, 'file'));
        if(empty($this->file)){
            return '';
        }
        $fileName = $this->createUploadFilePath().uniqid('yiicms').'.'. $this->file->extension;

        if($this->file->saveAs(\Yii::getAlias('@webroot').$fileName)){
            return $fileName;
        }
        return '';
    }

    public function createUploadFilePath()
    {
        $rootPath = \Yii::getAlias('@webroot');
        $path = '/uploads/downloads/';
        if(!is_dir($rootPath.$path)){
            FileHelper::createDirectory($rootPath.$path);
        }
        return $path;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'typeText'=>'类型',
            'category_id'=>'分类',
            'file_url' => '文件路径',
            'file' => '文件',
            'description' => '描述',
            'status' => '状态',
            'statusText' => '状态',
            'created_at'=>'创建时间'
        ];
    }
}