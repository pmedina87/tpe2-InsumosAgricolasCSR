<?php
require_once './libs/Router.php';
require_once './app/controllers/controllerApiInsumo.php';
require_once './app/controllers/controllerApiAuth.php';


// instancio un objeto de la clase Router
$router = new Router();

// defino la tabla de ruteo
$router->addRoute('insumos', 'GET', 'ApiInsumoController', 'getSupplies');
$router->addRoute('insumos/:ID', 'GET', 'ApiInsumoController', 'getSupplie');
$router->addRoute('insumos/:ID', 'DELETE', 'ApiInsumoController', 'deleteSupplie');
$router->addRoute('insumos', 'POST', 'ApiInsumoController', 'addSupplie');
$router->addRoute('insumos/:ID', 'PUT', 'ApiInsumoController', 'updateSupplie');

$router->addRoute('auth/token', 'GET', 'ApiAuthController', 'getToken');

// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);