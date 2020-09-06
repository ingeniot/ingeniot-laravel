<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Iluminate\Support\Facades\DB;
use App\User;

class JwtAuth {

    public $key;

    public function __construct() {
        $this->key = 'clave_ingeniot';
    }

    public function signup($email, $password, $getToken = null) {
        //Comprobar si existe el usuario    
        $user = User::where([
                    'email' => $email,
                    'password' => $password
                ])->first();
        $signup = false;
        //Comprobar credenciales correctas
        if (is_object($user)) {
            $signup = true;
        }
        //Generar token con datos de usuario
        if ($signup) {
            $token = array(
                'sub' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'surname' => $user->surname,
                'iat' => time(),
                'exp' => time() + (7 * 24 * 60 * 60)
            );
            $jwt = JWT::encode($token, $this->key, 'HS256');
            $decodedToken = JWT::decode($jwt, $this->key, ['HS256']);
            //Devolver los datos decodificados o el token, en función de un parámetro
            if (is_null($getToken)) {
                $data = $jwt;
            } else {
                $data = $decodedToken;
            }
        } else {
            $data = array(
                'status' => 'error',
                'message' => 'Login incorrecto'
            );
        }

        return $data;
    }

    public function checkToken($jwt, $getIdentity = false) {
        $auth = false;
        try {
            $jwt = str_replace('"','',$jwt);
            $decodedToken = JWT::decode($jwt, $this->key, ['HS256']);
        } catch (\UnexpectedValueException $e) {
            $auth = false;
        }catch (\DomainException $e) {
            $auth = false;
        }
        if(!empty($decodedToken)&& is_object($decodedToken) && isset($decodedToken->sub)){
            $auth=true;
        }
        else{
            $auth = false;
        }
        if($getIdentity){
            return $decodedToken;
        }
        return $auth;
        
    }

}
