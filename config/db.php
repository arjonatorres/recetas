<?php
if (YII_ENV_DEV) {
    // Configuración para entorno local:
    $host = 'localhost';
    $port = '3306';
    $dbname = 'recetas';
    $username = 'jose';
    $password = 'jose';
    $extra = [];
} else {
    // Configuración para entorno producción:
    $host = 'localhost';
    $port = '3306';
    $dbname = 'recetas';
    $username = 'jose';
    $password = 'jose';
    $extra = [];
}
return [
        'class' => 'yii\db\Connection',
        'dsn' => "mysql:host=$host;dbname=$dbname",
        'username' => $username,
        'password' => $password,
        'charset' => 'utf8',
    ] + $extra;
