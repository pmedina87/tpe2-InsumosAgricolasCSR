<?php

require_once './app/models/model.php';

class InsumoModel extends Model {

    function __construct() {
       parent::__construct();
    }

    /**
     * Consulta para mostrar todos los insumos
     */
    public function getAll(){
        $query = $this->db->prepare("SELECT id_insumo, insumo, unidad_medida, id_tipo_insumo FROM insumo");
        $query->execute();
        $insumos = $query->fetchAll(PDO::FETCH_OBJ);
        return $insumos;
    }

    /**
     * Consulta por ID un determinado insumo
     */
    public function get($id){
        $query = $this->db->prepare("SELECT id_insumo, insumo, unidad_medida, id_tipo_insumo FROM insumo WHERE id_insumo = ?");
        $query->execute([$id]);
        $insumo = $query->fetch(PDO::FETCH_OBJ);
        return $insumo;
    }

    /**
     * Agrega un nuevo Insumo
     */
    public function add($insumo, $unidad_medida, $id_tipo_insumo){
        $query = $this->db->prepare("INSERT INTO insumo (`insumo`, `unidad_medida`, `id_tipo_insumo`) VALUES (?, ?, ?)");
        $query->execute([$insumo, $unidad_medida, $id_tipo_insumo]);
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
    public function update($id_insumo, $insumo, $unidad_medida, $id_tipo_insumo){
        $query = $this->db->prepare("UPDATE insumo SET insumo = ?,unidad_medida = ?, id_tipo_insumo = ? WHERE id_insumo = ?");
        $query->execute([$insumo, $unidad_medida, $id_tipo_insumo, $id_insumo]); 
    }

     /**
     * Consulta por ID un determinado tipo de insumo
     */
    public function getTipoInsumo($id_tipoInsumo){
        $query = $this->db->prepare("SELECT id_insumo, insumo, unidad_medida, id_tipo_insumo FROM insumo WHERE id_tipo_insumo = ?");
        $query->execute([$id_tipoInsumo]);
        $insumos = $query->fetchAll(PDO::FETCH_OBJ);
        return $insumos;
    }
}