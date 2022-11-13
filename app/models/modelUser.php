<?php

require_once './app/models/model.php';
require_once './app/models/modelUser.php';

class UserModel extends Model {

    function __construct() {
       parent::__construct();
    }

    /**
     * Consulta para mostrar todos los usuarios
     */
    public function getAll(){
        $query = $this->db->prepare("SELECT * FROM usuario");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Consulta por ID un determinado usuario
     */
    public function getById($id){
        $query = $this->db->prepare("SELECT id_usuario, usuario, contrasenia, email, nombre_usuario, apellido_usuario FROM usuario WHERE id_usuario = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Agrega un nuevo Usuario
     */
    public function add($nombre, $apellido, $email, $usuario, $pass_hash){
        $query = $this->db->prepare("INSERT INTO usuario(usuario, contrasenia, email, nombre_usuario, apellido_usuario) VALUES (?, ?, ?, ?, ?)");
        $query->execute([$usuario, $pass_hash, $email, $nombre, $apellido]);   
    }

    /**
     * Elimina un usuario
     */
    public function delete($idUsuario){
        $query = $this->db->prepare("DELETE FROM usuario WHERE id_usuario = ?");
        $query->execute([$idUsuario]);   
    }

    /**
     * Edita un usuario
     */
    public function update($id_usuario, $nombre, $apellido, $email){
        $query = $this->db->prepare("UPDATE usuario SET nombre_usuario = ?, apellido_usuario = ?, email = ? WHERE id_usuario = ?");
        $query->execute([$nombre, $apellido, $email, $id_usuario]);   
    }

    /**
     * Devuelve un usuario segun el nombre de usuario
     */
    public function getByUsername($user){
        $query = $this->db->prepare("SELECT id_usuario, usuario, contrasenia FROM usuario WHERE usuario = ?");
        $query->execute([$user]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}
