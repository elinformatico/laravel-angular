<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class Genres extends Controller
{
    public function getGenres(){

    	try{
    		$genres = DB::table('genres')
    		->get();

    		if(count($genres) > 0){
                return Response()->json(array('status' => 'success', 'genres' => $genres, 'msg' => 'Generos Obtenidos Satisfactoriamente.'));
            } else {
                return Response()->json(array('status' => 'error', 'msg'=>"No existen Generos registrados"));
            }

        }catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('msg'=>'Error de query al consultar los datos.','error'=>$e));
        }
    }
}
