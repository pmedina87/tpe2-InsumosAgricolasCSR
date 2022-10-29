<?php
require_once './app/models/modelInsumo.php';
require_once './app/controllers/controller.php';
require_once './app/views/viewApi.php';

class ApiInsumoController extends Controller {
    
    private $model;
    
    public function __construct() {
        parent::__construct();
        $this->model = new InsumoModel();
    }

    public function getInsumos($params = null) {
        $insumos = $this->model->getAll();
        $this->view->response($insumos);
    }
}