<?php

/** @var yii\web\View $this */

use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <?php  foreach($blogs as $one): ?>
            <div class="col-lg-3">
                <h2><?= $one->title ?></h2>
                <div>
                    <?= Html::img(str_replace('admin.','',Url::home(true)).'upload/images/noimage.svg')?>

                </div>

                <!-- <p><?= $one->text?></p> -->
                <?= Html::a('подробнее',['blog/one','url'=>$one->url],['class'=>'btn btn-success'])  ?>
            </div>
            <?php endforeach;?>
        </div>

    </div>
</div>
