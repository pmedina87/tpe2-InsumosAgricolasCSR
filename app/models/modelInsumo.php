<?php

require_once './app/models/model.php';

class InsumoModel extends Model {

    function __construct() {
       parent::__construct();
    }

    /**
     * Ordena los insumos segun un abritubo que se pase por parametro y un tipo de orden
     */
    public function getSupplieOrder($attribute, $order){
        $query = $this->db->prepare("SELECT * FROM insumo ORDER BY $attribute $order");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Filtra los insumos segun el tipo de insumo que se pase por parametro
     */
    public function getSuppliesTypeOfSupplie($typeOfSupplie){
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $query = $this->db->prepare("SELECT id_insumo, insumo, unidad_medida, id_tipo_insumo FROM insumo WHERE id_tipo_insumo LIKE ?");
        $query->execute(["%$typeOfSupplie%"]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Filtra los insumos segun el insumo (nombre) que se pase por parametro
     */
    public function getSuppliesName($name) {
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $query = $this->db->prepare("SELECT id_insumo, insumo, unidad_medida, id_tipo_insumo FROM insumo WHERE insumo LIKE ?");
        $query->execute(["%$name%"]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Filtra los insumos segun la unidad de medida que se pase por parametro
     */
    public function getSuppliesUnitOfMeasurement($unitOfMeasurement){
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $query = $this->db->prepare("SELECT id_insumo, insumo, unidad_medida, id_tipo_insumo FROM insumo WHERE unidad_medida LIKE ?");
        $query->execute(["%$unitOfMeasurement%"]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Muestra una pagina especifica de XX registros
     */
    public function getPagination($start, $records){
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $query = $this->db->prepare("SELECT id_insumo, insumo, unidad_medida, id_tipo_insumo FROM insumo LIMIT ?, ?");
        $query->execute([$start, $records]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Consulta para mostrar todos los insumos
     */
    public function getAll(){
        $query = $this->db->prepare("SELECT id_insumo, insumo, unidad_medida, id_tipo_insumo FROM insumo");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Consulta por ID un determinado insumo
     */
    public function get($id){
        $query = $this->db->prepare("SELECT id_insumo, insumo, unidad_medida, id_tipo_insumo FROM insumo WHERE id_insumo = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Agrega un nuevo Insumo
     */
    public function add($supplie, $unitOfMeasurement, $idTypeOfSupplie){
        $query = $this->db->prepare("INSERT INTO insumo (`insumo`, `unidad_medida`, `id_tipo_insumo`) VALUES (?, ?, ?)");
        $query->execute([$supplie, $unitOfMeasurement, $idTypeOfSupplie]);
        return $this->db->lastInsertId();    
    }

    /**
     * Elimina un insumo
     */
    public function delete($id){
        $query = $this->db->prepare("DELETE FROM insumo WHERE id_insumo = ?");
        $query->execute([$id]); 
    }

    /**
     * Edita un insumo
     */
    public function update($idSupplie, $supplie, $unitOfMeasurement, $idTypeOfSupplie){
        $query = $this->db->prepare("UPDATE insumo SET insumo = ?,unidad_medida = ?, id_tipo_insumo = ? WHERE id_insumo = ?");
        $query->execute([$supplie, $unitOfMeasurement, $idTypeOfSupplie, $idSupplie]); 
    }

     /**
     * Consulta por ID un determinado tipo de insumo
     */
    public function getTipoInsumo($idTypeOfSupplie){
        $query = $this->db->prepare("SELECT id_insumo, insumo, unidad_medida, id_tipo_insumo FROM insumo WHERE id_tipo_insumo = ?");
        $query->execute([$idTypeOfSupplie]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}