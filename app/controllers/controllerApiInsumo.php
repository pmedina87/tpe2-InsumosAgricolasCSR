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
    
    /**
     * Funcion que devuelve todos los insumos
     */
    public function getInsumos($params = null) {
        $insumos = $this->model->getAll();
        $this->view->response($insumos);
    }

    /**
     * Funcion que devuelve un insumo especifico, determinado por el ID recibido
     */
    public function getInsumo($params = null) {
        $id = $params[':ID']; //capturo ID
        $insumo = $this->model->get($id);
        if ($insumo) {
            $this->view->response($insumo);
        }
        else {
             $this->view->response("El insumo con el id= $id no existe", 404);
        }
    }
    
    /**
    * Funcion que elimina un insumo especifico, determinado por el ID recibido
    */
    public function deleteInsumo($params = null){
        $id = $params[':ID']; //capturo ID
        $insumo = $this->model->get($id);
        if ($insumo) {
            $this->model->delete($id);
            $this->view->response($insumo);  
        }
        else {
            $this->view->response("El insumo con el id= $id no existe", 404);
        }
    }

    /**
     * Funcion que agrega/inserta un nuevo insumo
     */
    public function addInsumo($params = null){
        $insumo = $this->getData();

        if ((empty($insumo->insumo)) || (empty($insumo->unidad_medida)) || (empty($insumo->id_tipo_insumo))){
            $this->view->response("Debe completar todos los datos requeridos", 400);
        }
        // if ((empty($insumo->insumo) || isset($insumo->insumo)) || (empty($insumo->unidad_medida) || isset($insumo->unidad_medida)) || (empty($insumo->id_tipo_insumo) || isset($insumo->id_tipo_insumo))){
        //     $this->view->response("Debe completar todos los datos requeridos", 400);
        // }
        else {
            $id = $this->model->add($insumo->insumo, $insumo->unidad_medida, $insumo->id_tipo_insumo);
            $this->view->response("El insumo se agrego con éxito con el id= $id", 201);
        }
    }
    
    /**
     * Funcion que edita un insumo especifico, determinado por el ID recibido
     */
    public function updateInsumo($params = null) {
        $id = $params[':ID']; //capturo ID
        $insumo = $this->getData();
        if ((empty($insumo->insumo)) || (empty($insumo->unidad_medida)) || (empty($insumo->id_tipo_insumo))){
            $this->view->response("Debe completar todos los datos requeridos", 400);
        }
        else{
            $this->model->update($insumo->id_insumo, $insumo->insumo, $insumo->unidad_medida, $insumo->id_tipo_insumo);
            $this->view->response("El insumo con el ID= $id se actualizo con exito", 204);
        }
    }
}