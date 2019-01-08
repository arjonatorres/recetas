<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\helpers\UtilHelper;
use kartik\file\FileInput;
use kartik\dialog\Dialog;

/* @var $this yii\web\View */
/* @var $model app\models\Recetas */
/* @var $form yii\widgets\ActiveForm */

echo Dialog::widget();
$this->registerJsFile('@web/js/recetas.js?r=20190108', [
    'depends' => [\yii\web\JqueryAsset::className()],
]);

$this->registerCssFile('@web/css/recetas.css?r=20181226', [
        'depends' => [\yii\bootstrap\BootstrapAsset::className(), \yii\web\YiiAsset::className()],
]);
echo Dialog::widget([
    'dialogDefaults' => [
        Dialog::DIALOG_CONFIRM => [
            'type' => Dialog::TYPE_DANGER,
            'btnOKClass' => 'btn-danger',
        ],
    ]
]);
$categorias = UtilHelper::getDropDownList($categorias);
$dificultades = UtilHelper::getDropDownList($dificultades);
?>
    <div class="panel panel-success panel-principal">
        <div class="panel-heading panel-heading-principal">
            <h3 class="panel-title">Editar Receta</h3>
        </div>
        <div class="panel-body panel-body-gris">
            <div class="recetas-form">

                <?php $form = ActiveForm::begin(['id' => 'form']); ?>

                <?= $form->field($model, 'foto')->widget(FileInput::classname(), [
                    'options' => [
                        'accept' => 'image/*',
                    ],
                    'language' => 'es',
                    'pluginOptions' => [
                        'browseOnZoneClick' => true,
                        'initialPreview' => $model->rutaReceta . '?r=' . strtotime($model->updated_at),
                        'initialPreviewAsData' => true,
                        'dropZoneTitle' => 'Sube la foto de tu receta',
                        'dropZoneClickTitle' => '',
                        'showPreview' => true,
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'showBrowse' => false,
                    ]
                ]); ?>

                <?= $form->field($model, 'titulo')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Título que describa bien la receta...',
                ]) ?>

                <?= $form->field($model, 'historia')->textarea(
                    [
                        'rows' => 4,
                        'placeholder' => 'Cuenta la historia de esta receta...',
                        'style' => 'resize:none'
                    ]
                ) ?>

                <?= $form->field($model, 'ingredientes')->textarea(
                    [
                        'rows' => 4,
                        'placeholder' => '100 gr. harina...',
                        'style' => 'resize:none'
                    ]
                ) ?>
                <div class="row">
                    <div class="col-md-2">
                        <?= $form->field($model, 'comensales')->textInput(
                            [
                                'type' => 'number',
                                'min' => 1,
                                'value' => 2,
                            ]
                        ) ?>
                    </div>
                    <div class="col-md-4">
                        <?=$form->field($model, 'categoria_id')->dropDownList($categorias, ['prompt' => 'Seleccione Uno' ]); ?>
                    </div>
                    <div class="col-md-4">
                        <?=$form->field($model, 'dificultad_id')->dropDownList($dificultades, ['prompt' => 'Seleccione Uno' ]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $form->field($model, 'tiempo')->textInput([
                            'maxlength' => true,
                            'placeholder' => '30min',
                        ]) ?>
                    </div>
                </div>

                <h5><b>Pasos</b></h5>

                <?php
                foreach ($pasos as $i => $paso) {
                    $rutaPaso = $paso->getRutaPaso($model->id, $i);
                    if ($rutaPaso) {
                        $rutaPaso .= '?r=' . strtotime($model->updated_at);
                    }
                    ?>
                    <div class="entorno-paso-<?= ($i+1) ?>">
                        <?= $form->field($paso, 'texto[' . $i . ']', ['options' => ['class' => 'pasos']])->textarea(
                            [
                                'id' => 'pasos-texto' . ($i != 0 ? '-' . $i: ''),
                                'rows' => 4,
                                'name' => 'Pasos['. $i . ']',
                                'placeholder' => 'Describe cómo lo hiciste...',
                                'style' => 'resize:none',
                                'value' => $paso->texto
                            ]
                        )->label(
                            '<h3 style="display:inline"><span class="label label-default">' . ($i+1) . '</span></h3>', ['style' => 'margin-bottom: 20px']
                        ) ?>
                        <div class="row paso-foto-<?= ($i+1) ?>">
                            <div class="col-md-5">
                                <?= $form->field($paso, 'foto[' . $i . ']')->widget(FileInput::classname(), [
                                    'options' => [
                                        'id' => 'pasos-foto' . ($i != 0 ? '-' . $i: ''),
                                        'accept' => 'image/jpeg',
                                        'name' => 'Pasos[foto'. $i . ']',
                                    ],
                                    'language' => 'es',
                                    'pluginOptions' => [
                                        'browseOnZoneClick' => true,
                                        'initialPreview' => $paso->getRutaPaso($model->id, $i),
                                        'initialPreviewAsData' => true,
                                        'dropZoneTitle' => 'Sube la foto del paso',
                                        'dropZoneClickTitle' => '',
                                        'showPreview' => true,
                                        'showCaption' => false,
                                        'showRemove' => false,
                                        'showUpload' => false,
                                        'showBrowse' => false,
                                    ]
                                ])->label(false); ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>


                <?= Html::button('+ Añadir Paso', ['class' => 'btn btn-warning btn-xs btn-anadir-paso']) ?>
                <?= Html::button('- Borrar Paso', ['class' => 'btn btn-danger btn-xs btn-borrar-paso', 'style' => 'display:none']) ?>

                <?= $form->field($model, 'comentarios')->textarea(
                    [
                        'maxlength' => true,
                        'rows' => 4,
                        'placeholder' => 'Añade algún comentario o recomendación...',
                        'style' => 'resize:none'
                    ]
                ) ?>

                <div class="form-group">
                    <?= Html::submitButton('Guardar Receta', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

