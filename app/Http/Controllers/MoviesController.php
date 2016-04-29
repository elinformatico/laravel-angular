<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class MoviesController extends Controller
{
    public function getMovies(){

    	try{
            $movies = DB::table('movies')->skip(0)->take(50)->get();
	    	return Response()->json(array('status' => 'success', 'movies' => $movies, 'msg' => 'Peliculas Obtenidas exitosamente.'));

        }catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('status' => 'error', 'msg'=>'Error de query al consultar los datos.','error'=>$e));
        }
    }
}
