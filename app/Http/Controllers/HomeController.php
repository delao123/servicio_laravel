<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    public function show(Request $request){
        $herramientas = DB::table('catalogo_herramienta')->pluck('material');
        $papelerias = DB:: table('catalogo_papeleria')->pluck('material');
        
        return view('welcome')->with([
            'herramientas' => $herramientas,
            'papelerias' => $papelerias
        ]);
    }
}
