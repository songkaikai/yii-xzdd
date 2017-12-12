<?php

namespace app\modules\backend\controllers;

use yii\filters\VerbFilter;
use app\modules\backend\components\BackendController;
use app\modules\backend\models\DaoshiSearch;
use Yii;
use app\models\Daoshituan;
use yii\web\NotFoundHttpException;
use app\modules\backend\actions\ContentDeleteAllAction;
use app\modules\backend\actions\ContentCheckAction;

class DaoshiController extends BackendController {

    /**
     * @inheritdoc
     */
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
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new DaoshiSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->module->params['pageSize']);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Daoshituan();
        $post = Yii::$app->request->post();
        if ($post) {
            if ($model->load($post) && $model->save()) {
                return $this->showFlash('添加成功', 'success');
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->showFlash('修改成功', 'success');
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Content model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        if ($this->findModel($id)->delete()) {
            return $this->showFlash('删除成功', 'success', ['index']);
        }
        return $this->showFlash('删除失败');
    }

    /**
     * Finds the Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Daoshituan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
