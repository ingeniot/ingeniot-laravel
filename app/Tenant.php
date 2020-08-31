<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table='tenants'; //vincula el modelo con la table d sql
// vinculacion con el modelo customers (un tenant puede tener varios customers)
    public function customers(){
    return $this->hasMany('App\Customer');   
    }
}
