<?php
namespace app\modules\backend\controllers;

use Yii;
use app\modules\backend\components\BackendController;
use app\modules\backend\models\PublicRowSearch;

/**
 * 公排池
 *
 * @author Administrator
 */
class PublicRowController extends BackendController {
    /**
     * A网
     */
    public function actionA(){
        $searchModel = new PublicRowSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('a', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
