<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Species ;   // 匯入 : 品種 & 價錢 Model

class SpeciesController extends Controller{

    public function index(){ return Species::all();  }

    public function show( $species_id ){  return Species::findOrFail( $species_id );  }

    public function store( Request $request ){

        Species::create( $request->all() );
        return '品種資料新增成功' ;

    }

    public function update( Request $request , $species_id ){

        Species::findOrFail( $species_id )->update( $request->all() );
        return '品種資料新增成功' ;

    }

    public function destroy( $species_id ){

        Species::findOrFail( $species_id )->delete();
        return '品種資料刪除成功' ;

    }

    /* 自訂查詢 ----------------------------------------------------------------------------- */
    public function show_By_Species( $speciesName ){
       return Species::where( 'species_name' , $speciesName )->first();
    }


}
