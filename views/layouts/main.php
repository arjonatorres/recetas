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
//            [
//                'label' => '',
//            ],
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
    echo Nav::widget([
        'id' => 'menu-recetas',
        'options' => ['class' => 'navbar-nav navbar-left menu-item'],
        'items' => $menuCasa,
    ]);
    echo Nav::widget([
        'id' => 'menu-user',
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]);

//
//    echo Nav::widget([
//        'options' => ['class' => 'navbar-nav navbar-right'],
//        'items' => [
//            Yii::$app->user->isGuest ? (
//            ''
//            ) : (['label' => 'Nueva Receta', 'url' => ['/recetas/create']]),
//            Yii::$app->user->isGuest ? (
//                ['label' => 'Login', 'url' => ['/site/login']]
//            ) : (
//                '<li>'
//                . Html::beginForm(['/site/logout'], 'post')
//                . Html::submitButton(
//                    'Logout (' . Yii::$app->user->identity->usuario . ')',
//                    ['class' => 'btn btn-link logout']
//                )
//                . Html::endForm()
//                . '</li>'
//            )
//        ],
//    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
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
