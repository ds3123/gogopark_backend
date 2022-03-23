<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CustomerConfirm ;

// @ 美容師請櫃台向客戶確認 ( 加價 ) 紀錄
class CustomerConfirmController extends Controller {

    public function index(){ return CustomerConfirm::orderBy('id','desc')->get(); }

    public function show($id) { return CustomerConfirm::findOrFail($id) ;  }

    public function store(Request $request) {

        CustomerConfirm::create( $request->all() ) ;
        return '新增 _ 客戶確認紀錄成功' ;

    }

    public function update(Request $request, $id) {

        CustomerConfirm::findOrFail( $id )->update( $request->all() ) ;
        return '更新 _ 客戶確認紀錄成功' ;

    }

    public function destroy($id) {

        CustomerConfirm::findOrFail( $id )->delete();
        return '刪除 _ 客戶確認紀錄成功' ;

    }

    // ---------------------------------------------

    // 依 _ 服務/確認日期 查詢
    public function show_By_Service_Date( $serviceDate ){

       return CustomerConfirm::with( 'customer' , 'pet' )->where( 'service_date' , $serviceDate )->get() ;

    }


    // 依 _ 服務類型( 基礎、洗澡、美容 ) + 服務單 id 查詢
    public function show_By_Service_Type_Id( $serviceType , $serviceId ){

        return CustomerConfirm::with('customer' , 'pet' )->where('service_type' , $serviceType )->where('service_id' , $serviceId )->get() ;

    }





}
