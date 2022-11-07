<?php
require_once './app/models/modelInsumo.php';
require_once './app/controllers/controller.php';
require_once './app/views/viewApi.php';

class ApiInsumoController extends Controller {
    
    private $model;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->model = new InsumoModel();
    }

    private function getSuppliesSortByAndOrder($sortBy, $order){
        if (($sortBy == 'insumo' || $sortBy == 'unidad_medida' || $sortBy == 'id_insumo' || $sortBy == 'id_tipo_insumo') && ($order == 'asc' || $order == 'desc')) {
            $supplies = $this->model->getSupplieOrder($sortBy, $order);
            if (count($supplies) > 0) {
                $this->view->response($supplies);
            } else {
                $this->view->response("No hay insumos para mostrar", 404);
            }
        } else {
            $this->view->response("El campo o la forma a ordenar, no existe", 404);
        }  
    }
    private function getSuppliesTypeOfSupplie($typeOfSupplie){
        $supplies = $this->model->getSuppliesTypeOfSupplie($typeOfSupplie);
        if (count($supplies) > 0) {
            $this->view->response($supplies);
        } else {
            $this->view->response("No hay registros para mostrar", 404);
        } 
    }

    private function getSuppliesUnitOfMeasurement ($unitOfMeasurement){
        $supplies = $this->model->getSuppliesUnitOfMeasurement($unitOfMeasurement);
        if (count($supplies) > 0) {
            $this->view->response($supplies);
        } else {
            $this->view->response("No hay registros para mostrar", 404);
        }    
    }
    
    private function getSupplieForName($supplie){
        $supplies = $this->model->getSuppliesName($supplie);
        if (count($supplies) > 0) {
            $this->view->response($supplies);
        } else {
            $this->view->response("No hay registros para mostrar", 404);
        }
    }

    private function getPagination($start, $limit) {
        $supplies = $this->model->getAll();
        if (count($supplies) < $start || $start < 0) {
            $this->view->response("Error: ingreso un inicio que es superior al numero de registros o un valor de inicio negativo", 404);
        } else {
            $supplies = $this->model->getPagination($start, $limit);
            $this->view->response($supplies);
        }
    }

    /**
     * Funcion que devuelve todos los insumos o algunos, si se agregan parametros
     */
    public function getSupplies($params = null){
        if(isset($_GET['start']) && isset($_GET['records']) && is_numeric($_GET['start']) && is_numeric($_GET['records'])){
            $start = $_GET['start'] - 1;
            $limit = $_GET['records'];
            $this->getPagination($start, $limit);   
        }

        elseif(isset($_GET['supplie']) && count($_GET) == 2){ //con count controlo que reciba solo dos parametros, para que no se vaya por otra rama del elseif
            $supplie = $_GET['supplie'];
            $this->getSupplieForName($supplie);
        }

        elseif(isset($_GET['unidadMedida']) && count($_GET) == 2){
            $unitOfMeasurement = $_GET['unidadMedida'];
            $this->getSuppliesUnitOfMeasurement($unitOfMeasurement);   
        }

        elseif(isset($_GET['tipoDeInsumo']) && count($_GET) == 2){ 
            $typeOfSupplie = $_GET['tipoDeInsumo']; 
            $this->getSuppliesTypeOfSupplie($typeOfSupplie);    
        }

        elseif(isset($_GET['sortBy']) && isset($_GET['order']) && count($_GET) == 3){ //con count controlo que reciba solo dos parametros, para que no se vaya por otra rama del elseif
            $sortBy = $_GET['sortBy'];
            $order = $_GET['order'];
            $this->getSuppliesSortByAndOrder($sortBy, $order);   
        } 

        elseif (count($_GET) == 1){
            $supplies = $this->model->getAll();
            $this->view->response($supplies);            
        }

        else{
            $this->view->response("El recurso no existe", 404);
        }
    }

    /**
     * Funcion que devuelve un insumo especifico, determinado por el ID recibido
     */
    public function getSupplie($params = null) {
        $id = $params[':ID']; //capturo ID
        $supplie = $this->model->get($id);
        if ($supplie) {
            $this->view->response($supplie);
        }
        else {
             $this->view->response("El insumo con el id= $id no existe", 404);
        }
    }
    
    /**
    * Funcion que elimina un insumo especifico, determinado por el ID recibido
    */
    public function deleteSupplie($params = null){
        $id = $params[':ID']; //capturo ID
        $supplie = $this->model->get($id);
        if ($supplie) {
            $this->model->delete($id);
            $this->view->response($supplie);  
        }
        else {
            $this->view->response("El insumo con el id= $id no existe", 404);
        }
    }

    /**
     * Funcion que agrega/inserta un nuevo insumo
     */
    public function addSupplie($params = null){
        $supplie = $this->getData();
        $nameSupplie = $supplie->insumo;
        $unitOfMeasurement = $supplie->unidad_medida;
        $typeOfSupplie = $supplie->id_tipo_insumo;
        if ((empty($nameSupplie)) || (empty($unitOfMeasurement)) || (empty($typeOfSupplie))){
            $this->view->response("Debe completar todos los datos requeridos", 400);
        }
        else {
            $id = $this->model->add($nameSupplie, $unitOfMeasurement, $typeOfSupplie);
            $this->view->response("El insumo se agrego con exito, con el id= $id", 201);
        }
    }
    
    /**
     * Funcion que edita un insumo especifico, determinado por el ID recibido
     */
    public function updateSupplie($params = null) {
        $id = $params[':ID']; //capturo ID
        $supplie = $this->getData();
        $idSupplie = $supplie->id_insumo;
        $nameSupplie = $supplie->insumo;
        $unitOfMeasurement = $supplie->unidad_medida;
        $typeOfSupplie = $supplie->id_tipo_insumo;
        if ((empty($nameSupplie)) || (empty($unitOfMeasurement)) || (empty($typeOfSupplie))){
            $this->view->response("Debe completar todos los datos requeridos", 400);
        }
        else{
            $this->model->update($idSupplie, $nameSupplie, $unitOfMeasurement, $typeOfSupplie);
            $this->view->response("El insumo con el ID= $idSupplie se actualizo con exito", 204);
        }
    }
}