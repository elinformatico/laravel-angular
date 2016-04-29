<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class CountriesController extends Controller
{
   public function getCountries(){

   		try{
           	
           	$countries = DB::table('countries')->get();
	    	return Response()->json(array('countries'=>'', 'countries' => $countries));

        }catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('msg'=>'Error de query al consultar los datos.','error'=>$e));
        }
   }
}
