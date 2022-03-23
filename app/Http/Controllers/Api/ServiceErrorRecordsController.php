<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\ServiceErrorRecords ;



//  @ for 服務異常處理紀錄
class ServiceErrorRecordsController extends Controller{
    

     // @ API Resource
    // 查詢 _　所有異常紀錄
    public function index(){  return ServiceErrorRecords::orderBy( 'created_at' , 'desc' )->get(); }

    // 查詢 _　單一異常紀錄
    public function show( $id ){  return ServiceErrorRecords::where( 'id' , $id )->first();  }

    // 新增 
    public function store( Request $request) {  return ServiceErrorRecords::create( $request->all() );  }

    // 更新 
    public function update( Request $request , $id ){

        ServiceErrorRecords::where( 'id' , $id )->first()->update( $request->all() );
        return '異常紀錄 _ 更新成功' ;

    }

    // 刪除 
    public function destroy( $id ){

        ServiceErrorRecords::where( 'id' , $id )->first()->delete();
        return '異常紀錄 _ 刪除成功' ;

    }

    // ----------------------------------------------------------

      // 查詢 _ 異常紀錄 ( 依照 : 特定服務 _ 類別、id )
      public function show_Service_Error_Records( $service_type , $service_id ){

        return ServiceErrorRecords::where( 'service_type' , $service_type )
                                    ->where( 'service_id' ,  $service_id ) 
                                    ->orderBy( 'created_at' , 'desc' ) 
                                    ->get();

    }





}
