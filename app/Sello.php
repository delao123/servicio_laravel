<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sello extends Model
{
public $timestamps = false;
//The attributes that are mass assignable.//
protected $fillable = ['material','tipo','codigo_almacen','cucop','partida_presupuestal',
                        'unidad_medida','cantidad','costo_unitario','subtotal',
                        'iva','comentarios','centro_trabajo'];

public function contador()
    {
        return $this->hasOne('App\Contador','centro_trabajo','centro_trabajo');
    }

}
