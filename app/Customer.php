<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table='customers';//vincula el modelo con la tabla SQL
    
// vinculacion con el modelo Device (un customer puede tener varios devices)
    public function devices(){
    return $this->hasMany('App\Device');   
    }
   // vinculacion con el modelo User (un customer puede tener varios users)
    public function users(){
    return $this->hasMany('App\User');   
    }   
      // vinculacion con el modelo Domain (un customer puede tener varios domains)
    public function domain(){
    return $this->hasMany('App\Domain');   
    }    
   // vinculacion con el modelo tenant (muchos a uno) Devuelve el objeto tenant al que pertenece elCustomer)
    public function tenant(){
    return $this->belongsTo('App\Tenant');  
    }

    
}
