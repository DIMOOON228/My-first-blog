<?php
/** @var yii\web\View $this */
use yii\bootstrap4\Html;
use yii\widgets\ListView;
$this->title= 'My blog';
$blog =$dataProvider->getModels();
?>

<div class="body-content">

<div class="row">
<?= 
    ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_one',
]);
?>
</div>

</div>

