<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class ControladorPrueba extends Controller
{
    public function getMessage(){

	try{
            $usuarios = DB::table('users')
	    ->get();

	    return Response()->json(array('msg'=>'Vientos Huracanados. Esta es mi primera API funcional free', 'usuarios' => $usuarios));

        }catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('msg'=>'Error de query al consultar los datos.','error'=>$e));
        }
    }
}
