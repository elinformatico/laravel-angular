<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use File;
use DB;

class ImportMoviesJsonController extends Controller
{
    public function import(){

        try {

            # $filename = "short.movies.json";
            $filename = "movies.json";

            $contents = File::get(base_path() . "\\resources\\assets\\jsonfiles\\{$filename}");
            $jsonData = (object)json_decode($contents, true);
            
            foreach ($jsonData AS $row) {
                
                $movieId = DB::table('movies')->where('mov_title', '=', $row['Title'])->first();
                $subObjects = explode(',', $row['Country']);

                foreach ($subObjects as $valueObject) {

                    $subRowId = DB::table('countries')->where('cty_name', '=', $valueObject)->first();              

                    $inserted = DB::table('movie_countries')
                    ->insert([
                        'mty_mov_id' => $movieId->mov_id,
                        'mty_cty_id' => $subRowId->cty_id
                    ]);
                }
            }

            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importMovieWrites(){

        try {
            # $filename = "short.movies.json";
            $filename = "movies.json";

            $contents = File::get(base_path() . "\\resources\\assets\\jsonfiles\\{$filename}");
            $jsonData = (object)json_decode($contents, true);
            
            foreach ($jsonData AS $row) {
                
                $movieId = DB::table('movies')->where('mov_title', '=', $row['Title'])->first();
                $subObjects = explode(',', $row['Writer']);

                foreach ($subObjects as $valueObject) {

                    $subRowId = DB::table('writers')->where('wrt_name', '=', $valueObject)->first();              

                    $inserted = DB::table('movie_writers')
                    ->insert([
                        'mvr_mov_id' => $movieId->mov_id,
                        'mvr_wrt_id' => $subRowId->wrt_id
                    ]);
                }
            }

            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importMovieActors(){

        try {

            # $filename = "short.movies.json";
            $filename = "movies.json";

            $contents = File::get(base_path() . "\\resources\\assets\\jsonfiles\\{$filename}");
            $jsonData = (object)json_decode($contents, true);
            
            foreach ($jsonData AS $row) {
                
                $movieId = DB::table('movies')->where('mov_title', '=', $row['Title'])->first();
                $subObjects = explode(',', $row['Actors']);

                foreach ($subObjects as $valueObject) {

                    $subRowId = DB::table('actors')->where('act_name', '=', $valueObject)->first();              

                    $inserted = DB::table('movie_actors')
                    ->insert([
                        'mva_mov_id' => $movieId->mov_id,
                        'mva_act_id' => $subRowId->act_id
                    ]);
                }
            }

            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importMovieGenres(){

        try {

            # $filename = "short.movies.json";
            $filename = "movies.json";

            $contents = File::get(base_path() . "\\resources\\assets\\jsonfiles\\{$filename}");
            $jsonData = (object)json_decode($contents, true);
            
            foreach ($jsonData AS $row) {
                
                $movieId = DB::table('movies')->where('mov_title', '=', $row['Title'])->first();
                $genres = explode(',', $row['Genre']);

                foreach ($genres as $genre) {

                    $generoId = DB::table('genres')->where('gre_name', '=', $genre)->first();              

                    $inserted = DB::table('movie_genres')
                    ->insert([
                        'mvg_mov_id' => $movieId->mov_id,
                        'mvg_gre_id' => $generoId->gre_id
                    ]);
                }
            }

            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importMovies(){

        try {

            # $filename = "short.movies.json";
            $filename = "movies.json";

            $contents = File::get(base_path() . "\\resources\\assets\\jsonfiles\\{$filename}");
            $jsonData = (object)json_decode($contents, true);
            
            foreach ($jsonData AS $row) {
                
                $movie = $row['Title'] . "\n";
                $director = $row['Director'];

                $directorId = DB::table('directors')
                ->select('dir_id AS director_id')
                ->where('dir_name', '=', $director)
                ->first();

                $directorId = $directorId->director_id;
                
                # Insertamos en la Table Movies
                $insertMovie = DB::table('movies')
                ->insert([
                    'mov_dir_id' => $directorId,
                    'mov_title' => $row['Title'],
                    'mov_year' => $row['Year'],
                    'mov_released' => $row['Released'],
                    'mov_runtime' => str_replace(' min', '', $row['Runtime']),
                    'mov_synopsis' => $row['Plot'],
                    'mov_poster' => $row['Poster'],
                    'mov_language' => $row['Language'],
                    'mov_awards' => $row['Awards']
                ]);
            }

            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importCountries(){

        try {
            # $filename = "short.movies.json";
            $filename = "movies.json";

            $contents = File::get(base_path() . "\\resources\\assets\\jsonfiles\\{$filename}");
            $jsonData = (object)json_decode($contents, true);
            
            foreach ($jsonData AS $row) {
                
                $countries = explode(',', $row['Country']);

                foreach($countries AS $country){
                    $findActor = DB::table('countries')->where('cty_name', '=', $country)->first();
                    if(!$findActor){
                        $insertActor = DB::table('countries')
                        ->insert([                          
                            'cty_name' => $country
                        ]);
                    }
                }
            }

            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importWrites(){

        try {
            # $filename = "short.movies.json";
            $filename = "movies.json";

            $contents = File::get(base_path() . "\\resources\\assets\\jsonfiles\\{$filename}");
            $jsonData = (object)json_decode($contents, true);
            
            foreach ($jsonData AS $row) {
                
                $writers = explode(',', $row['Writer']);

                foreach($writers AS $writer){
                    $findActor = DB::table('writers')->where('wrt_name', '=', $writer)->first();
                    if(!$findActor){
                        $insertActor = DB::table('writers')
                        ->insert([                          
                            'wrt_name' => $writer
                        ]);
                    }
                }
            }

            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importGenres(){

        try {

            # $filename = "short.movies.json";
            $filename = "movies.json";

            $contents = File::get(base_path() . "\\resources\\assets\\jsonfiles\\{$filename}");
            $jsonData = (object)json_decode($contents, true);
            
            foreach ($jsonData AS $row) {
                
                $generos = explode(',', $row['Genre']);

                foreach($generos AS $genero){
                    $findActor = DB::table('genres')->where('gre_name', '=', $genero)->first();
                    if(!$findActor){
                        $insertActor = DB::table('genres')
                        ->insert([                          
                            'gre_name' => $genero
                        ]);
                    }
                }
            }

            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importDirectors(){

        try {

            # $filename = "short.movies.json";
            $filename = "movies.json";

            $contents = File::get(base_path() . "\\resources\\assets\\jsonfiles\\{$filename}");
            $jsonData = (object)json_decode($contents, true);
            
            foreach ($jsonData AS $row) {
                
                $director = $row['Director'];

                $findDirector = DB::table('directors')->where('dir_name', '=', $director)->first();
                if(!$findDirector){
                    $insertActor = DB::table('directors')
                    ->insert([                          
                        'dir_name' => $director
                    ]);
                }
            }

            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importActors(){

        try {

            # $filename = "short.movies.json";
            $filename = "movies.json";

            $contents = File::get(base_path() . "\\resources\\assets\\jsonfiles\\{$filename}");
            $jsonData = (object)json_decode($contents, true);
            
            foreach ($jsonData AS $row) {
                
                $actors = explode(',', $row['Actors']);

                foreach($actors AS $actor){
                    $findActor = DB::table('actors')->where('act_name', '=', $actor)->first();
                    if(!$findActor){
                        $insertActor = DB::table('actors')
                        ->insert([                          
                            'act_name' => $actor
                        ]);
                    }
                }
            }
            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }
}
