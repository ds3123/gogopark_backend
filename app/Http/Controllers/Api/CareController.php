<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Care ;


// @ 安親單
class CareController extends Controller {

    public function index() { return Care::orderBy('id' , 'desc')->get() ;}

    public function show($id) { return Care::findOrFail( $id ) ; }

    public function store(Request $request) {

        Care::create( $request->all() ) ;
        return '新增 _ 安親成功' ;

    }

    public function update(Request $request, $id) {

        Care::findOrFail( $id )->update( $request->all() ) ;
        return '更新 _ 安親成功' ;

    }

    public function destroy($id) {

        Care::findOrFail( $id )->delete();
        return '刪除 _ 安親成功' ;

    }

    // --------------------------------------------------------------------------

    // 查詢 : 所有 _ 安親 + 客戶 + 客戶關係人 + 寵物
    public function show_With_Cus_Relative_Pet( $is_Archive ){

        return Care::with('customer' , 'customer_relative' , 'pet' )
                     ->where( 'is_archive' , $is_Archive )
                     ->get() ;

    }

    // 查詢 : 特定客戶身分證字號，所有安親紀錄
    public function show_Customer_ID( $customerID ){

        return Care::with( "customer" , "pet" )
                    ->where( 'customer_id' , $customerID  )
                    ->get() ;

    }

    // 查詢安親單，相對應的 : 安親消費紀錄
    public function show_Pet_Records( $pet_Serial ){

         return Care::where( 'pet_id' , $pet_Serial )
                     ->get() ;

    }


}
