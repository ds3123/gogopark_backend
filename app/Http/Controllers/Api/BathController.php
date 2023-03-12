<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Bath ;  // 匯入 : 洗澡 Model


class BathController extends Controller {

    public function index(){ return Bath::get() ; }

    public function show( $bath_id ){  return Bath::findOrFail( $bath_id ) ; }

    public function store( Request $request ){

       $id = Bath::create( $request->all() )->bath_id ;

       return $id ;  // 回傳 : 所新增資料的 id

    }

    public function update( Request $request , $bath_id ){

        Bath::findOrFail( $bath_id )->update( $request->all() );
        return '洗澡單更新成功' ;

    }

    public function destroy( $bath_id ){

        Bath::findOrFail( $bath_id )->delete();
        return '洗澡單刪除成功';

    }

    /* 自訂查詢 ----------------------------------------------------------------------------- */

    // 查詢 : 所有 _ 洗澡單 + 客戶 + 寵物
    public function show_With_Cus_Pet(){  return Bath::with('customer' , 'pet' )->get() ; }

    // 查詢 : 單一 _ 洗澡單 + 客戶 + 寵物
    public function show_Single_With_Cus_Pet( $bath_id ){  return Bath::with('customer' , 'pet' )->findOrFail( $bath_id ) ; }

    // 查詢 : 特定日期，洗澡單所已使用 Q 碼 (s)
    public function show_Date_Qcode( $date ){

        $data   = Bath::where( 'service_date' , $date )->get() ;
        $q_code = array() ;
        foreach( $data  as $obj ){ $q_code[] = $obj->q_code ; }

        return count( $q_code ) > 0 ? $q_code : [] ;

    }

    // 查詢 : 特定客戶身分證字號，所有洗澡單紀錄 ( 判斷 _ 是否有洗澡單紀錄，以確認是否為 : "初次洗澡客戶" )
    public function show_Customer_ID( $customerID ){

       return Bath::with( "customer" , "pet" )
                    ->where( 'customer_id' , $customerID  )
                    ->get() ;

    }


    // 查詢洗澡單，相對應的 : 寵物洗澡消費紀錄
    public function show_Pet_Records( $pet_Serial ){

        return Bath::with( "customer" , "pet" )
                     ->orderBy( 'created_at' , 'desc' )    // 依 : 建檔日期  
                     ->where( 'pet_id' , $pet_Serial )
                     ->get() ;

    }


    // 查詢洗澡單，相對應的 : 寵物洗澡消費紀錄
    public function show_Pet( $pet_Serial , $type ){

        return Bath::where( 'pet_id' , $pet_Serial )
                     ->where( 'payment_type' , $type )
                     ->get() ;

    }


    // 更新 ~

    // 更新 : 特定欄位
    public function update_Column( $bath_id , $column , $value ){

        Bath::findOrFail( $bath_id )->update( [ $column => $value ] );

    }



}
