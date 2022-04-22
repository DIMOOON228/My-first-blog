<?php

use common\models\Blog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\BlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index">



    <p>
        <?= Html::a('Create Blog', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'url:ntext',
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
                'format'=>'html', 
            ],
            'sort',
          
            [
                'attribute'=>'tags',
                'value'=>'tagsAsSting'
            ],
            'smallImage:image',
            'date_create:datetime',
            'date_update:datetime',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Blog $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
