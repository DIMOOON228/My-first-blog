<?php

use common\models\Blog;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="blog-view">

    <h1><?= Html::encode($this->title) ?></h1>

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'text:html',
            'url:url',
            [
                'attribute'=>'status_id',
                'filter'=>Blog::getStatusList(),
                'value'=>function($model){
                    if($model->status_id==1){
                        $status_id='<span class="text-success">On<span>';
                    }elseif($model->status_id==2){
                        $status_id='<span class="text-warning">In processing<span>';
                    }else{
                     $status_id='<span class="text-danger">Off<span>';
                    };
                    return $status_id;
                 },
                'format'=>'html'
            ],
            'author.username',
            'author.email',
            'date_create:datetime',
            'date_update:datetime',
            'tagsAsSting',
            'sort',
            'smallImage:image'
        ],
    ]) ?>

</div>
