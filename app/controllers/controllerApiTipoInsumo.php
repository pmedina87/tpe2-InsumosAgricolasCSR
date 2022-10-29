<?php
require_once './app/models/modelTipoInsumo.php';
require_once './app/controllers/controller.php';
require_once './app/views/viewApi.php';

class ApiTipoInsumoController extends Controller {
    
    private $model;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->model = new TipoInsumoModel();
    }

    /**
     * Funcion que devuelve todos los tipos de insumos
     */
    public function getTiposInsumos($params = null) {
        $tiposInsumos = $this->model->getAll();
        $this->view->response($tiposInsumos);
    }

    /**
     * Funcion que devuelve un tipo de insumo especifico, determinado por el ID recibido
     */
    public function getTipoInsumo($params = null) {
        $id = $params[':ID']; //capturo ID
        $tipoInsumo = $this->model->get($id);
        if ($tipoInsumo) {
            $this->view->response($tipoInsumo);
        }
        else {
             $this->view->response("El tipo de insumo con el id= $id no existe", 404);
        }
    }
    
    /**
    * Funcion que elimina un tipo de insumo especifico, determinado por el ID recibido
    */
    public function deleteTipoInsumo($params = null){
        $id = $params[':ID']; //capturo ID
        $tipoInsumo = $this->model->get($id);
        if ($tipoInsumo) {
            $this->model->delete($id);
            $this->view->response($tipoInsumo);  
        }
        else {
            $this->view->response("El tipo de insumo con el id= $id no existe", 404);
        }
    }

    /**
     * Funcion que agrega/inserta un nuevo tipo de insumo
     */
    public function addTipoInsumo($params = null){
        $tipoInsumo = $this->getData();

        if (empty($tipoInsumo->tipo_insumo)){
            $this->view->response("Debe completar todos los datos requeridos", 400);
        }
        // if ((empty($insumo->insumo) || isset($insumo->insumo)) || (empty($insumo->unidad_medida) || isset($insumo->unidad_medida)) || (empty($insumo->id_tipo_insumo) || isset($insumo->id_tipo_insumo))){
        //     $this->view->response("Debe completar todos los datos requeridos", 400);
        // }
        else {
            $id = $this->model->add($tipoInsumo->tipo_insumo);
            $this->view->response("El tipo de insumo se agrego con éxito, con el id= $id", 201);
        }
    }
    
    /**
     * Funcion que edita un insumo especifico, determinado por el ID recibido
     */
    public function updateTipoInsumo($params = null) {
        $id = $params[':ID']; //capturo ID
        $tipoInsumo = $this->getData();
        if (empty($tipoInsumo->tipo_insumo)){
            $this->view->response("Debe completar todos los datos requeridos", 400);
        }
        else{
            $this->model->update($tipoInsumo->id_tipo_insumo, $tipoInsumo->tipo_insumo);
            $this->view->response("El tipo de insumo con el ID= $id se actualizo con exito", 204);
        }
    }
    
}