<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;
use App\Domain;
use App\Customer;

class PruebaControllers extends Controller
{
    public function index(){
        $title='Dispositivos';
        $devices =["ESP32","ARDUINO","LORA"];
        return view('pruebas.prueba',array(
            'titulo'=>$title,
            'dispositivos'=>$devices                
        ));
    }
    
    public function testOrm(){
        $dispositivos = Device::all();
        foreach($dispositivos as $dispositivo){
            echo "<h1>".$dispositivo->name."</h1>";
            echo "<span>{$dispositivo->customer->name}</span>";
        }
        die();
    }
}
