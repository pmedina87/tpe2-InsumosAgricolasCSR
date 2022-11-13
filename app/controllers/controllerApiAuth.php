<?php

require_once './app/controllers/controller.php';
require_once './app/models/modelUser.php';
require_once './app/helpers/helpersApiAuth.php';
require_once './app/views/viewApi.php';


class ApiAuthController extends Controller {
    
    private $modelUser;
    private $authHelpers;
    
    public function __construct(){
        parent::__construct();
        $this->modelUser = new UserModel();
        $this->authHelpers = new ApiAuthHelper();
    }


    public function getToken($params = null){
        //obtengo el header
        $userAndPass = $this->authHelpers->getBasicHeader();
        $userHeader = $userAndPass['user'];
        $passHeader = $userAndPass['pass'];

        $userAndPassDB = $this->modelUser->getByUsername($userHeader);
        
        if($userAndPassDB && password_verify($passHeader, $userAndPassDB->contrasenia)){
            $idDB = $userAndPassDB->id_usuario;
            $userDB = $userAndPassDB->usuario;
            $token = $this->authHelpers->createToken($idDB, $userDB);
            $this->view->response(["Token" => $token], 200);
        }
        else {
            $this->view->response("No autorizado: Usuario y/o contraseña incorrectos", 401);
        }
    }
}
