<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class Countries extends Controller
{
    public function getCountries(){

    	try {

    		$countries = DB::table('countries')
	    	->get();

			if(count($countries) > 0){
	            return Response()->json(array('status' => 'success', 'countries' => $countries, 'msg' => 'Paises Obtenidos Satisfactoriamente.'));
	        } else {
	            return Response()->json(array('status' => 'error', 'msg'=>"No existen Paises registrados"));
	        }

        }catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('msg'=>'Error de query al consultar los datos.','error'=>$e));
        }
    }
}
