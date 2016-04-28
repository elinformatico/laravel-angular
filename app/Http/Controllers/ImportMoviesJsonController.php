<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use File;
use DB;

class ImportMoviesJsonController extends Controller
{
    public function import(){

        # Obtenemos las Peliculas Filtradas (Sin Repetir)
        $movies = $this->getJsonMovies()->getData();

        # return $this->importActors( $movies->filteredMovies );
        # return $this->importDirectors( $movies->filteredMovies );
        # return $this->importGenres( $movies->filteredMovies );
        # return $this->importWrites( $movies->filteredMovies );
        # return $this->importCountries( $movies->filteredMovies );
        # return $this->importMovies( $movies->filteredMovies );
        # -----------------------------------------------------------
        # return $this->importMovieGenres( $movies->filteredMovies );
        # return $this->importMovieActors( $movies->filteredMovies );
        # return $this->importMovieWrites( $movies->filteredMovies );
        # return $this->importMoviesCountries( $movies->filteredMovies );
    }

    private function getJsonMovies(){

        try {

            # $filename = "short.movies.json";
            $filename = "movies.json";

            $contents = File::get(base_path() . "\\resources\\assets\\jsonfiles\\{$filename}");
            $jsonData = (object)json_decode($contents, true);
            
            # print_r($jsonData);

            $movies = array();
            $filteredMovies = array();

            foreach ($jsonData AS $row) {
                if(!in_array( trim($row['Title']), $movies)){
                    $movies[] = trim($row['Title']);

                    array_push($filteredMovies, array(
                        'Title' => $row['Title'],
                        'Year' => $row['Year'],
                        'Rated' => $row['Rated'],
                        'Released' => $row['Released'],
                        'Runtime' => $row['Runtime'],
                        'Genre' => $row['Genre'],
                        'Director' => $row['Director'],
                        'Writer' => $row['Writer'],
                        'Actors' => $row['Actors'],
                        'Plot' => $row['Plot'],
                        'Language' => $row['Language'],
                        'Country' => $row['Country'],
                        'Awards' => $row['Awards'],
                        'Poster' => $row['Poster']
                    ));
                }
            }
            return Response()->json(array('status' => 'success', 'countMovies' => count($filteredMovies), 'filteredMovies' => $filteredMovies));

        } catch (Exception $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importMoviesCountries( $movies ){

        try {

            foreach ($movies AS $row) {

                $findMovie = DB::table('movies')->where('mov_title', '=', trim($row->Title))->first();
                $subObjects = explode(',', trim($row->Country));

                foreach ($subObjects as $valueObject) {
                    $subRowId = DB::table('countries')->where('cty_name', '=', trim($valueObject))->first();              
                    $inserted = DB::table('movie_countries')
                    ->insert([
                        'mty_mov_id' => $findMovie->mov_id,
                        'mty_cty_id' => $subRowId->cty_id
                    ]);
                }
            }
            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importMovieWrites( $movies ){

        try {
            foreach ($movies AS $row) {
                
                $findMovie = DB::table('movies')->where('mov_title', '=', trim($row->Title))->first();
                $subObjects = explode(',', trim($row->Writer));

                foreach ($subObjects as $valueObject) {

                    $subRowId = DB::table('writers')->where('wrt_name', '=', trim($valueObject))->first();              
                    $inserted = DB::table('movie_writers')
                    ->insert([
                        'mvr_mov_id' => $findMovie->mov_id,
                        'mvr_wrt_id' => $subRowId->wrt_id
                    ]);
                }
                
            }

            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importMovieActors( $movies ){

        try {
            foreach ($movies AS $row) {
                $findMovie = DB::table('movies')->where('mov_title', '=', trim($row->Title))->first();
                $subObjects = explode(',', trim($row->Actors));

                foreach ($subObjects as $valueObject) {
                    $subRowId = DB::table('actors')->where('act_name', '=', trim($valueObject))->first();              
                    $inserted = DB::table('movie_actors')
                    ->insert([
                        'mva_mov_id' => $findMovie->mov_id,
                        'mva_act_id' => $subRowId->act_id
                    ]);
                }
            }
            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importMovieGenres( $movies ){

        try {
            foreach ($movies AS $row) {
                $findMovie = DB::table('movies')->where('mov_title', '=', trim($row->Title))->first();
                $genres = explode(',', trim($row->Genre));

                foreach ($genres as $genre) {
                    $generoId = DB::table('genres')->where('gre_name', '=', trim($genre))->first();              
                    $inserted = DB::table('movie_genres')
                    ->insert([
                        'mvg_mov_id' => $findMovie->mov_id,
                        'mvg_gre_id' => $generoId->gre_id
                    ]);
                }
            }
            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importMovies( $movies ){

        try {
            
            foreach ($movies AS $row) {
                
                $movie = trim($row->Title);
                $director = trim($row->Director);
              
                $directorId = DB::table('directors')
                ->select('dir_id AS director_id')
                ->where('dir_name', '=', $director)
                ->first();

                $directorId = $directorId->director_id;

                # Insertamos en la Table Movies
                $insertMovie = DB::table('movies')
                ->insert([
                    'mov_dir_id'   => $directorId,
                    'mov_title'    => trim($row->Title),
                    'mov_year'     => trim($row->Year),
                    'mov_released' => trim($row->Released),
                    'mov_runtime'  => str_replace(' min', '', trim($row->Runtime)),
                    'mov_synopsis' => trim($row->Plot),
                    'mov_poster'   => trim($row->Poster),
                    'mov_language' => trim($row->Language),
                    'mov_awards'   => trim($row->Awards)
                ]);
            }

            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importCountries( $movies ){

        try {
          
            foreach ($movies AS $row) {
                $countries = explode(',', trim($row->Country));
                foreach($countries AS $country){
                    $findActor = DB::table('countries')->where('cty_name', '=', trim($country))->first();
                    if(!$findActor){
                        $insertActor = DB::table('countries')
                        ->insert([                          
                            'cty_name' => trim($country)
                        ]);
                    }
                }
            }
            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importWrites( $movies ){

        try {
            foreach ($movies AS $row) {
                $writers = explode(',', trim($row->Writer));
                foreach($writers AS $writer){
                    $findActor = DB::table('writers')->where('wrt_name', '=', trim($writer) )->first();
                    if(!$findActor){
                        $insertActor = DB::table('writers')
                        ->insert([                          
                            'wrt_name' => trim($writer)
                        ]);
                    }
                }
            }

            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importGenres( $movies ){

        try {
            foreach ($movies AS $row) {
                
                $generos = explode(',', trim($row->Genre));

                foreach($generos AS $genero){
                    $findActor = DB::table('genres')->where('gre_name', '=', trim($genero) )->first();
                    if(!$findActor){
                        $insertActor = DB::table('genres')
                        ->insert([                          
                            'gre_name' => trim($genero)
                        ]);
                    }
                }
            }

            return Response()->json(array('status' => 'success', 'msg' => 'Datos Exportados con Exito!'));

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }
    }

    private function importDirectors( $movies ){

        try {
            foreach ($movies AS $row) {                
                $director = trim($row->Director);

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

    private function importActors( $movies ){

        try {
            foreach ($movies AS $row) {
                $actors = explode(',', trim($row->Actors));
                foreach($actors AS $actor){
                    $findActor = DB::table('actors')->where('act_name', '=', trim($actor) )->first();
                    if(!$findActor){
                        $insertActor = DB::table('actors')
                        ->insert([                          
                            'act_name' => trim($actor)
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
