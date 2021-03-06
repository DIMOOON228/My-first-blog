<?php

use common\models\Blog;
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="blog-view">

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
    <?php
    $fotorama = \metalguardian\fotorama\Fotorama::begin(
        [
            'options' => [
                'loop' => true,
                'hash' => true,
                'ratio' => 800/600,
            ],
            'spinner' => [
                'lines' => 20,
            ],
            'tagName' => 'span',
            'useHtmlData' => false,
            'htmlOptions' => [
                'class' => 'custom-class',
                'id' => 'custom-id',
            ],
        ]
    );

    foreach($model->images as $one){
       echo  Html::img($one->imageUrl,['alt'=>$one->alt]);
    }
     \metalguardian\fotorama\Fotorama::end(); ?>

</div>

