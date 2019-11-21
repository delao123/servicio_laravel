<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SolicitudController extends Controller
{
    public function show($id){
        $centro_trabajo = $id;
        $date = date('y');
        $connection = mysqli_connect('localhost', 'root', '', 'sellonogarantia');
        $query = "SELECT id_solicitud,fecha FROM `solicitud`";
        $result = mysqli_query($connection,$query);
        while($row = mysqli_fetch_assoc($result)){
        $solicitud = $row['id_solicitud'];
        $fecha1 = $row['fecha'];
        }
        $solicitud1 = $centro_trabajo ."-" . $solicitud . "-" . $date;

        $solicitudes = DB::table('solicitud')
                            ->select(array('centroTrabajo','id_solicitud','fecha','status'))
                            ->where('centroTrabajo',$centro_trabajo)
                            ->get();
        $date = date("y");
         
        return view('solicitudes',[
            'fecha' => $fecha1,
            'solicitud_mensaje' => $solicitud1,
            'centro_trabajo' => $centro_trabajo,
            'solicitudes' => $solicitudes,
            'solicitud' => $solicitud,
            'date' => $date 
        ]);
    }

    public function script(){
    }
}
