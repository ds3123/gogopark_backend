<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Beauty ;   // 匯入 : 美容 Model


class BeautyController extends Controller{

    public function index(){ return Beauty::get() ; }

    public function show( $beauty_id ){ return Beauty::findOrFail( $beauty_id ); }

    public function store( Request $request ){

        $id = Beauty::create( $request->all() )->beauty_id ;

        return $id ;  // 回傳 : 所新增資料的 id

    }

    public function update( Request $request , $beauty_id ){

        Beauty::findOrFail( $beauty_id )->update( $request->all() );
        return '美容單更新成功';

    }

    public function destroy( $beauty_id ){

        Beauty::findOrFail( $beauty_id )->delete();
        return '洗澡單刪除成功' ;

    }

   /* 自訂查詢 ----------------------------------------------------------------------------- */

    // 查詢 : 所有 _ 美容單 + 客戶 + 寵物
    public function show_With_Cus_Pet(){  return Beauty::with('customer' , 'pet' )->get() ; }

    // 查詢 : 單一 _ 美容單 + 客戶 + 寵物
    public function show_Single_With_Cus_Pet( $beauty_id ){  return Beauty::with('customer' , 'pet' )->findOrFail( $beauty_id ) ; }

    // 查詢 : 特定日期，美容單所已使用 Q 碼 (s)
    public function show_Date_Qcode( $date ){

        $data   = Beauty::where( 'service_date' , $date )->get() ;
        $q_code = array();
        foreach( $data  as $obj ){ $q_code[] = $obj->q_code ; }

        return count( $q_code ) > 0 ? $q_code : [] ;

    }

    // 查詢 : 特定客戶身分證字號，所有美容單紀錄
    public function show_Customer_ID( $customerID ){

        return Beauty::with( "customer" , "pet" )
                       ->where( 'customer_id' , $customerID  )
                       ->get() ;

    }

    // 查詢美容單，相對應的 : 寵物美容消費紀錄
    public function show_Pet( $pet_Serial , $type ){

        return Beauty::where( 'pet_id' , $pet_Serial )
                      ->where( 'payment_type' , $type )
                      ->get() ;

    }



    
   // 查詢美容單，相對應的 : 寵物美容消費紀錄
   public function show_Pet_Records( $pet_Serial ){

        return Beauty::with( "customer" , "pet" )
                     ->where( 'pet_id' , $pet_Serial )
                     ->get() ;

   }





    // 更新 ~

    // 更新 : 特定欄位
    public function update_Column( $beauty_id , $column , $value ){

        Beauty::findOrFail( $beauty_id )->update( [ $column => $value ] );

    }


}
