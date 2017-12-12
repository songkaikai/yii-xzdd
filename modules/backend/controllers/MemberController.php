<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\Member;
use app\modules\backend\models\MemberSearch;
use app\modules\backend\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\backend\models\ChgMemberRecommForm;
use app\models\form\MemberRegForm;

/**
 * MemberController implements the CRUD actions for Member model.
 */
class MemberController extends BackendController {

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
     * Lists all Member models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * 会员注册
     */
    public function actionCreate(){
        $model = new MemberRegForm();
        if($model->load(Yii::$app->request->post())){
            $model->memberId = 0;
            if($model->validate() && $model->addMember()){
                return $this->showFlash('开户成功', 'success');
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    /**
     * 会员充值
     */
    public function actionRecharge(){
        $model = new \app\models\form\HtRechargeForm();
        if($model->load(Yii::$app->request->post())){
            if($model->validate() && $model->recharge()){
                return $this->showFlash('充值成功', 'success');
            }
        }
        return $this->render('recharge', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Member model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    
    /**
     * Deletes an existing Member model.
     * 
     * @param string $id
     * @return mixed
     */
    public function actionLock($id) {
        $memberModel = $this->findModel($id);
        $memberModel->status = Member::MEMBER_OFF;
        if ($memberModel->save()) {
            $this->showFlash('锁定成功', 'success');
        } else {
            $this->showFlash('锁定失败', 'error');
        }
        return $this->redirect('index');
    }
    
    public function actionUnlock($id) {
        $memberModel = $this->findModel($id);
        $memberModel->status = Member::MEMBER_ON;
        if ($memberModel->save()) {
            $this->showFlash('解锁成功', 'success');
        } else {
            $this->showFlash('解锁失败', 'error');
        }
        return $this->redirect('index');
    }
    
    /**
     * 更改会员推荐关系
     */
    public function actionChgRecomm($id){
        $model = new ChgMemberRecommForm();
        $post = Yii::$app->request->post();
        if ($post) {
            if ($model->load($post) && $model->validate() && $model->change()) {
                $this->addFlash('修改成功', 'success');
                return $this->redirect(['index']);
            }
        }
        $model->memberId = $id;
        $sql = "select a.id, a.uname, a.nick_name, b.nick_name as recomm_name from {{%member}} a left join {{%member}} b on a.recommender = b.id where a.id = {$id}";
        $memberInfo = Yii::$app->db->createCommand($sql)->queryOne();
        return $this->render('chg-recomm', [
                    'model' => $model,
            'memberInfo' => $memberInfo,
        ]);
    }
    
    /**
     * 密码重置
     */
    public function actionResetPass($id){
        $memberModel = $this->findModel($id);
        $memberModel->setPassword('111111');
        if ($memberModel->save()) {
            $this->addFlash('成功重置为111111', 'success');
        } else {
            $this->addFlash('重置失败', 'error');
        }
        return $this->redirect('index');
    }
    
    /**
     * 设置为领导人
     * @param type $id
     * @return type
     */
    public function actionSetTop($id){
        $sql = "update {{%member}} set istop = 1 where id = {$id}";
        Yii::$app->db->createCommand($sql)->execute();
        return $this->showFlash('设置成功', 'success', ['index']);
    }
    
    /**
     * 设置为领导人
     * @param type $id
     * @return type
     */
    public function actionSetPartner($id){
        $sql = "update {{%member}} set is_partner = 1 where id = {$id}";
        Yii::$app->db->createCommand($sql)->execute();
        return $this->showFlash('设置成功', 'success', ['index']);
    }

    /**
     * Finds the Member model based on its primary key value.
     * 
     * @param string $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
