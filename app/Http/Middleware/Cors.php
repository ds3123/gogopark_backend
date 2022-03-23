<?php

namespace App\Http\Middleware;

use Closure;

/*
 *
 * for 同源政策 Header 設定
 *
 */


class Cors{


    public function handle( $request , Closure $next ){

       return $next( $request )->header( 'Access-Control-Allow-Origin' , '*' )
                               ->header( 'Access-Control-Allow-Methods' , 'GET, POST, PUT, PATCH, DELETE ,OPTIONS' )
                               ->header( 'Access-Control-Allow-Headers' , 'Content-Type, Authorizations' )
                               ->header( 'Content-Type' , 'application/json' ) ;
              
    }


}
