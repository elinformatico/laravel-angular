<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class Directors extends Controller
{
    public function getDirectors(){

    	try{
    		$directors = DB::table('directors')
    		->get();

    		if(count($directors) > 0){
                return Response()->json(array('status' => 'success', 'directors' => $directors, 'msg' => 'Directores Obtenidos Satisfactoriamente.'));
            } else {
                return Response()->json(array('status' => 'error', 'msg'=>"No existen Directores Registrados"));
            }

        }catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('msg'=>'Error de query al consultar los datos.','error'=>$e));
        }
    }
}
