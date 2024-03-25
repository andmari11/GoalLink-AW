<?php
require_once __DIR__.'/includes/config.php';

$app = \es\ucm\fdi\aw\Aplicacion::getInstance();

$app->logout();
if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
    $app->redirige($app->resuelve("index.php"));
}



