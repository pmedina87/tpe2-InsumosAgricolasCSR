<?php
require_once './libs/Router.php';
require_once './app/controllers/controllerApiInsumo.php';
require_once './app/controllers/controllerApiTipoInsumo.php';


// instancio un objeto de la clase Router
$router = new Router();

// defino la tabla de ruteo
$router->addRoute('insumos', 'GET', 'ApiInsumoController', 'getInsumos');
$router->addRoute('insumos/:ID', 'GET', 'ApiInsumoController', 'getInsumo');
$router->addRoute('insumos/:ID', 'DELETE', 'ApiInsumoController', 'deleteInsumo');
$router->addRoute('insumos', 'POST', 'ApiInsumoController', 'addInsumo');
$router->addRoute('insumos/:ID', 'PUT', 'ApiInsumoController', 'updateInsumo');

$router->addRoute('tiposInsumos', 'GET', 'ApiTipoInsumoController', 'getTiposInsumos');
$router->addRoute('tiposInsumos/:ID', 'GET', 'ApiTipoInsumoController', 'getTipoInsumo');
$router->addRoute('tiposInsumos/:ID', 'DELETE', 'ApiTipoInsumoController', 'deleteTipoInsumo');
$router->addRoute('tiposInsumos', 'POST', 'ApiTipoInsumoController', 'addTipoInsumo');
$router->addRoute('tiposInsumos/:ID', 'PUT', 'ApiTipoInsumoController', 'updateTipoInsumo');

// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);