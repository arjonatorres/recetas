<?php

use yii\helpers\Html;
use kartik\dialog\Dialog;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Recetas */

$this->registerCssFile('@web/css/recetas-view.css?r=20181228', [
    'depends' => [\yii\bootstrap\BootstrapAsset::className(), \yii\web\YiiAsset::className()],
]);
$this->title = $model->titulo . ' de ' . Yii::$app->user->identity->usuario;

$usuario = Yii::$app->user->identity;
$rutaAvatar = $usuario->rutaAvatar;
$numPasos = count($model->pasos);
$ruta = $model->rutaImagen;

echo Dialog::widget([
        'dialogDefaults' => [
            Dialog::DIALOG_CONFIRM => [
                'type' => Dialog::TYPE_DANGER,
//                'title' => Yii::t('kvdialog', 'Confirmation'),
                'btnOKClass' => 'btn-danger',
//                'btnOKLabel' => Dialog::ICON_OK . ' ' . Yii::t('kvdialog', 'Ok'),
//                'btnCancelLabel' => Dialog::ICON_CANCEL . ' ' . Yii::t('kvdialog', 'Cancel')
            ],
        ]
]);
$js = <<<JS
    $('.borrar').on('click', function(e) {
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
        <div class="panel panel-default panel-principal">
            <div class="panel-body panel-body-view">
                <?php if ($ruta) { ?>
                    <div class="col-md-12 margin30">
                        <?= Html::img($ruta . '?r=' . strtotime($model->updated_at),
                        ['class' => 'img-responsive', 'width' => '100%']
                        ) ?>
                    </div>
                <?php } ?>

                <div class="row">
                    <div class="col-md-4 col-xs-8">
                        <div class="col-md-2 col-xs-3 iconos">
                            <div class="icono-imagen">
                                <?= Html::img('@web/images/iconos/reloj.png',
                                    ['class' => 'img-responsive', 'width' => '50%']
                                ) ?>
                            </div>
                            <p class="text-center"><?= $model->tiempo ?></p>
                        </div>
                        <div class="col-md-2 col-xs-3 iconos">
                            <div class="icono-imagen">
                                <?= Html::img('@web/images/iconos/gente.png',
                                    ['class' => 'img-responsive', 'width' => '50%']
                                ) ?>
                            </div>
                            <p class="text-center"><?= $model->comensales ?></p>
                        </div>
                        <div class="col-md-2 col-xs-3 iconos">
                            <div class="icono-imagen">
                                <?= Html::img('@web/images/iconos/dificultad.png',
                                    ['class' => 'img-responsive', 'width' => '50%']
                                ) ?>
                            </div>
                            <p class="text-center"><?= $model->dificultad->nombre ?></p>
                        </div>

                    </div>
                    <div class="col-md-1 col-md-offset-7 col-xs-3 col-xs-offset-1">
                        <div class="icono-imagen">
                            <?= Html::img($model->usuario->getRutaAvatar($model->usuario_id) . '?r=' . strtotime($model->usuario->updated_at),
                                [
                                    'class' => 'img-responsive img-circle',
                                    'width' => '60%',
                                    'title' => $model->usuario->usuario,
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="titulo"><?= Html::encode($model->titulo) ?></h2>
                    </div>
                    <div class="col-md-12 fecha">
                        <span class="gris">Publicado el </span> <?= Html::encode(Yii::$app->formatter->asDate($model->created_at, 'medium')) ?><span class="gris"> por </span><?= $model->usuario->usuario ?>
                    </div>
                    <div class="col-md-12">
                        <h3 class="categoria"><span class="label label-warning"><?= $model->categoria->nombre ?></span></h3>
                    </div>
                </div>

                <div class="col-md-12">
                    <?php
                    foreach ($model->etiqueta as $etiqueta) { ?>
                        <span class="label label-default"><?= $etiqueta ?></span>
                    <?php }
                    ?>
                </div>


                <?php if (isset($model->historia)) { ?>
                    <div class="col-md-12">
                        <h3 class="encabezados">Historia</h3>
                        <span><?= Html::encode($model->historia) ?></span>
                    </div>
                <?php } ?>

                <div class="col-md-12 margin10 cont-ingred">
                    <h3 class="ingredientes">Ingredientes</h3>
                    <div class="comensales">
                        <h4>Para <?= $model->comensales ?> persona<?= $model->comensales != 1 ? 's' : ''?></h4>
                    </div>
                    <?= nl2br(Html::encode($model->ingredientes)) ?>
                </div>

                <div class="col-md-12">
                    <h3 class="encabezados">Pasos</h3>
                    <?php foreach ($model->pasos as $i => $paso) { ?>
                        <div class="<?= ($i+1) != $numPasos ? 'pasos ': 'margin10 ' ?>paso<?=($i+1)?>">
                            <h4><span class="label label-default"><?=($i+1)?></span></h4>
                            <span class="paso-texto"><?= nl2br(Html::encode($paso->texto)) ?></span>
                            <?php
                            $ruta = $paso->getRutaImagen($model->id, $i);
                            if ($ruta) {
                                $ruta .= '?r=' . strtotime($model->updated_at); ?>
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
                        <span><?= nl2br(Html::encode($model->comentarios)) ?></span>
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
