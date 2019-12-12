<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['material','codigo_almacen','cantidad','costo_total','centro_trabajo',
    'id_solicitud','status','created_at'];
}
