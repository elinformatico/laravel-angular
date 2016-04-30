<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class Writers extends Controller
{
    public function getWriters(){

    	try{
    		$writers = DB::table('writers')
    		->get();

    		if(count($writers) > 0){
                return Response()->json(array('status' => 'success', 'writers' => $writers, 'msg' => 'Writers Obtenidos Satisfactoriamente.'));
            } else {
                return Response()->json(array('status' => 'error', 'msg'=>"No existen Escritores registrados"));
            }

        }catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('msg'=>'Error de query al consultar los datos.','error'=>$e));
        }
    }
}
