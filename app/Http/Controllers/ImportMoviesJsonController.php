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
