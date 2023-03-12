<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Basic ;     // 匯入 Basic Model


class BasicController extends Controller {

    public function index(){  return Basic::get();  }

    public function show( $basic_id ){  return Basic::findOrFail( $basic_id ) ; }

    public function store( Request $request ){

       Basic::create( $request->all() );
       return '基礎單新增成功' ;

    }

    public function update( Request $request , $basic_id ){

       Basic::findOrFail( $basic_id )->update( $request->all());
       return '基礎單更新成功' ;

    }

    public function destroy( $basic_id ) {

       Basic::findOrFail( $basic_id )->delete();
       return '基礎單刪除成功' ;

    }



    /* 自訂查詢 ----------------------------------------------------------------------------- */

    // 查詢 ~

    // 查詢 : 所有 _ 基礎單 + 客戶 + 寵物
    public function show_With_Cus_Pet(){

      return Basic::with('customer' , 'pet' )->get();

    }

    // 查詢 : 單一 _ 基礎單 + 客戶 + 寵物
    public function show_Single_With_Cus_Pet( $basic_id ){ return Basic::with('customer' , 'pet' )->findOrFail( $basic_id ) ; }

    // 僅 _ 查詢該基礎單，相對應的 _ 客戶
    public function show_Customer( $basic_id ){

       return Basic::find( $basic_id )->customer ;  //

       // return Basic::find($id)->customer()->first();
       // return Basic::findOrFail($id)->with('customer')->get();

    }



    // 查詢基礎單，相對應的 : 寵物基礎消費紀錄
    public function show_Pet( $pet_Serial , $type ){

        return Basic::where( 'pet_id' , $pet_Serial )
                      ->get() ;

    }




    // 查詢 : 特定日期，基礎單所已使用 Q 碼 (s)
    public function show_Date_Qcode( $date ){

      $data   = Basic::where( 'service_date' , $date )->get() ;
      $q_code = array();
      foreach( $data  as $obj ){ $q_code[] = $obj->q_code ; }

      return count( $q_code ) > 0 ? $q_code : [] ;

    }


    // 查詢 : 特定客戶身分證字號，所有基礎單紀錄
    public function show_Customer_ID( $customerID ){

        return Basic::with( "customer" , "pet" )
                     ->where( 'customer_id' , $customerID )
                     ->get() ;

    }


   // 查詢洗澡單，相對應的 : 寵物基礎消費紀錄
   public function show_Pet_Records( $pet_Serial ){

      return Basic::with( "customer" , "pet" )
                   ->orderBy( 'created_at' , 'desc' )    // 依 : 建檔日期  
                   ->where( 'pet_id' , $pet_Serial )
                   ->get() ;

  }




    // 更新 ~

    // 更新 : 特定欄位
    public function update_Column( $basic_id , $column , $value ){

       Basic::findOrFail( $basic_id )->update( [ $column => $value ] );

    }




}
