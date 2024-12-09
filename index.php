<?php
require_once 'config/config.php';
require 'routes.php';
session_start();
// Obtener la URI solicitada
$uri = trim($_SERVER['REQUEST_URI'], '/');
// Iniciar la aplicación
$app = new App();
$app->run($uri);
?>