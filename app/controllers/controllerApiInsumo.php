<?php
require_once './app/controllers/controller.php';
require_once './app/models/modelInsumo.php';
require_once './app/models/modelTipoInsumo.php';
require_once './app/views/viewApi.php';
require_once './app/helpers/helpersApiAuth.php';

class ApiInsumoController extends Controller
{

    private $modelInsumos;
    private $modelTiposInsumos;
    private $helpersAuth;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->modelInsumos = new InsumoModel();
        $this->modelTiposInsumos = new TipoInsumoModel();
        $this->helpersAuth = new ApiAuthHelper();
    }

    /**
     * Funcion que chequea si el Id tipo de insumo ingresado, esta dentro de los que tiene la DB.
     */
    private function checkIdTypeOfSupplie($typeOfSupplie)
    {
        $typesOfSupplies = $this->modelTiposInsumos->get($typeOfSupplie);
        if ($typesOfSupplies == null) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Funcion que arroja un error que el id tipo de insumo es incorrecto.
     */
    private function errorIdTypeOfSupplieInsert()
    {
        $this->view->response("El id_tipo_insumo ingresado no es valido.", 400);
    }

    /**
     * Funcion que arroja un error que el id de insumo es incorrecto.
     */
    private function errorIdSupplieInsert($id)
    {
        $this->view->response("El insumo con el id= $id no existe", 404);
    }

    /**
     * Funcion que muestra un mensje cuando no hya registros para mostrar
     */
    private function msgNotRegister()
    {
        $this->view->response("No hay registros para mostrar", 404);
    }

    /**
     * Funcion que ordena por uno de los campos de la tabla Insumos y los ordena ascendente o descendentemente.
     */
    private function getSuppliesSortByAndOrder($sortBy, $order)
    {
        if (($sortBy == 'insumo' || $sortBy == 'unidad_medida' || $sortBy == 'id_insumo' || $sortBy == 'id_tipo_insumo') && ($order == 'asc' || $order == 'desc')) {
            $supplies = $this->modelInsumos->getSupplieOrder($sortBy, $order);
            if (count($supplies) > 0) {
                $this->view->response($supplies);
            } else {
                $this->msgNotRegister();
            }
        } else {
            $this->view->response("El campo o la forma a ordenar, no existe", 404);
        }
    }

    /**
     * Funcion que filtra los insumos por Tipo de Insumo.
     */
    private function getSuppliesTypeOfSupplie($typeOfSupplie)
    {
        $supplies = $this->modelInsumos->getSuppliesTypeOfSupplie($typeOfSupplie);
        if (count($supplies) > 0) {
            $this->view->response($supplies);
        } else {
            $this->msgNotRegister();
        }
    }

    /**
     * Funcion que filtra los insumos por unidad de medida.
     */
    private function getSuppliesUnitOfMeasurement($unitOfMeasurement)
    {
        $supplies = $this->modelInsumos->getSuppliesUnitOfMeasurement($unitOfMeasurement);
        if (count($supplies) > 0) {
            $this->view->response($supplies);
        } else {
            $this->msgNotRegister();
        }
    }

    /**
     * Funcion que filtra los insumos por nombre de insumo.
     */
    private function getSupplieForName($supplie)
    {
        $supplies = $this->modelInsumos->getSuppliesName($supplie);
        if (count($supplies) > 0) {
            $this->view->response($supplies);
        } else {
            $this->msgNotRegister();
        }
    }

    /**
     * Funcion que permite la paginacion de los datos, pasando por parametro, desde que registro comenzar y la cantidad de registros.  
     */
    private function getPaginationForCountRecords($start, $records)
    {
        $supplies = $this->modelInsumos->getAll();
        if (count($supplies) <= $start || $start < 0) {
            $this->view->response("Error: ingreso un inicio que es superior al numero de registros o un valor de inicio negativo", 404);
        } else {
            $supplies = $this->modelInsumos->getPagination($start, $records);
            $this->view->response($supplies);
        }
    }

    /**
     * Funcion que permite la paginacion de los datos, pasando por parametro, la pagina y la cantidad de registros.  
     */
    private function getPaginationForPage($page, $records)
    {
        if ($page > 0 && $records > 0) {
            $supplies = $this->modelInsumos->getAll();
            $countSupplies = count($supplies);
            $pages = $countSupplies / $records;
            $start = $page * $records;
            if ($pages >= $page) {
                $result = array();
                for ($i = $start - $records; $i < $start; $i++) {
                    array_push($result, $supplies[$i]);
                }
                $this->view->response($result);
            } else {
                $this->view->response("Error: la cantidad de paginas o registros no alcanzan con el requerimiento solicitado", 404);
            }
        } else {
            $this->view->response("Error: la cantidad de paginas o registros debe ser mayor o igual a 1", 404);
        }
    }

    /**
     * Funcion que devuelve todos los insumos o algunos, si se agregan parametros
     */
    public function getSupplies($params = null)
    {
        if (isset($_GET['start']) && isset($_GET['records']) && is_numeric($_GET['start']) && is_numeric($_GET['records'])) {
            $start = $_GET['start'] - 1;
            $records = $_GET['records'];
            $this->getPaginationForCountRecords($start, $records);
        } elseif (isset($_GET['page']) && isset($_GET['records']) && is_numeric($_GET['page']) && is_numeric($_GET['records'])) {
            $page = $_GET['page'];
            $records = $_GET['records'];
            $this->getPaginationForPage($page, $records);
        } elseif (isset($_GET['supplie']) && count($_GET) == 2) { //con count controlo que reciba solo dos parametros, para que no se vaya por otra rama del elseif
            $supplie = $_GET['supplie'];
            $this->getSupplieForName($supplie);
        } elseif (isset($_GET['unitOfMeasurement']) && count($_GET) == 2) {
            $unitOfMeasurement = $_GET['unitOfMeasurement'];
            $this->getSuppliesUnitOfMeasurement($unitOfMeasurement);
        } elseif (isset($_GET['typeOfSupplie']) && count($_GET) == 2) {
            $typeOfSupplie = $_GET['typeOfSupplie'];
            $this->getSuppliesTypeOfSupplie($typeOfSupplie);
        } elseif (isset($_GET['sortBy']) && isset($_GET['order']) && count($_GET) == 3) { //con count controlo que reciba solo dos parametros, para que no se vaya por otra rama del elseif
            $sortBy = $_GET['sortBy'];
            $order = $_GET['order'];
            $this->getSuppliesSortByAndOrder($sortBy, $order);
        } elseif (count($_GET) == 1) {
            $supplies = $this->modelInsumos->getAll();
            $this->view->response($supplies);
        } else {
            $this->view->response("El recurso no existe", 404);
        }
    }

    /**
     * Funcion que devuelve un insumo especifico, determinado por el ID recibido
     */
    public function getSupplie($params = null)
    {
        $id = $params[':ID']; //capturo ID
        $supplie = $this->modelInsumos->get($id);
        if ($supplie) {
            $this->view->response($supplie);
        } else {
            $this->errorIdSupplieInsert($id);
        }
    }

    /**
     * Funcion que elimina un insumo especifico, determinado por el ID recibido
     */
    public function deleteSupplie($params = null)
    {
        if ($this->helpersAuth->isLoggedIn()) {
            $id = $params[':ID']; //capturo ID
            $supplie = $this->modelInsumos->get($id);
            if ($supplie) {
                $this->modelInsumos->delete($id);
                $this->view->response($supplie);
            } else {
                $this->errorIdSupplieInsert($id);
            }
        } else {
            $this->view->response("Error de autenticacion", 401);
        }
    }

    /**
     * Funcion que agrega/inserta un nuevo insumo
     */
    public function addSupplie($params = null)
    {
        if ($this->helpersAuth->isLoggedIn()) {
            $supplie = $this->getData();
            $countElem = count((array)$supplie);
            if ($countElem == 3 && isset($supplie->insumo) && isset($supplie->unidad_medida) && isset($supplie->id_tipo_insumo)) {
                $nameSupplie = $supplie->insumo;
                $unitOfMeasurement = $supplie->unidad_medida;
                $typeOfSupplie = $supplie->id_tipo_insumo;

                if ($this->checkIdTypeOfSupplie($typeOfSupplie)) {
                    $this->errorIdTypeOfSupplieInsert();
                } else {
                    $id = $this->modelInsumos->add($nameSupplie, $unitOfMeasurement, $typeOfSupplie);
                    $this->view->response("El insumo se agrego con exito, con el id= $id", 201);
                }
            } else {
                $this->view->response("Debe completar todos los datos requeridos", 400);
            }
        } else {
            $this->view->response("Error de autenticacion", 401);
        }
    }

    /**
     * Funcion que edita un insumo especifico, determinado por el ID recibido
     */
    public function updateSupplie($params = null)
    {
        if ($this->helpersAuth->isLoggedIn()) {
            $supplie = $this->getData();
            $countElem = count((array)$supplie);
            if ($countElem == 4 && isset($supplie->id_insumo) && isset($supplie->insumo) && isset($supplie->unidad_medida) && isset($supplie->id_tipo_insumo)) {
                $idSupplie = $supplie->id_insumo;
                $nameSupplie = $supplie->insumo;
                $unitOfMeasurement = $supplie->unidad_medida;
                $typeOfSupplie = $supplie->id_tipo_insumo;

                if ($this->checkIdTypeOfSupplie($typeOfSupplie)) {
                    $this->errorIdTypeOfSupplieInsert();
                } else {
                    $this->modelInsumos->update($idSupplie, $nameSupplie, $unitOfMeasurement, $typeOfSupplie);
                    $this->view->response("El insumo con el id= $idSupplie, se actualizo con exito", 204);
                }
            } else {
                $this->view->response("Debe completar todos los datos requeridos", 400);
            }
        } else {
            $this->view->response("Error de autenticacion", 401);
        }
    }
}
