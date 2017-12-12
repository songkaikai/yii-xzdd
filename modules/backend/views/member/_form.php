<?php

use yii\helpers\Html;
use yii\dwz\DwzActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Member */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript">
    /*<![CDATA[*/
    function member_form(form) {
<?php  echo $_REQUEST['target'] == 'navTab' ? 'navTab' : '$.pdialog'; ?>.reload(form.action, $(form).serializeArray());
        return false;
    }
    /*]]>*/
</script>

    <?php $form = DwzActiveForm::begin(['winType' => 'dialog']); ?>
<div class="form pageFormContent nowrap" layoutH="85">
    <?php  echo $form->errorSummary($model); ?>
    <?= $form->field($model, 'uno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nick_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'true_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reg_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'recommender')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'level')->textInput() ?>

    <?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'commissions')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'balance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'avatar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'openid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'access_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'refresh_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->textInput(['maxlength' => true]) ?>

</div>
<div class="formBar">
    <ul>
        <li>
            <div class="buttonActive">
                <div class="buttonContent">
                    <button type="submit"><?php echo $model->isNewRecord ? '创建' : '保存'; ?></button>
                </div>
            </div>
        </li>
        <li>
            <div class="button">
                <div class="buttonContent">
                    <button onclick="<?php  echo $_REQUEST['target'] == 'navTab' ? 'navTab.closeCurrentTab()' : '$.pdialog.closeCurrent()'; ?>" type="Button">取消</button>
                </div>
            </div>
        </li>
    </ul>
</div>
<?php  DwzActiveForm::end(); ?>

