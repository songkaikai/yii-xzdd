<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
/* @var $this \yii\web\View */
?>
<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                if ($this->title !== null) {
                    echo \yii\helpers\Html::encode($this->title);
                } else {
                    echo \yii\helpers\Inflector::camel2words(
                        \yii\helpers\Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                } ?>
            </h1>
        <?php } ?>

        <?= Breadcrumbs::widget([
                'homeLink'=>['label'=>'首页', 'url'=>['/backend/']],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?php if($this->context->module->id=='backend'):?>
            <?= $content ?>
        <?php else:?>
            <?php $this->beginContent('@app/modules/backend/views/layouts/sub-modules.php');?>
                <?= $content ?>
            <?php $this->endContent()?>
        <?php endif;?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2016-2017 All rights
    reserved.
</footer>