<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class ControladorPrueba extends Controller
{
    public function getMessage(){

		try{
            $movies = DB::table('movies')->get();

	    return Response()->json(array('movies'=>'', 'movies' => $movies));

        }catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('msg'=>'Error de query al consultar los datos.','error'=>$e));
        }
    }
}
