<?php

namespace App\Http\Controllers;

use App\Contador;
use App\Sello;
use App\Solicitud;
use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    public function show(){
        //Llenado del dropdown
        $herramientas = DB::table('catalogo_herramienta')->pluck('material');
        $papelerias = DB:: table('catalogo_papeleria')->pluck('material');
        //Obtencion de datos para la tabla consultaSe
        $sellos = Sello::all();    
        return view('welcome')->with([
            'herramientas' => $herramientas,
            'papelerias' => $papelerias,
            'sellos' =>$sellos
        ]);
    }

    public function update(Request $request){
        $codigo_almacen = $request->codigoAlmacen;
        $cucop = $request->cucop;
        $partida_presupuestal = $request->partidaPresupuestal;
        $cantidad = $request->cantidad;
        $costo_unitario = $request->costo;
        $subtotal = $request->subtotal;
        $iva = $request->iva;
        $total = $request->total;
        $comentarios = $request->comentarios;

        Sello::where('codigo_almacen',$codigo_almacen)->update([
            'cucop'=> $cucop,
            'partida_presupuestal'=> $partida_presupuestal,
            'cantidad'=> $cantidad,
            'costo_unitario'=> $costo_unitario,
            'subtotal'=> $subtotal,
            'iva'=> $iva,
            'costo_total'=> $total,
            'comentarios'=> $comentarios
            ]);
        $response = "Update";
        echo json_encode($response); 
    }

    public function save(Request $request){
         //Peticion ajax para guardar el registro a la base de datos
         $sello = new Sello;
         $sello->material = $request->material_enviar;
         $sello->tipo = $request->tipo;
         $sello->codigo_almacen = $request->codigo_almacen;
         $sello->cucop = $request->cucop;
         $sello->partida_presupuestal = $request->partida_presupuestal;
         $sello->unidad_medida = $request->unidad_medida;
         $sello->cantidad = $request->cantidad;
         $sello->costo_unitario = $request->costo;
         $sello->subtotal = $request->subtotal;
         $sello->iva = $request->iva;
         $sello->costo_total = $request->total;
         $sello->comentarios = $request->comentarios;
         $sello->centro_trabajo = $request->centro_trabajo;
         $sello->save();
         $response = "Save";
         echo json_encode($response);
    }
    
    public function post_ajax(Request $request){
        //Peticion ajax para llenar datos del formulario modal
        if(isset($_POST['material'])){
        $mat = $request->material;
        $catalogo_papeleria = DB::table('catalogo_papeleria')
                                ->where('material',$mat);
        $catalogos = DB::table('catalogo_herramienta')
                        ->where('material',$mat)
                        ->union($catalogo_papeleria)
                        ->get(); 
        $clave = $catalogos->pluck('clave');
        $unidad = $catalogos->pluck('unidad_medida');
        $costo = $catalogos->pluck('precio_sin_iva'); 
        $response = [
            'material' => $mat,
            'clave' => $clave,
            'unidadMedida' => $unidad,
            'costo' => $costo
            ];
        echo json_encode($response);
        
        }elseif(isset($_POST['material_enviar'])){
            $material = $request->material_enviar;
            if(Sello::where('material',$material)->exists()) {
                echo "Ocupado";
            }else{
                echo "Disponible";
            }
        }elseif(isset($_POST['codigoAlmacen'])){
            $codigo_almacen = $request->codigoAlmacen;
            SELLO::where('codigo_almacen', $codigo_almacen)->delete();
        }elseif(isset($_POST['data'])){
            $codigo_almacen = $request->data;
            $sellos = Sello::where('codigo_almacen',$codigo_almacen)
                            ->get();
            $material = $sellos->pluck('material');
            $cucop = $sellos->pluck('cucop');
            $partida_presupuestal = $sellos->pluck('partida_presupuestal');
            $unidad_medida = $sellos->pluck('unidad_medida');
            $cantidad = $sellos->pluck('cantidad');
            $costo_unitario = $sellos->pluck('costo_unitario');
            $subtotal = $sellos->pluck('subtotal');
            $iva = $sellos->pluck('iva');
            $costo_total = $sellos->pluck('costo_total');
            $comentarios = $sellos->pluck('comentarios');
            $tipo = $sellos->pluck('tipo');
            $response = [
                'material' => $material,
                'codigoAlmacen' => $codigo_almacen,
                'cucop' => $cucop,
                'partidaPre' => $partida_presupuestal,
                'unidadMedida' => $unidad_medida,
                'cantidad' => $cantidad,
                'costo' => $costo_unitario,
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $costo_total,
                'comentarios' => $comentarios,
                'tipo' => $tipo,
                ];
                echo json_encode($response); 
        }elseif(isset($_POST['centroTrabajo'])){
            $centro_trabajo = $request->centroTrabajo;
            $conta = Contador::where('centro_trabajo', $centro_trabajo)
               ->get();
            $conta1 = $conta->pluck('contador');
            $contar1 = $conta1[0];
            $contar = $contar1 + 1;
            Contador::where('centro_trabajo',$centro_trabajo)->update([
                'contador' => $contar            
            ]);
            $sellos = Sello::all();
            $sellos->each(function(Sello $sello) {    
            Solicitud::create([
                'material' => $sello->material,
                'codigo_almacen' => $sello->codigo_almacen,
                'cantidad' => $sello->cantidad,
                'costo_total' => $sello->costo_total,
                'centro_trabajo' => $sello->centro_trabajo,
                'id_solicitud' => $sello->contador['contador'],
                'status' => "Pendiente" 
                ]);
            });
            $calcular_total = [];
            Sello::where('centro_trabajo', $centro_trabajo)->delete();
            
            $solicitud = Solicitud::where([
                                            ['centro_trabajo',$centro_trabajo],
                                            ['id_solicitud' , $contar],
                                        ])
                                    ->get() ;
            $materiales = $solicitud->pluck('material');
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
                    'contador' => $contar,
                    'material' => $materiales,
                    'codigo' => $materiales_id,
                    'cantidad' => $cantidad,
                    'total' => $total,
                    'suma' => $sumBien
            ];
            echo json_encode($response);
        } 
    }
}
