<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2016/12/9
 * Time: 10:17
 * Email:liyongsheng@meicai.cn
 */

namespace app\models;

use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use Yii;

class Products extends Content
{
    static $currentType = Parent::TYPE_PRODUCTS;

    public $imageFile;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'type', 'status','category_id', 'market_price', 'member_price', 'max_point', 'stock'], 'required'],
            [['imageFile'], 'file', 'extensions' => 'gif, jpg, png, jpeg','mimeTypes' => 'image/jpeg, image/png',],
            [['type', 'status', 'admin_user_id', 'category_id','created_at', 'updated_at', 'is_member', 'is_recommend', 'max_point', 'stock', 'day_max_sell', 'day_sell'], 'integer'],
            [['market_price', 'member_price'], 'number'],
            [['title', 'image', 'description'], 'string', 'max' => 255],
        ];
    }
    /**
     * @return \app\models\ContentDetail
     */
    public function detail()
    {
        if ($this->isNewRecord) {
            return new ContentDetail(['scenario' => ContentDetail::SCENARIO_PRODUCTS]);
        } else {
            $model = $this->hasOne(ContentDetail::class, ['content_id' => 'id'])->one();
            if($model){
                $model->scenario = ContentDetail::SCENARIO_PRODUCTS;
                return $model;
            }else{
                $model = new ContentDetail(['scenario' => ContentDetail::SCENARIO_PRODUCTS]);
                return $model;
            }
            
        }
    }

    public function beforeSave($runValidation = true)
    {
        if ($runValidation && !$this->validate()) {
            Yii::info('Model not updated due to validation error.', __METHOD__);
            return false;
        }
        $file = $this->uploadFile();
        if($file){
            $this->image = $file;
        }
        return true;
    }

    public function uploadFile()
    {
        /** @var UploadedFile imageFile */
        $this->imageFile = current(UploadedFile::getInstances($this, 'imageFile'));
        if(empty($this->imageFile)){
            return '';
        }
        try {
            $fileName = $this->createUploadFilePath() . uniqid('img_') . '.' . $this->imageFile->extension;
        } catch (\Exception $e) {
            $this->addError('imageFile', $e->getMessage());
            return false;
        }
        if($this->imageFile->saveAs(\Yii::getAlias('@webroot').$fileName)){
            return $fileName;
        }
        return '';
    }

    public function createUploadFilePath()
    {
        $rootPath = \Yii::getAlias('@webroot');
        $path = '/uploads/products-img/';
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
            'market_price'=>'市场价',
            'member_price'=>'会员价',
            'image' => '图片',
            'imageFile' => '图片',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'status' => '状态',
            'statusText' => '状态',
            'is_member' => '是否报单产品',
            'is_recommend' => '是否推荐',
            'created_at'=>'创建时间',
            'max_point' => '最多使用积分',
            'stock' => '库存',
            'day_max_sell' => '每日库存',
            'day_sell' => '今日已销售',
        ];
    }
    
    public static function getTree($is_member = 1){
        $tree = [];
        $products = static::find()->asArray()->select('id, title')->where(['is_member'=>$is_member, 'status'=>self::STATUS_ENABLE])->all();
        if($products){
            foreach($products as $val){
                $tree[$val['id']] = $val['title'];
            }
        }
        return $tree;
    }
}