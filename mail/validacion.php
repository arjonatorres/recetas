<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */
$url = Url::to(['usuarios/validar', 'token' => $token], true);
?>
    <h2>Para activar su cuenta pulse en el siguiente enlace:</h2>
<?= Html::a($url, $url) ?>