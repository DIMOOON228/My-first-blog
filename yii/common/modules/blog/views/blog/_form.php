<?php

use common\modules\blog\models\Blog;
use common\modules\blog\models\Tag;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(Widget::className(), [
    'settings' => [
        'lang' => 'ru',
        'minHeight' => 200,
        'imageUpload' => Url::to(['/site/save-redactor-img','sub'=>'blog']),
        // 'forating'=>['p','blockquote','h2'],
        'plugins' => [
            'clips',
            'fullscreen',
        ],
        'clips' => [
            ['Lorem ipsum...', 'Lorem...'],
            ['red', '<span class="label-red">red</span>'],
            ['green', '<span class="label-green">green</span>'],
            ['blue', '<span class="label-blue">blue</span>'],
        ],
    ],
]); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_id')->dropDownList(Blog::getStatusList()) ?>

    <?= $form->field($model, 'sort')->textInput() ?>
    <?= $form->field($model, 'tags_array')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Tag::find()->all(),'id','name'),
    'value'=>$model->tags,
    'language' => 'ru',
    'options' => ['placeholder' => 'Выбрать tag.....', 'multiple' => true],
    'pluginOptions' => [
        'allowClear' => true,
        'tags' => true,
        'maximumInputLength' => 10
    ],
]); ?>
    <?=  $form->field($model, 'file')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
    'pluginOptions' => [
        'showCaption' => false,
        'showRemove' => false,
        'showUpload' => false,
        'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fas fa-camera"></i> ',
        'browseLabel' =>  'Select Photo'
    ],]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?= FileInput::widget([
        'name' => 'ImageManager[attachment]',
        'options'=>[
            'multiple'=>true,
            'class'=>'123'
        ],
        'pluginOptions' => [
                'deleteUrl'=>Url::toRoute(['/blog/delete-image']),
                'initialPreview'=>$model->imagesLinks,
                'initialPreviewAsData'=>true,
                'overwriteInitial'=>false,
                'initialPreviewConfig'=>$model->imagesLinksData,
                'uploadUrl' => Url::to(['/site/save-img']),
                'uploadExtraData' => [
                'ImageManager[class]' =>$model->formName(),
                'ImageManager[item_id]' => $model->id
            ],
            'maxFileCount' =>15
        ],
        'pluginEvents'=>[
                'filesorted'=>new \yii\web\JsExpression('function( event, params){
                    $.post("'.Url::toRoute(["/blog/blog/sort-image","id"=>$model->id]).'",{sort: params});
                }')
        ]
    ]);
    ?>
</div>
