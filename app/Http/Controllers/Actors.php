<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class Actors extends Controller
{
    public function getActors(){

    	try{
	    	$actors = DB::table('actors')
	    	->get();

			if(count($actors) > 0){
	            return Response()->json(array('status' => 'success', 'actors' => $actors, 'msg' => 'Actores Obtenidos Satisfactoriamente.'));
	        } else {
	            return Response()->json(array('status' => 'error', 'msg'=>"No existen Actores registrados"));
	        }

        }catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('msg'=>'Error de query al consultar los datos.','error'=>$e));
        }
    }
}
