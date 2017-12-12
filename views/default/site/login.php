
<?php
$scriptEnd = "
    $.post('http://xzl.zjwcwl.com/api/member/login', {username: '13588888888', password: '55555555'}, function(data){
    alert(data);
}, 'json');
    ";
$this->registerJs($scriptEnd, \yii\web\View::POS_END);
?>