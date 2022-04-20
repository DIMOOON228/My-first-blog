<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
/* @var $this yii\web\View */
/* @var $model common\models\Time */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="time-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'time')->widget(DateControl::className(),[
        'type'=>DateControl::FORMAT_TIME])
?>

    <?= $form->field($model, 'data')->widget(DateControl::className(),[]) ?>

    <?= $form->field($model, 'datatime')->widget(DateControl::className(),[
        'type'=>DateControl::FORMAT_DATETIME
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
