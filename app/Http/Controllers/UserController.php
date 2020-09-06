<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller {

    public function register(Request $request) {
        //Obtener datos usuario
        $json = $request->input('json', null);
        //Decodificar JSON    
        $values = json_decode($json);
        //var_dump($values->name);   //Devuelve objeto
        //die();
        $values_array = json_decode($json, true); //Devuelve array
        //var_dump($data_array); 
        // 
        //Limpiar datos
        if ($values_array) {
            $values_array = \array_map('trim', $values_array);
        }
        if (!empty($values) && !empty($values_array)) {
            //Validar datos
            $validate = \Validator::make($values_array, [
                        'name' => 'required|alpha',
                        'surname' => 'required|alpha',
                        'email' => 'required|email|unique:users', //Comprueba si el usuario existe
                        'password' => 'required'
            ]);

            if ($validate->fails()) {
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'El usuario no se ha creado',
                    'errors' => $validate->errors()
                );
            } else {
                //Validación correcta
                //Cifrar contraseña
                //$pwd=password_hash($values->password,PASSWORD_BCRYPT,['cost'=>4]); Geneera una encriptación diferente cada codificación
                $pwd = hash('sha256', $values->password);
                //Comprobar si exite usuario
                //Ya lo hizo en la validación
                //Crear usuario
                $user = new User();
                $user->name = $values_array['name'];
                $user->surname = $values_array['surname'];
                $user->email = $values_array['email'];
                $user->password = $pwd;
                $user->role = 'demo';
                //var_dump($user);
                //die();
                $user->save();
                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'El usuario se ha creado',
                    'user' => $user,
                );
            }
        } else {
            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'Los datos no son correctos'
            );
        }
        return response()->json($data, $data['code']);
    }

    /*
      public function register(Request $request){
      $name=$request->input('name');
      $surname=$request->input('surname');
      return "Acción REGISTRO $name $surname";
      } */

    public function login(Request $request) {
        $jwtAuth = new \JwtAuth();
        //Recibir datos por post
        $json = $request->input('json', null);
        $values = json_decode($json);
        //var_dump($values->name);   //Devuelve objeto
        //die();
        $values_array = json_decode($json, true);
        //$email = 'bachediaz@gmail.com';
        //$password = '123456';
        //Validar los datos
        $validate = \Validator::make($values_array, [
                    'email' => 'required|email',
                    'password' => 'required'
        ]);
        if ($validate->fails()) {
            $signup = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'El usuario no se ha podido loguear',
                'errors' => $validate->errors()
            );
            return response()->json($signup);
        } else {
            //$email = $values->email;
            //$password = $values->password;
            $pwd = hash('sha256', $values->password);
            //Devolver token o datos
            $signup = $jwtAuth->signup($values->email, $pwd);
            if (!empty($values->getToken)) {
                $signup = $jwtAuth->signup($values->email, $pwd, true);
            }
        }
        return response()->json($signup, 200);
        //$signup = $JwtAuth->signup($values->email,$pwd);
        //return response()->json($jwtAuth->signup($values->email,$pwd,true),200);
    }

    public function update(Request $request) {
        $token = $request->header('Authorization');
        $jwtAuth = new \JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if ($checkToken) {
          echo "<h1>Login correcto</h1>";
        } else {
            echo "<h1>Login incorrecto</h1>";
        }
        die();
    }

}
