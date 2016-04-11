<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Http\Response;

class allowOriginMobie implements Middleware
{
     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        
        $hosts = array( 0 => 'http://noehdez.info', 1 => 'http://xdevme.com');
        
        $clave = '';
        if(isset($_SERVER['HTTP_ORIGIN'])){
            $clave = array_search( $_SERVER['HTTP_ORIGIN'], $hosts);

            if($clave === 0){
                header("Access-Control-Allow-Origin: http://noehdez.info");
            }else if($clave === 1){
                header("Access-Control-Allow-Origin: http://xdevme.com");
            }
        }else{
            header("Access-Control-Allow-Origin: http://noehdez.info");
        }
        
        header('Access-Control-Allow-Credentials: false');
        header('Access-Control-Max-Age: 86400');
        // ALLOW OPTIONS METHOD
        $headers = [
            'Access-Control-Allow-Headers'=> 'Content-Type, Accept, X-Requested-With',
            // 'Access-Control-Allow-Headers'=> 'Content-Type, Accept, Authorization, X-Requested-With',
            'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE'
        ];
        if($request->getMethod() == "OPTIONS") {
            // The client-side application can set only headers allowed in Access-Control-Allow-Headers
            return Response::make('OK', 200, $headers);
        }

        $response = $next($request);
        foreach($headers as $key => $value) 
            $response->header($key, $value);
        return $response;
    }
}
