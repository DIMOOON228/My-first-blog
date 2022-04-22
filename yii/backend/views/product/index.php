<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Sklad;
use common\models\Time;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">



    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            ['attribute'=>'sklad_id',
                'value'=>'skladName',
                'filter'=>Sklad::getList()
            ],
            [
                    'attribute'=>'sklad_name',
                    'value'=>'skladName'
            ],
            'title',
            'cost',
            [
                    'attribute'=>'data',
                    'format'=>'date',
                    'value'=>'date',
                    'filter'=>\kartik\datecontrol\DateControl::widget([
                            'model'=>$searchModel,
                            'attribute'=>'data'
])

],
            ['attribute'=>'type_id',
                'value'=>'typeName',
                'filter'=>\common\models\Product::getTypeList()
            ],
            //'text:ntext',

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, \common\models\Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
