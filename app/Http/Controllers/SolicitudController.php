<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solicitud;
use DB;

class SolicitudController extends Controller
{
    //Constructor para dejar pasar usuarios autentificados  
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $centro_trabajo = $id;
        $date = date("y");
        $solicitud_ultima = Solicitud:: where('centro_trabajo',$centro_trabajo)
                                ->max('id_solicitud');
        $fecha = Solicitud:: where('centro_trabajo',$centro_trabajo)
                                ->max('created_at');
        $solicitud = $centro_trabajo ."-" . $solicitud_ultima . "-" . $date;

        $solicitudes = Solicitud :: where('centro_trabajo',$centro_trabajo)
                                    ->get();
        return view("solicitudes")->with([
            'solicitud' => $solicitud,
            'fecha' => $fecha,
            'solicitudes' => $solicitudes,
            'centro_trabajo' => $centro_trabajo,
            'date' => $date
        ]);
    }

    public function post_ajax(Request $request){
        $centro_trabajo = auth()->user()->name;
        $id_solicitud = $request->solicitud;

        $solicitud = Solicitud::where([
            ['centro_trabajo',$centro_trabajo],
            ['id_solicitud' , $id_solicitud],
        ])->get() ;
        $materiales = [];
        $materiales_solo = $solicitud->pluck('material');
        foreach ($materiales_solo as $material){
            $material = "- " . $material;
            $materiales[] = $material;
        }
        $materiales_id = $solicitud->pluck('codigo_almacen');
        $cantidad =$solicitud->pluck('cantidad');
        $total = [];
        $totales = $solicitud->pluck('costo_total'); 
        foreach ($totales as $total1) {
        $total1 = "$" . $total1;
        $total[] = $total1;
        }
        $sum = $solicitud->sum('costo_total');
        $sumBien = round($sum, 2, PHP_ROUND_HALF_ODD);
        $response = [
            'id' => $centro_trabajo,
            'contador' => $id_solicitud,
            'material' => $materiales,
            'codigo' => $materiales_id,
            'cantidad' => $cantidad,
            'total' => $total,
            'suma' => $sumBien
            ];
            echo json_encode($response);
        }
}
