<?php

/**
 * funcion que reemplaza los +/ por -_ y quita los signos = 
 */
function base64url_encode($data){

    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

class ApiAuthHelper {

    private $key;

    function __construct() {
        $this->key = "claveUnica";
    }

    function getUser(){
        $header = $this->getAuthHeader(); // Bearer header.payload.signature
        if (strpos($header, 'Bearer ') === 0) { // === asegura que la variable sea un numero e igual a 0 en este caso
            $token = explode(' ', $header)[1];
            $partsToken = explode('.', $token);
            if(count($partsToken)===3){
                $headerSend = $partsToken[0];
                $payloadSend = $partsToken[1];
                $signatureSend = $partsToken[2];

                $new_signature = hash_hmac('SHA256', "$headerSend.$payloadSend", $this->key, true);
                $new_signature = base64url_encode($new_signature);
                if ($signatureSend == $new_signature){
                    $payload = base64_decode($payloadSend);
                    $payload = json_decode($payload);
                    return $payload;
                }
            }
        }
        return null;    
    }

    function isLoggedIn(){
        $payload = $this->getUser();
        if(isset($payload->id)){
            return true;
        }
        else{
            return false;
        }
    }

    function getBasicHeader() {
        $header = $this->getAuthHeader();
        if (strpos($header, 'Basic ') === 0){ // === asegura que la variable sea un numero e igual a 0 en este caso
            $userAndPass = explode(' ', $header)[1];
            $userAndPassBase64 = base64_decode($userAndPass);
            $userAndPassOK = explode(':', $userAndPassBase64);
            if(count($userAndPassOK) == 2){
                $user = $userAndPassOK[0];
                $pass = $userAndPassOK[1];
                return array(
                    "user" => $user, 
                    "pass" => $pass
                );
            }
        }
        else {
            return null;
        }
    }

    /**
     * Funcion para obtener el header
     */
    function getAuthHeader(){
        
        if(isset($_SERVER['HTTP_AUTHORIZATION'])){
            return $_SERVER['HTTP_AUTHORIZATION'];
        }
        if(isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])){
            return $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }
        return null;
    }

    public function createToken($idDB, $userDB){
        $header = array(
                'alg' => 'HS256',
                'typ' => 'JWT'
            );
        $payload = array(
            'id' => $idDB,
            'name' => $userDB,
            'exp' => time() + 3600
        );

        // codifica header y payload
        $header = base64url_encode(json_encode($header));
        $payload = base64url_encode(json_encode($payload));
        $signature = hash_hmac('SHA256', "$header.$payload", $this->key, true);
        $signatureOK = base64url_encode($signature);


        return "$header.$payload.$signatureOK";
    }
}
