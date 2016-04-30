<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class MoviesController extends Controller
{
    public function getMovies(){

    	try{
            $movies = DB::table('movies')
            ->select(
                'mov_id AS idMovie',
                'mov_title AS title',
                'mov_dir_id AS idDirector',
                'mov_year AS year',
                'mov_released AS released',
                'mov_runtime AS runtime',
                'mov_synopsis AS synopsis',
                'mov_poster AS image',
                'mov_language AS language',
                'mov_awards AS awards'
            )
            ->where('mov_poster', '<>', 'N/A')
            ->where('mov_poster', '<>', '')
            ->skip(0)->take(100)
            ->get();

	    	return Response()->json(array('status' => 'success', 'movies' => $movies, 'msg' => 'Peliculas Obtenidas exitosamente.'));

        }catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('status' => 'error', 'msg'=>'Error de query al consultar los datos.','error'=>$e));
        }
    }
}
