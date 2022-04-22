<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Sklad */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Sklads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sklad-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <h1><?= Yii::$app->user->id  ?>(<?= Yii::$app->user->identity->username ?>)</h1>
    <?php  if(Yii::$app->user->can('updatePost',['author_id'=>$model->user_id])): ?>
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php  endif; ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'address',
        ],
    ]) ?>

</div>
