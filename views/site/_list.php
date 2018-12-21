<?php
use yii\helpers\Html;
use yii\helpers\Url;

$link = Url::to(['/recetas/view', 'id' => $model->id]);
?>
<div class="col-md-4">
    <a href="<?=$link ?>">
        <div class="panel panel-success panel-principal">
            <div class="panel-body panel-body-gris">
                <div class="recetas-form">

                    <?= Html::img($model->rutaImagen,
                        ['class' => 'img-responsive', 'width' => '100%']
                    ) ?>

                </div>
            </div>
            <div class="panel-heading panel-heading-principal">
                <h3 class="panel-title"><?= Html::encode($model->titulo) ?></h3>
            </div>
        </div>
    </a>
</div>
