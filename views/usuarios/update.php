<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use app\helpers\UtilHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Modificar un usuario';
?>
<div class="usuarios-update">

    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-success panel-principal">
            <div class="panel-heading panel-heading-principal">
                <h3 class="panel-title">Configuración de la cuenta</h3>
            </div>
            <div class="panel-body panel-body-gris">
                <div class="usuarios-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'foto')->widget(FileInput::classname(), [
                        'options' => [
                            'accept' => 'image/*',
                        ],
                        'language' => 'es',
                        'pluginOptions' => [
                            'browseOnZoneClick' => true,
                            'initialPreview' => $model->rutaImagen,
                            'initialPreviewAsData' => true,
                            'dropZoneTitle' => 'Sube foto de perfil',
                            'showPreview' => true,
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                            'showBrowse' => false,
                        ]
                    ]); ?>

                    <?= $form->field($model, 'password', [
                        'inputTemplate' => UtilHelper::inputGlyphicon('lock'),
                    ])->passwordInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'password_repeat', [
                        'inputTemplate' => UtilHelper::inputGlyphicon('lock'),
                    ])->passwordInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'email', [
                        'inputTemplate' => UtilHelper::inputGlyphicon('envelope'),
                    ])->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Guardar', ['class' => 'btn btn-block btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>