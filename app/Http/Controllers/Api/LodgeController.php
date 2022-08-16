<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Lodge ;



class LodgeController extends Controller {

    public function index() { return Lodge::orderBy('id','desc')->get(); }

    public function show($id) { return Lodge::findOrFail( $id ) ; }

    public function store(Request $request) {

        Lodge::create( $request->all() ) ;
        return '新增 _ 住宿成功' ;

    }

    public function update(Request $request, $id) {

        Lodge::findOrFail( $id )->update( $request->all() ) ;
        return '更新 _ 住宿成功' ;

    }

    public function destroy($id) {

        Lodge::findOrFail( $id )->delete();
        return '刪除 _ 住宿成功' ;

    }

    // --------------------------------------------------------------------------------------


    // 查詢 : 所有 _ 住宿 + 客戶 + 客戶關係人 + 寵物
    public function show_With_Cus_Relative_Pet( $is_Archive ){

        return Lodge::with('customer' , 'customer_relative' , 'pet' )
                     ->where( 'is_archive' , $is_Archive )
                     ->get() ;


    }

    // 查詢 : 特定客戶身分證字號，所有住宿紀錄
    public function show_Customer_ID( $customerID ){

        return Lodge::with( "customer" , "pet" )
                     ->where( 'customer_id' , $customerID  )
                     ->get() ;

    }


   // 查詢住宿單，相對應的 : 住宿消費紀錄
   public function show_Pet_Records( $pet_Serial ){

        return Lodge::with( "customer" , "pet" )
                    ->where( 'pet_id' , $pet_Serial )
                    ->get() ;

   }





}
