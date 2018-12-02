<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\helpers\UtilHelper;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Recetas */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('@web/js/recetas.js', [
    'depends' => [\yii\web\JqueryAsset::className()],
]);

$this->registerCssFile('@web/css/recetas.css', [
        'depends' => [\yii\bootstrap\BootstrapAsset::className(), \yii\web\YiiAsset::className()],
]);
$categorias = UtilHelper::getDropDownList($categorias);
?>
    <div class="panel panel-success panel-principal">
        <div class="panel-heading panel-heading-principal">
            <h3 class="panel-title">Nueva Receta</h3>
        </div>
        <div class="panel-body panel-body-gris">
            <div class="recetas-form">

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'fotoPrincipal')->widget(FileInput::classname(), [
                    'options' => [
                        'accept' => 'image/*',
                    ],
                    'language' => 'es',
                    'pluginOptions' => [
                        'browseOnZoneClick' => true,
                        'dropZoneTitle' => 'Sube la foto de tu receta',
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

                <div class="col-md-6" style="padding-left: 0px">
                    <?= $form->field($model, 'comensales')->textInput(
                        [
                            'type' => 'number',
                            'min' => 1,
                            'value' => 2,
                        ]
                    ) ?>
                </div>
                <div class="col-md-6" style="padding-right: 0px">
                    <?=$form->field($model, 'categoria_id')->dropDownList($categorias, ['prompt' => 'Seleccione Uno' ]); ?>
                </div>

                <h5><b>Pasos</b></h5>

                <?= $form->field($pasos, 'texto')->textarea(
                    [
                        'rows' => 4,
                        'name' => 'Pasos[0]',
                        'placeholder' => 'Describe cómo lo hiciste...',
                        'style' => 'resize:none'
                    ]
                )->label(
                    '<h3 style="display:inline"><span class="label label-default">1</span></h3>', ['style' => 'margin-bottom: 20px']
                ) ?>

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

