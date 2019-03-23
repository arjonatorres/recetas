<?php

/* @var $this yii\web\View */

use yii\widgets\ListView;
use yii\data\ActiveDataProvider;

$this->registerCssFile('@web/css/index.css?r=20190323', [
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
                'layout' => "{items}{pager}",
                'options' => [
                    'class' => 'row cuadriculas',
                    'id' => false
                ],
                'itemOptions' => [
                    'tag' => false
                ],
                'viewParams' => ['totalCount' => $dataProvider->getTotalCount()]
            ]);
            ?>
        </div>
    </div>
</div>
