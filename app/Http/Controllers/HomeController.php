<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    public function show(){
        $sellos = DB::table('sello')
                    ->select(array('material', 'codigoAlmacen', 'cucop', 'cantidad', 'costoTotal', 'comentarios','Fecha' ))
                    ->get();
        $herramientas = DB::table('catalogo_herramientas')
                        ->pluck('descripcion');
        $papelerias = DB::table('catalogo_papeleria')
                        ->pluck('descripcion');
        return view('welcome',[
            'sellos' => $sellos,
            'herramientas' => $herramientas,
            'papelerias' => $papelerias
            ]);
    }
    public function peticiones(){
        //Peticion cuando cambia el material en el dropdown para el llenado del formulario
        if(isset($_POST['material'])){
            $mat = $_POST['material'];
            $catalogo_papeleria = DB::table('catalogo_papeleria')
                                        ->where('descripcion',$mat);
                $catalogos = DB::table('catalogo_herramientas')
                                        ->where('descripcion',$mat)
                                        ->union($catalogo_papeleria)
                                        ->get(); 
                $clave = $catalogos->pluck('clave');
                $unidad = $catalogos->pluck('unidadMedida');
                $costo = $catalogos->pluck('preciosiniva');    
                $response = [
                'material' => $mat,
                'clave' => $clave,
                'unidadMedida' => $unidad,
                'costo' => $costo
                ];
                echo json_encode($response);
            exit();
            }
    //Peticion eliminar registro
    elseif(isset($_POST["codigoAlmacen"])) {
            $codigo = $_POST['codigoAlmacen'];
            DB::table('sello')->where('codigoAlmacen',$codigo)->delete(); 
            }
    //Peticion para mostrar los datos a editar
    elseif(isset($_POST['data'])){
            $codigo = $_POST['data'];
            $edit = DB::table('sello')
                        ->where('codigoAlmacen', $codigo);
            $mat = $edit->pluck('material');
            $cucop = $edit->pluck('cucop');
            $partidaPre = $edit->pluck('partidaPresupuestal');
            $unidad = $edit->pluck('unidadMedida');
            $cantidad = $edit->pluck('cantidad');
            $costoUni = $edit->pluck('costoUnitario');
            $costo_array = $costoUni[0];
            $costo= str_replace ( "$", '', $costo_array);    
            $subtotal = $edit->pluck('subtotal');
            $iva = $edit->pluck('iva');
            $total = $edit->pluck('costoTotal');
            $comentarios = $edit->pluck('comentarios');
            $tipo = $edit->pluck('tipo');
            
            $response = [
            'material' => $mat,
            'codigoAlmacen' => $codigo,
            'cucop' => $cucop,
            'partidaPre' => $partidaPre,
            'unidadMedida' => $unidad,
            'cantidad' => $cantidad,
            'costo' => $costo,
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $total,
            'comentarios' => $comentarios,
            'tipo' => $tipo
            ];
            echo json_encode($response); 
            exit();
            }
    //Peticion contador y llenar tabla de solicitud
    elseif(isset($_POST["centroTrabajo"])) {
        $id = $_POST['centroTrabajo'];
        $connection = mysqli_connect('localhost', 'root', '', 'sellonogarantia');
                $contador_query = mysqli_query($connection, "SELECT contador FROM contador WHERE id='$id'");
                $conta = mysqli_fetch_assoc($contador_query);
                $contador = $conta['contador'];
                $contador++;
                $query = "UPDATE contador SET contador = '$contador' WHERE id = '$id'"; 
                $result = mysqli_query($connection, $query);
                
                $solicitud_query = "INSERT INTO solicitud (nombre_material, id_material, cantidad_material, total_material, centroTrabajo,id_solicitud)
                SELECT sello.material, sello.codigoAlmacen, sello.cantidad, sello.costoTotal, sello.centroTrabajo, contador.contador FROM sello, contador 
                WHERE sello.centroTrabajo = '$id' AND contador.id = '$id'";
                $result = mysqli_query($connection, $solicitud_query);
                
                $query = "TRUNCATE TABLE sello"; 
                $result = mysqli_query($connection, $query);
                $material = [];
                $material_id = [];
                $cantidad = [];
                $total = [];
                $calcular_total = [];        
                $mostrar_datos_query = "SELECT * from solicitud where id_solicitud = '$contador' AND centroTrabajo = '$id'";
                $result = mysqli_query($connection, $mostrar_datos_query);
                while($row = mysqli_fetch_assoc($result)){
                        $material[] = $row['nombre_material'] . "<br>";
                        $material_id[] = $row['id_material'] . "<br>";
                        $cantidad[] =$row['cantidad_material'] . "<br>";
                        $total[] = $row['total_material'] . "<br>";
                        $calcular = $row['total_material'];
                        $calcularUno = str_replace("$", '', $calcular);
                        $calcular_total[] = $calcularUno;
                        }
                        $sum = array_sum($calcular_total);
                        $sumBien = round($sum, 2, PHP_ROUND_HALF_ODD);
        $response = [
                'id' => $id,
                'contador' => $contador,
                'material' => $material,
                'codigo' => $material_id,
                'cantidad' => $cantidad,
                'total' => $total,
                'suma' => $sumBien
        ];
        echo json_encode($response);
        exit();
        }  
    }

    public function comparar_existencia(){
    $material = $_POST['material'];
    $connection = mysqli_connect('localhost', 'root', '', 'sellonogarantia');
    $check = mysqli_query($connection, "SELECT * FROM sello WHERE material='$material'");
    $checkrows=mysqli_num_rows($check);
    if($checkrows>0) {
        echo "Ocupado";
    } else {
        echo "Disponible";
    }
    }

    public function guardar_datos_sello(){
        $material = $_POST['material'];
        $tipo = $_POST['tipo'];
        $codigoAlmacen = $_POST['codigoAlmacen'];
        $cucop = $_POST['cucop'];
        $partidaPresupuestal = $_POST['partidaPresupuestal'];
        $unidad = $_POST['unidadMedida'];
        $cantidad = $_POST['cantidad'];
        $costo = $_POST['costo'];
        $subtotal = $_POST['subtotal'];
        $iva = $_POST['iva'];
        $total = $_POST['total'];
        $comentarios = $_POST['comentarios'];
        $centroTrabajo = $_POST['centroTrabajo'];

        $connection = mysqli_connect('localhost', 'root', '', 'sellonogarantia');
        if($connection){
            $query = "INSERT INTO sello (material,tipo,codigoAlmacen,cucop,partidaPresupuestal,
                    unidadMedida,cantidad,costoUnitario,subtotal,iva,costoTotal,comentarios,Fecha,centroTrabajo) ";
            $query .= "VALUES ('$material', '$tipo', '$codigoAlmacen','$cucop','$partidaPresupuestal','$unidad',
                            '$cantidad','$costo','$subtotal','$iva','$total','$comentarios', NOW(), '$centroTrabajo')";
            $result = mysqli_query($connection, $query);
        }else{
            echo "QUERY FAILED";
        }
        
        $response = [
            'material' => $material,
            'codigoAlmacen' =>$codigoAlmacen,
            'cucop' =>$cucop,
            'partidaPresupuestal' =>$partidaPresupuestal,
            'unidadMedida' => $unidad,
            'cantidad' => $cantidad,
            'costo' => $costo,
            'iva' => $iva,
            'total' => $total,
            'comentarios' => $comentarios
        ];
        echo json_encode($response); 
    }

    public function guardar_editar(){
        $codigo = $_POST['codigoAlmacen'];
        $mat = $_POST['material'];
        $cucop = $_POST['cucop'];
        $partidaPre = $_POST['partidaPresupuestal'];
        $unidad = $_POST['unidadMedida'];
        $cantidad = $_POST['cantidad'];
        $costoUni = $_POST['costo'];
        $subtotal = $_POST['subtotal'];
        $iva = $_POST['iva'];
        $total = $_POST['total'];
        $comentarios = $_POST['comentarios'];

        $connection = mysqli_connect('localhost', 'root', '', 'sellonogarantia');
        $query = "UPDATE sello SET cucop ='$cucop', partidaPresupuestal = '$partidaPre', 
                unidadMedida = '$unidad', cantidad = '$cantidad', costoUnitario = '$costoUni', 
                subtotal = '$subtotal', iva = '$iva', costoTotal ='$total', comentarios = '$comentarios', Fecha = NOW() WHERE codigoAlmacen = '$codigo' ";
        $result = mysqli_query($connection, $query);
            if(!$result){
                die("QUERY FAILED" . mysqli_error($connection));
            }
        $response = [
            'codigoAlmacen' =>$codigo,
            'cucop' =>$cucop,
            'partidaPresupuestal' =>$partidaPre,
            'unidadMedida' => $unidad,
            'cantidad' => $cantidad,
            'costo' => $costoUni,
            'iva' => $iva,
            'total' => $total,
            'comentarios' => $comentarios
            ];
        echo json_encode($response); 
    }
}
