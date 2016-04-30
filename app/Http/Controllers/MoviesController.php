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
                'mov_dir_id AS directorId',
                'dir_name AS director',
                'mov_year AS year',
                'mov_released AS released',
                'mov_runtime AS runtime',
                'mov_synopsis AS synopsis',
                'mov_poster AS image',
                'mov_language AS language',
                'mov_awards AS awards'
            )
            ->leftJoin('directors', 'mov_dir_id', '=', 'dir_id')
            ->where('mov_poster', '<>', 'N/A')
            ->where('mov_poster', '<>', '')
            ->skip(0)->take(100)
            ->get();

            $returnMovies = array();
            foreach ($movies AS $movie) {

                # $actors = $this->getActorMovies( $movie->idMovie )->getData();
                # $actors = ($actors->status == 'success') ? $actors->actors : array();

                # $gnres = $this->getGenresMovies( $movie->idMovie )->getData();
                # $gnres = ($gnres->status == 'success') ? $gnres->gnres : array();

                array_push($returnMovies, array(
                    'idMovie'    => $movie->idMovie,
                    'title'      => $movie->title,
                    'directorId' => $movie->directorId,
                    'director'   => $movie->director,
                    'year'       => $movie->year,
                    'released'   => $movie->released,
                    'runtime'    => $movie->runtime,
                    'synopsis'   => $movie->synopsis,
                    'image'      => $movie->image,
                    'language'   => $movie->language,
                    'awards'     => $movie->awards,
                    # 'actors'     => $actors,
                ));
            }

	    	return Response()->json(array('status' => 'success', 'movies' => $returnMovies, 'msg' => 'Peliculas Obtenidas exitosamente.'));

        }catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('status' => 'error', 'msg'=>'Error de query al consultar los datos.','error'=>$e));
        }
    }

    public function getActorByMovies( $movieId ){

        try{
            $actors = DB::table('actors')
            ->select(
                'act_id AS actorId',
                'act_name AS nombre'
            )
            ->leftJoin('movie_actors', 'act_id', '=', 'mva_act_id')
            ->where('mva_mov_id', '=', $movieId)
            ->get();

            if(count($actors) > 0){
                return Response()->json(array('status' => 'success', 'actors' => $actors, 'msg' => 'Actores Obtenidos Satisfactoriamente.'));
            } else {
                return Response()->json(array('status' => 'error', 'msg'=>"No existen actores para la Pelicula ID {$movieId}"));
            }

        } catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('status' => 'error', 'msg'=>'Error de query al consultar los datos.','error'=>$e));
        }
    }

    public function getMovieByActor( $actorId ){

        try {

            $actor = DB::table('actors')->select('act_name AS name')->where('act_id', '=', $actorId)->first();

            if(!$actor){
                return Response()->json(array('status' => 'error', 'msg'=>"El actor con el ID {$actorId} no existe"));
            }

            $movies = DB::table('movies')
            ->select(
                'mov_id AS movieId',
                'mov_title AS movie'
            )
            ->leftJoin('movie_actors', 'mov_id', '=', 'mva_mov_id')
            ->leftJoin('actors', 'mva_act_id', '=', 'act_id')
            ->where('mva_act_id', '=', $actorId)
            ->distinct()
            ->get();

            if(count($movies) > 0){
                return Response()->json(array(
                    'msg' => "El Actor [{$actor->name}] a participado en " . count($movies) . " peliculas." ,
                    'status' => 'success', 
                    'actor' => $actor->name, 
                    'movies' => $movies, 
                ));
            } else {
                return Response()->json(array('status' => 'error', 'msg'=>"El actor ID {$actorId} no tiene peliculas actuadas"));
            }

        } catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('status' => 'error', 'msg'=>'Error de query al consultar los datos.','error'=>$e));
        }
    }

    public function getGenresMovies( $movieId ){

        try{
            $genres = DB::table('gnres')
            ->leftJoin('movie_genres', 'gre_id', '=', 'mvg_gre_id')
            ->where('mvg_mov_id', '=', $movieId)
            ->get();

            if(count($genres) > 0){
                return Response()->json(array('status' => 'success', 'genres' => $genres, 'msg' => 'Relacion Pelicul - Genero Obtenidos Satisfactoriamente.'));
            } else {
                return Response()->json(array('status' => 'error', 'msg'=>"No existen generos para la Pelicula ID {$movieId}"));
            }

        } catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('status' => 'error', 'msg'=>'Error de query al consultar los datos.','error'=>$e));
        }
    }

    public function findMoviesByActor( $actorName, $actorId = 0 ){

    }
}
