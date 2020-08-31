<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $table='domains'; //vincula el modelo con la table d sql
   // vinculacion con el modelo customer (muchos a uno) Devuelve el objeto customer al que pertenece el domain)
    public function customer(){
    return $this->belongsTo('App\Customer');  
    }
}
