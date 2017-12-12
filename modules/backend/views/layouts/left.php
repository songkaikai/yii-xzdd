<?php
use yii\helpers\Json;
use mdm\admin\components\MenuHelper;

$menuItems = MenuHelper::getAssignedMenu(Yii::$app->user->id,null,function($menu){
    $data = empty($menu['data'])?[]:json_decode($menu['data'], true);
    $icon ='';
    if(isset($data['icon'])){
        $icon = $data['icon'];
        unset($data['icon']);
    }
    return [
        'icon' => $icon,
        'label' => $menu['name'],
        'url' => [$menu['route']],
        'options' => $data,
        'items' => $menu['children']
    ];
});

$opts = Json::htmlEncode([
    'menus' => $menuItems,
]);
$this->registerJs("var _menu_opts = $opts;");
$this->registerJs($this->render('_menu_script.js'));
?>
<aside class="main-sidebar">

    <section class="sidebar">
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" id="menu-keyword" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                <button type='button' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => $menuItems
            ]
        ) ?>

    </section>

</aside>
