<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Time_Records ;     // 匯入 Time_Records  Model


class TimeRecordsController extends Controller{

    public function index(){  return Time_Records::get(); }

    public function show( $id ){  return Time_Records::findOrFail( $id ) ;  }

    public function store( Request $request ) {

        Time_Records::create( $request->all() );
        return '時間紀錄 _ 新增成功' ;

    }

    public function update( Request $request, $id ) {

        Time_Records::findOrFail( $id )->update( $request->all());
        return '時間紀錄 _ 更新成功' ;

    }

    public function destroy( $id ){

        Time_Records::findOrFail( $id )->delete();
        return '時間紀錄 _ 刪除成功' ;

    }


    /* 自訂查詢 ----------------------------------------------------------------------------- */


    // 查詢 _ 依照 : 服務單資料表 ID
    public function show_By_ServiceType_ServiceId(  $ServiceType , $ServiceId  ){

        return Time_Records::where( 'service_table_id' , $ServiceId )->where( 'service_type' , $ServiceType )->get();

    }


    // 查詢 _ 依照 : 服務單資料表 ID 、時間按鈕名稱
    public function show_By_ServiceId_ButtonName( $ServiceId , $ButtonName ){

        return Time_Records::where( 'service_table_id' , $ServiceId )->where( 'button_name' , $ButtonName)->first();

    }

    // 刪除 _ 依照 : 服務單資料表 ID 、時間按鈕名稱
    public function destroy_By_ServiceId_ButtonName( $ServiceId , $ButtonName ){

        Time_Records::where( 'service_table_id' , $ServiceId )->where( 'button_name' , $ButtonName)->delete();

        return '時間紀錄 _ 刪除成功' ;

    }



}

