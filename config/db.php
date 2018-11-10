<?php
if (YII_ENV_PROD) {
    // Configuración para entorno producción:
    $host = 'localhost';
    $port = '5432';
    $dbname = 'recetas';
    $username = 'jose';
    $password = 'jose';
    $extra = [];
} else {
    // Configuración para entorno local:
    $host = '192.168.1.13';
    $port = '5432';
    $dbname = 'recetas';
    $username = 'jose';
    $password = 'jose';
    $extra = [];
}
return [
        'class' => 'yii\db\Connection',
        'dsn' => "pgsql:host=$host;port=$port;dbname=$dbname",
        'username' => $username,
        'password' => $password,
        'charset' => 'utf8',
    ] + $extra;
