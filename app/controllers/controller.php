<?php

require_once './app/views/viewApi.php';

class Controller {
    //protected $model;
    protected $view;
    protected $data;

    public function __construct() {
        //$this->model = null;
        $this->view = new ApiView();
        
        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

     public function getData() {
        return json_decode($this->data);
    }
    
}