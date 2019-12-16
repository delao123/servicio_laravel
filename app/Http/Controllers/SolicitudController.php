<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solicitud;
use DB;

class SolicitudController extends Controller
{
    public function show($id){
        $centro_trabajo = $id;
        $date = date("y");
        $solicitud_ultima = Solicitud:: where('centro_trabajo',$centro_trabajo)
                                ->max('id_solicitud');
        $fecha = Solicitud:: where('centro_trabajo',$centro_trabajo)
                                ->max('created_at');
        $solicitud = $centro_trabajo ."-" . $solicitud_ultima . "-" . $date;
        
        return view("solicitudes")->with([
            'solicitud' => $solicitud,
            'fecha' => $fecha
        ]);
    }

    public function script(){
    }
}
