<?php

use yii\helpers\Html;
use kartik\dialog\Dialog;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Recetas */

$this->registerCssFile('@web/css/recetas-view.css', [
    'depends' => [\yii\bootstrap\BootstrapAsset::className(), \yii\web\YiiAsset::className()],
]);
$this->title = $model->titulo . ' de ' . Yii::$app->user->identity->usuario;

$usuario = Yii::$app->user->identity;
$rutaAvatar = $usuario->rutaAvatar;
$numPasos = count($model->pasos);
$ruta = $model->rutaImagen;

echo Dialog::widget();
$js = <<<JS
    $('.borrar').on('click', function(e) {
        console.log('aqui');
        e.preventDefault();
        krajeeDialog.confirm("¿Estás seguro que quiere borrar esta receta?", function (result) {
            if (result) {
                location.href = $('.borrar').attr('href');
            }
        });
    });
JS;
$this->registerJs($js, View::POS_END);
?>
<div class="recetas-view">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-success panel-principal">
            <div class="panel-body panel-body-view">
                <?php if ($ruta) { ?>
                    <div class="col-md-12 margin30">
                        <?= Html::img($ruta,
                        ['class' => 'img-responsive', 'width' => '100%']
                        ) ?>
                    </div>
                <?php } ?>

                <div class="col-md-12 margin30">
                    <h1 class="titulo"><?= Html::encode($model->titulo) ?></h1>
                    <div class="fecha">
                        <?= Html::encode(Yii::$app->formatter->asDatetime($model->created_at, 'medium')) ?>
                    </div>
                    <h3 class="categoria"><span class="label label-warning"><?= $model->categoria->nombre ?></span></h3>
                </div>

                <div class="col-md-12 usuario <?= isset($model->historia)? '': 'margin30' ?>">
                    <?= Html::img($rutaAvatar,
                        ['class' => 'img-sm img-circle']
                    ) . ' ' . $usuario->usuario ?>
                </div>

                <?php if (isset($model->historia)) { ?>
                    <div class="col-md-12 margin30">
                        <h3 class="encabezados">Historia</h3>
                        <span><?= Html::encode($model->historia) ?></span>
                    </div>
                <?php } ?>

                <div class="col-md-12 margin10">
                    <h3 class="ingredientes">Ingredientes</h3>
                    <div class="comensales">
                        <h4>Para <?= $model->comensales ?> persona<?= $model->comensales != 1 ? 's' : ''?></h4>
                    </div>
                    <?= Html::encode($model->ingredientes) ?>
                </div>

                <div class="col-md-12">
                    <h3 class="encabezados">Pasos</h3>
                    <?php foreach ($model->pasos as $i => $paso) { ?>
                        <div class="<?= ($i+1) != $numPasos ? 'pasos ': 'margin10 ' ?>paso<?=($i+1)?>">
                            <h4><span class="label label-default"><?=($i+1)?></span></h4>
                            <span class="paso-texto"><?= $paso->texto ?></span>
                            <?php
                            $ruta = $paso->getRutaImagen($model->id, $i);
                            if ($ruta) { ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <?= Html::img($ruta,
                                            [
                                                'class' => 'img-responsive',
                                                'width' => '100%',
                                                'data-toggle' => 'modal',
                                                'data-target' => '.paso-' . ($i+1) . '-modal-lg',
                                            ]
                                        ) ?>
                                    </div>
                                </div>
                                <div class="modal fade paso-<?=($i+1)?>-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myLargeModalLabel">Paso <?=($i+1)?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <?= Html::img($ruta,
                                                    ['class' => 'img-responsive', 'width' => '100%']
                                                ) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php }?>
                </div>

                <?php if (isset($model->comentarios)) { ?>
                    <div class="col-md-12 margin20">
                        <h3 class="encabezados">Comentarios</h3>
                        <span><?= Html::encode($model->comentarios) ?></span>
                    </div>
                <?php } ?>

                <?php
                if ($model->usuario_id == Yii::$app->user->id) { ?>
                <div class="col-md-12 margin20">
                    <hr />
                    <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
                        'class' => 'borrar btn btn-danger'
                    ]) ?>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
