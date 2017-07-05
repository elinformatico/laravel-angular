<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class GasolinaController extends Controller
{
    public function registrarGasolina(){

    	try {

    		DB::table('registro_gasolina')->insert(
			    [
			    	'rgas_litros'       => $_REQUEST['litros'], 
			    	'rgas_tipoGasolina' => $_REQUEST['tipoGasolina'],
			    	'rgas_monto'        => $_REQUEST['montoGasolina'],
			    	'rgas_kilometraje'  => $_REQUEST['kilometraje'],
			    	'rgas_fecha'        => DB::raw('NOW()'),
			    ]
			);

			return Response()->json(array('status' => 'success', 'msg' => 'El registro fue almacenado exitosamente'));

    	} catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('status' => 'error', 'msg'=>'Error al ejecutar el query.','error'=>$e));
        }

    }
}
