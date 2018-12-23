<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Recetas */
$this->title = 'Nueva Receta';
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="recetas-create">

            <?= $this->render('_form', [
                'model' => $model,
                'categorias' => $categorias,
                'dificultades' => $dificultades,
                'pasos' => $pasos,
            ]) ?>
        </div>
    </div>
</div>
