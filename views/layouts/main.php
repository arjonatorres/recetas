<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\helpers\UtilHelper;
use yii\helpers\Url;
use app\models\RecetasSearch;
use yii\bootstrap\ActiveForm;

// Advanced search
use kartik\select2\Select2;
use yii\web\JsExpression;
use app\models\Categorias;
use app\models\Dificultades;
// end

$this->registerJsFile('@web/js/site.js?r=20190323', [
    'depends' => [\yii\web\JqueryAsset::className()],
]);

$url = Url::to(['site/index']);
$search = filter_input(INPUT_POST, 'RecetasSearch', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$avanzada = filter_input(INPUT_POST, 'avanzada');

$searchModel = new RecetasSearch();
$searchModel->load($_POST);
$searchModel->etiqueta =  empty($search['etiqueta'])? '': $search['etiqueta'];
$searchModel->usuario_id = empty($search['usuario_id'])? '': $search['usuario_id'];
$nombreUsuario = isset($searchModel->usuario)?$searchModel->usuario->usuario: '';
$mostrarAvanzada = (isset($search) && isset($avanzada));
// Advanced search
$urlEtiquetas = \yii\helpers\Url::to(['/etiquetas/list']);
$urlUsuarios = \yii\helpers\Url::to(['/usuarios/list']);
$categorias = Categorias::find()->all();
$categorias = UtilHelper::getDropDownList($categorias);
$dificultades = Dificultades::find()->all();
$dificultades = UtilHelper::getDropDownList($dificultades);
//end

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= Yii::$app->request->baseUrl ?>/favicon.png?r=10012019" type="image/png">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<div class="loading" style="display: none"></div>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-default my-navbar navbar-fixed-top',
        ],
    ]);

    $menuItems = [];
    if (Yii::$app->user->isGuest) {
        $menuItems = [
            [
                'label' => 'Login',
                'url' => ['/site/login'],
                'options' => [
                    'class' => 'text-center',
                ],
            ],
            [
                'label' => 'Registrarse',
                'url' => ['usuarios/create'],
                'options' => [
                    'class' => 'text-center',
                ],
            ],
        ];
        $menuCasa = [
//            'label' => '',
//            UtilHelper::menuItem('Blog', 'book', 'posts/index'),
        ];
    } else {
        $menuCasa = [
            [
                'label' =>
                    Html::input('text', 'RecetasSearch[titulo]', isset($_POST['avanzada'])? '': $search['titulo'],
                        [
                            'placeholder' => 'Buscar...',
                            'class' => 'search-field',
                        ]) . '<button type="submit" class="glyphicon glyphicon-search">'
                    . '</button>',
                'encode' => false,
                'url' => false,
            ],
                '<li>'
                . Html::a('Búsqueda avanzada',
                    false,
                    [
                        'class' => 'busqueda-avanzada',
                            'style' => 'padding-top: 8px!important; margin-top: 6px;',
                        'data-toggle' => 'modal',
                        'data-target' => '#adv-search',
                    ])
                . '</li>',
        ];
        $usuario = Yii::$app->user->identity;
        $ruta = $usuario->rutaAvatar . '?r=' . strtotime($usuario->updated_at);

        $menuItems[] =
            '<li class="menu-item-derecha">'
            . Html::a('Nueva Receta ' . UtilHelper::glyphicon('plus', ['class' => 'btn btn-success', 'style' => 'border: 0px;']),
            ['recetas/create'],
            ['class' => 'text-success', 'style' => 'padding: 9px;'])
            . '</li>';

        $menuItems[] = [
            'label' => Html::img($ruta,
                ['class' => 'img-sm img-circle']
            ),
            'encode' => false,
            'items' => [
                [
                    'label' => '<div style="display:flex">'
                        . '<div>'
                        . Html::img($ruta,
                            ['class' => 'img-md img-circle'])
                        . '</div>'
                        . '<div style="margin-top: 8px;">'
                        . '<strong>' . Html::encode($usuario->usuario)
                        . '</strong>'
                        . '<br>'
                        . '<p>' . Html::encode($usuario->email) . '</p>'
                        . Html::a(UtilHelper::glyphicon('cog') . ' Mi cuenta',
                            ['usuarios/update'],
                            ['class' => 'btn btn-sm btn-success'])
                        . '</div>'
                        . '</div>',
                    'encode' => false,
                ],
                '<li class="divider"></li>',
                Html::beginForm(['/site/logout'], 'post')
                . '<div class="col-md-offset-2 col-md-8">'
                . Html::submitButton(
                    UtilHelper::glyphicon('log-out') . ' Cerrar sesión',
                    ['class' => 'btn btn-sm btn-danger btn-block']
                )
                . Html::endForm()
                . '</div>',
            ],
            'dropDownOptions' => [
                'id' => 'menu-usuario',
            ],
            'options' => [
                'class' => 'user-dropdown text-center',
            ],
        ];
    }
    $form = ActiveForm::begin([
        'action' => ['site/index'],
        'method' => 'post',
        'id' => 'titulo-form'
    ]);
    echo Nav::widget([
        'id' => 'menu-recetas',
        'options' => ['class' => 'navbar-nav navbar-left menu-item'],
        'items' => $menuCasa,
    ]);
    ActiveForm::end();

    echo Nav::widget([
        'id' => 'menu-user',
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <div class="adv-search" style="display: <?= $mostrarAvanzada? 'block': 'none' ?>;">
<!--            <div class="col-md-8 col-md-offset-2">-->
            <div class="panel panel-default">
                <div class="panel-heading panel-heading-adv-search">
                    <h3 class="panel-title">Búsqueda Avanzada</h3>
                </div>
                <div class="panel-body">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'advanced-search',
                        'action' => ['site/index'],
                        'method' => 'post',
                    ]); ?>

                    <?php
                    if (!isset($_POST['avanzada'])) {
                        $searchModel['titulo'] = '';
                    }
                    ?>
                    <div class="col-md-6">
                        <?= $form->field($searchModel, 'titulo') ?>
                    </div>

                    <div class="col-md-3">
                        <?=$form->field($searchModel, 'dificultad_id')->dropDownList($dificultades, ['prompt' => 'Seleccione Uno' ]); ?>
                    </div>
                    <div class="col-md-3">
                        <?=$form->field($searchModel, 'categoria_id')->dropDownList($categorias, ['prompt' => 'Seleccione Uno' ]); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($searchModel, 'etiqueta')->widget(Select2::classname(),
                            [
                                'value' => $searchModel->etiqueta,
                                'options' => ['placeholder' => 'Etiquetas separadas por espacios...', 'multiple' => true],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'tags' => false,
                                    'tokenSeparators' => [',', ' '],
                                    'minimumInputLength' => 2,
                                    'maximumInputLength' => 20,
                                    'ajax' => [
                                        'url' => $urlEtiquetas,
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                ],
                            ]
                        ); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($searchModel, 'comensales')->textInput(
                            [
                                'type' => 'number',
                                'min' => 1,
                            ]
                        ) ?>
                    </div>

                    <div class="col-md-3">
                        <?= $form->field($searchModel, 'tiempo')->textInput([
                            'maxlength' => true,
                        ]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($searchModel, 'ingredientes')->textInput(
                                ['placeholder' => 'Ingredientes separados por espacios...']
                        ) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($searchModel, 'usuario_id')->widget(Select2::classname(),
                            [
                                'value' => $searchModel->usuario_id,
                                'initValueText' => $nombreUsuario,
                                'options' => ['placeholder' => 'Nombre de usuario'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 2,
                                    'maximumInputLength' => 20,
                                    'ajax' => [
                                        'url' => $urlUsuarios,
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                ],
                            ]
                        ); ?>
                    </div>

                    <?php // echo $form->field($model, 'pie') ?>

                    <?php // echo $form->field($model, 'categoria_id') ?>

                    <?= Html::hiddenInput('avanzada', 'avanzada') ?>

                    <?php // echo $form->field($model, 'created_at') ?>

                    <div class="col-md-12">
                        <div class="form-group bottons-adv-search">
                            <?= Html::submitButton('Buscar', ['class' => 'btn btn-success']) ?>
                            <?= Html::resetButton('Reset', ['class' => 'reset btn btn-danger']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end();
                    ?>
                </div>
            </div>
<!--            </div>-->
        </div>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; José Arjona <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
