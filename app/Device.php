<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    //
    protected $table='devices';  //relación con la tabla correspondiente en sql
    
   // vinculacion con el modelo customer (muchos a uno) Devuelve el objeto customer al que pertenece el device)
    public function customer(){
    return $this->belongsTo('App\Customer');  
    }
    }
