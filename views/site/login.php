<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\helpers\UtilHelper;

$title = 'Iniciar sesión';
$this->registerJsFile('@web/js/login.js?r=20181227', [
    'depends' => [\yii\web\JqueryAsset::className()],
]);

?>
<div class="site-login">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default panel-principal">
                <div class="panel-heading panel-heading-principal">
                    <h3 class="panel-title"><?= Html::encode($title) ?></h3>
                </div>
                <div class="panel-body panel-body-gris">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'username', [
                        'inputTemplate' => UtilHelper::inputGlyphicon('user'),
                    ])->textInput(['autofocus' => true, 'tabindex' => 1]) ?>

                    <?= $form->field($model, 'password', [
                        'inputTemplate' => UtilHelper::inputGlyphicon('lock'),
                    ])->passwordInput(['tabindex' => 2])?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Iniciar sesión', ['class' => 'btn btn-block btn-success', 'name' => 'login-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>