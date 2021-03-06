<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\Usuarios */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\helpers\UtilHelper;

$title = 'Registro';
$this->registerJsFile('@web/js/usuarios.js?r=20181228', [
    'depends' => [\yii\web\JqueryAsset::className()],
]);
//$this->params['breadcrumbs'][] = $title;
?>
<div class="site-signup">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-success panel-principal">
                <div class="panel-heading panel-heading-principal">
                    <h3 class="panel-title"><?= Html::encode($title) ?></h3>
                </div>
                <div class="panel-body panel-body-gris">
                    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                    <?= $form->field($model, 'usuario', [
                        'inputTemplate' => UtilHelper::inputGlyphicon('user'),
//                        'enableAjaxValidation' => true,
                    ])->textInput(['autofocus' => true]) ?>

                    <?= $form->field( $model, 'email', [
                        'inputTemplate' => UtilHelper::inputGlyphicon('envelope'),
//                        'enableAjaxValidation' => true,
                    ])->textInput() ?>

                    <?= $form->field($model, 'password', [
                        'inputTemplate' => UtilHelper::inputGlyphicon('lock'),
                    ])->passwordInput() ?>

                    <?= $form->field($model, 'password_repeat', [
                        'inputTemplate' => UtilHelper::inputGlyphicon('lock'),
                    ])->passwordInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Registro', ['class' => 'btn btn-block btn-success', 'name' => 'signup-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>