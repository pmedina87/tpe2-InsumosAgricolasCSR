<?php

require_once 'model.php';

class TipoInsumoModel extends Model {

     function __construct() {
       parent::__construct();
    }

    /**
     * Consulta para mostrar todos los tipos de insumos
     */
    public function getAll(){
        $query = $this->db->prepare("SELECT * FROM tipo_insumo");
        $query->execute();
        $tiposInsumos = $query->fetchAll(PDO::FETCH_OBJ);
        return $tiposInsumos;
    }

    /**
     * Consulta por ID un determinado tipo de insumo
     */
    public function get($id){
        $query = $this->db->prepare("SELECT id_tipo_insumo, tipo_insumo FROM tipo_insumo WHERE id_tipo_insumo = ?");
        $query->execute([$id]);
        $tipoInsumo = $query->fetch(PDO::FETCH_OBJ);
        return $tipoInsumo;
    }

    /**
     * Agrega un nuevo Tipo de Insumo
     */
    public function add($tipo_insumo){
        $query = $this->db->prepare("INSERT INTO tipo_insumo(tipo_insumo) VALUES (?)");
        $query->execute([$tipo_insumo]);
        return $this->db->lastInsertId();    
    }

    /**
     * Elimina un tipo de insumo
     */
    public function delete($id_tipo_insumo){
        $query = $this->db->prepare("DELETE FROM tipo_insumo WHERE id_tipo_insumo = ?");
        $query->execute([$id_tipo_insumo]);   
    }

    /**
     * Edita un tipo de insumo
     */
    public function update($id_tipo_insumo, $tipo_insumo){
        $query = $this->db->prepare("UPDATE tipo_insumo SET tipo_insumo = ? WHERE id_tipo_insumo = ?");
        $query->execute([$tipo_insumo, $id_tipo_insumo]);   
    }
}