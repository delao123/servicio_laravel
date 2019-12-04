<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contador extends Model
{
    //
    public $timestamps = false;

    protected $fillable = ['contador'];
    
    public function sellos()
    {
        return $this->belongsTo('App\Sello');
    }
   
}
