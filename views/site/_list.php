<?php
use yii\helpers\Html;
use yii\helpers\Url;

$link = Url::to(['/recetas/view', 'id' => $model->id]);
?>
<div class="col-md-3">
    <a href="<?=$link ?>" style="text-decoration: none;">
        <div class="panel panel-principal">
            <div class="panel-body panel-body-gris">
                <div class="recetas-form">

                    <?= Html::img($model->rutaImagen,
                        ['class' => 'img-responsive', 'width' => '100%']
                    ) ?>

                </div>
            </div>
            <div class="panel-heading panel-heading-principal">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title"><?= Html::encode($model->titulo) ?></h3>
                        <div class="col-md-2 col-xs-2 iconos">
                            <div class="icono-imagen">
                                <?= Html::img('@web/images/iconos/reloj.png',
                                    ['class' => 'img-responsive', 'width' => '60%']
                                ) ?>
                            </div>
                            <p class="text-center"><?= $model->tiempo ?></p>
                        </div>
                        <div class="col-md-2 col-xs-2 iconos">
                            <div class="icono-imagen">
                                <?= Html::img('@web/images/iconos/gente.png',
                                    ['class' => 'img-responsive', 'width' => '60%']
                                ) ?>
                            </div>
                            <p class="text-center"><?= $model->comensales ?></p>
                        </div>
                        <div class="col-md-2 col-xs-2 iconos">
                            <div class="icono-imagen">
                                <?= Html::img('@web/images/iconos/dificultad.png',
                                    ['class' => 'img-responsive', 'width' => '60%']
                                ) ?>
                            </div>
                            <p class="text-center"><?= $model->dificultad->nombre ?></p>
                        </div>
                        <div class="col-md-2 col-xs-2 col-md-offset-4 col-xs-offset-4 iconos">
                            <div class="icono-imagen">
                                <?= Html::img($model->usuario->rutaAvatar,
                                    [
                                        'class' => 'img-responsive img-circle',
                                        'width' => '60%',
                                        'title' => $model->usuario->usuario,
                                    ]
                                ) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
