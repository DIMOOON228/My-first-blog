
<?php

use yii\bootstrap4\Html;

?>

<div class="col-lg-12">
    <h2><?= $model->title?><span class="badge">Автор статьи:<?= $model->author->username?>, его электронная почта <?= $model->author->email ?></span></h2>
    <!-- <?= $model->text ?> -->
    <?= Html::a('подробнее',['blog/one','url'=>$model->url],['class'=> "btn btn-success"]) ?>

</div>