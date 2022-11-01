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
     * Funcion que devuelve todos los insumos o algunos, si se agregan parametos
     */
    public function getInsumos($params = null){
        if(isset($_GET['inicio']) && isset($_GET['registros']) && is_numeric($_GET['inicio']) && is_numeric($_GET['registros'])){
            $insumos = $this->model->getAll();
            $inicio = $_GET['inicio'];
            if(count($insumos) < $inicio || $inicio < 0){
                $this->view->response("Error: ingreso un inicio que es superior al numero de registros o un valor de inicio negativo", 404);
            }else{
                $insumos = $this->model->getPage($_GET['inicio'], $_GET['registros']);
                $this->view->response($insumos);
            }    
        }
        elseif(isset($_GET['insumo']) && count($_GET) == 2){
            $insumos = $this->model->getInsumosNombre($_GET['insumo']);
            if(count($insumos) > 0){
                $this->view->response($insumos); 
            }else{
                $this->view->response("No hay registros para mostrar", 404);
            }
        }
        elseif(isset($_GET['unidadMedida']) && count($_GET) == 2){
            $insumos = $this->model->getInsumosUnidadMedida($_GET['unidadMedida']);
            if (count($insumos) > 0) {
                $this->view->response($insumos);
            } else {
                $this->view->response("No hay registros para mostrar", 404);
            }     
        }
        elseif(isset($_GET['tipoDeInsumo']) && count($_GET) == 2){
            $insumos = $this->model->getInsumosTiposInsumos($_GET['tipoDeInsumo']);
            if (count($insumos) > 0) {
                $this->view->response($insumos);
            } else {
                $this->view->response("No hay registros para mostrar", 404);
            }     
        }
        elseif(isset($_GET['sortBy']) && isset($_GET['order']) && count($_GET) == 3){
            if(($_GET['sortBy'] == 'insumo' || $_GET['sortBy'] == 'unidad_medida' || $_GET['sortBy'] == 'id_insumo' || $_GET['sortBy'] == 'id_tipo_insumo') && ($_GET['order'] == 'asc' || $_GET['order'] == 'desc')){
                $insumos = $this->model->getInsumosOrder($_GET['sortBy'], $_GET['order']);
                if (count($insumos) > 0) {
                    $this->view->response($insumos);
                } else {
                    $this->view->response("No hay insumos para mostrar", 404);
                }
            }else{
                $this->view->response("El campo o la forma a ordenar, no existe", 404);
            }     
        } 
        elseif (count($_GET) == 1){
            $insumos = $this->model->getAll();
            $this->view->response($insumos);            
        }
        else{
            $this->view->response("El recurso no existe", 404);
        }
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
            $this->view->response("El insumo se agrego con exito, con el id= $id", 201);
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