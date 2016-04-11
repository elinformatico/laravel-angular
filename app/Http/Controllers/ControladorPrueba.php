<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ControladorPrueba extends Controller
{
    public function getMessage(){
    	return Response()->json(array('msg'=>'Vientos Huracanados. Esta es mi primera API funcional free','error'=>'No Aplica xD'));
    }
}
