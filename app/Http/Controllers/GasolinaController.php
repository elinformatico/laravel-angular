<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class GasolinaController extends Controller
{
    public function registrarGasolina(){

    	try {

    		$insertId = DB::table('registro_gasolina')->insertGetId(
			    [
			    	'rgas_litros'       => $_REQUEST['litros'], 
			    	'rgas_tipoGasolina' => $_REQUEST['tipoGasolina'],
			    	'rgas_monto'        => $_REQUEST['montoGasolina'],
			    	'rgas_kilometraje'  => $_REQUEST['kilometraje'],
			    	'rgas_fecha'        => DB::raw('NOW()'),
			    ]
			);

			return Response()->json(array('status' => 'success', 'msg' => "El registro fue almacenado exitosamente con el ID [{$insertId}]: "));
            //return response('Unauthorized.', 401);

    	} catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('status' => 'error', 'msg'=>'Error al ejecutar el query.','error'=>$e));
        }
    }

    public function getUltimoKilometraje()
    {
        try {

            $maximoKilometraje = DB::table('registro_gasolina')->max('rgas_kilometraje');

            return Response()->json(array('status' => 'success', 'kilometraje' => $maximoKilometraje, 'msg' => 'Se obtuvo el máximo Kilometraje registrado'));
            //return response('Unauthorized.', 401);

        } catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('status' => 'error', 'msg'=>'Error al ejecutar el query.','error'=>$e));
        }
    }

    public function getUltimoRegistroGasolina()
    {

        try {

            $maximoKilometraje = DB::table('registro_gasolina')->max('rgas_kilometraje');

            return Response()->json(array('status' => 'success', 'kilometraje' => $maximoKilometraje, 'msg' => 'Se obtuvo el máximo Kilometraje registrado'));
            //return response('Unauthorized.', 401);

        } catch(\Illuminate\Database\QueryException $e){
            return Response()->json(array('status' => 'error', 'msg'=>'Error al ejecutar el query.','error'=>$e));
        }

    }
}
