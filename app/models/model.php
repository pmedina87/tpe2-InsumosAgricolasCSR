<?php

class Model {

    private $db;

    /**
     * Constructor de la clase tipoInsumoModel
     */
    public function __construct() {
        //1. abrimos la conexion
        $this->db = $this->connection();
    }

    /**
     * Conexion a base de datos
     * Funcion privada para que nadie (que no este dentro de la misma clase), pueda acceder
     */
    private function connection(){
        $db = new PDO('mysql:host=localhost;'.'dbname=db_insumos_agricolas;charset=utf8', 'root', '');
        return $db;
    }

}