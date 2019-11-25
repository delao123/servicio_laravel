<?php

namespace App\Http\Controllers;

use App\Sello;
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
        if (Sello::where('material',$material)->exists()) {
                echo "Ocupado";
            }else{
                echo "Disponible";
            }
        } 
    }
}
