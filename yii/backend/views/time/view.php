<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Time */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Times', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="time-view">

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
            'time',
            'data:date',
            'datatime:datetime',
        ],
    ]) ?>

</div>
