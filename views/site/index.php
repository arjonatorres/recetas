<?php

/* @var $this yii\web\View */

use yii\widgets\ListView;
use yii\data\ActiveDataProvider;

$this->registerCssFile('@web/css/index.css', [
    'depends' => [\yii\bootstrap\BootstrapAsset::className(), \yii\web\YiiAsset::className()],
]);

$this->title = 'Recetas';
?>
<div class="row">
    <div class="col-md-12">
        <div class="recetas-index">
            <?php
            echo ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_list',
                'layout' => "<div class=\"row cuadriculas\">{items}</div>{pager}",
            ]);
            ?>
        </div>
    </div>
</div>
