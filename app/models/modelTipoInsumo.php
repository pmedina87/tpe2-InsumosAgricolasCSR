<?php

require_once 'model.php';

class TipoInsumoModel extends Model {

     function __construct() {
       parent::__construct();
    }

    /**
     * Muestra una pagina especifica de XX registros
     */
    public function getPage($inicio, $registros)
    {
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $query = $this->db->prepare("SELECT * FROM tipo_insumo LIMIT ?, ?");
        // $query->execute(array(intval($inicio), intval($limite)));
        $query->execute([$inicio, $registros]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Consulta para mostrar todos los tipos de insumos
     */
    public function getAll(){
        $query = $this->db->prepare("SELECT * FROM tipo_insumo");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Consulta para mostrar todos los id de tipos de insumos
     */
    public function getAllId(){
        $query = $this->db->prepare("SELECT id_tipo_insumo FROM tipo_insumo");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Consulta por ID un determinado tipo de insumo
     */
    public function get($id){
        $query = $this->db->prepare("SELECT id_tipo_insumo, tipo_insumo FROM tipo_insumo WHERE id_tipo_insumo = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Agrega un nuevo Tipo de Insumo
     */
    public function add($typeOfSupplie){
        $query = $this->db->prepare("INSERT INTO tipo_insumo(tipo_insumo) VALUES (?)");
        $query->execute([$typeOfSupplie]);
        return $this->db->lastInsertId();    
    }

    /**
     * Elimina un tipo de insumo
     */
    public function delete($idTypeOfSupplie){
        $query = $this->db->prepare("DELETE FROM tipo_insumo WHERE id_tipo_insumo = ?");
        $query->execute([$idTypeOfSupplie]);   
    }

    /**
     * Edita un tipo de insumo
     */
    public function update($idTypeOfSupplie, $typeOfSupplie){
        $query = $this->db->prepare("UPDATE tipo_insumo SET tipo_insumo = ? WHERE id_tipo_insumo = ?");
        $query->execute([$typeOfSupplie, $idTypeOfSupplie]);   
    }
}