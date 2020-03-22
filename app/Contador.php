<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contador extends Model
{
    //
    public $timestamps = false;

    protected $fillable = ['centro_trabajo','contador'];
    
    public function sellos()
    {
        return $this->belongsTo('App\Sello');
    }
   
    public function contador()
    {
        return $this->belongsTo('App/User');
    }
}
