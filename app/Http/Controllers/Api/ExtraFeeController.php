<?php

namespace App\Http\Controllers\Api;

use Cache ;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Extra_Fee ;  // 匯入 : 加價單 Model


// 加價單
class ExtraFeeController extends Controller{

    // @ API Resource

    // 查詢 _ 所有加價單　
    public function index(){  return Extra_Fee::get();  }

    // 查詢 _　單一加價單
    public function show( $extra_fee_id ){  return Extra_Fee::where( 'extra_fee_id' , $extra_fee_id )->first();  }

    // 新增 
    public function store( Request $request ){  return Extra_Fee::create( $request->all() ) ;  }

    // 更改 _　單一加價單 ( 依照 _ 主鍵 )
    public function update( Request $request , $extra_fee_id ){

      Extra_Fee::where( 'extra_fee_id' , $extra_fee_id )->first()->update( $request->all() ) ;

      return '加價單更新成功' ;

    }

    // 刪除 _　單一加價單
    public function destroy( $extra_fee_id ){

      Extra_Fee::where( 'extra_fee_id' , $extra_fee_id )->first()->delete() ;
      
      return '加價單刪除成功' ;

    }

    // @ 自訂函式 --------------------------------------------------------


    // 查詢 : 取得 _ 特定 [ 付款日期 ] : 所有加價單
    public function show_ExtraFees_By_Paymentdate( $account_id = 1 , $date ){

        return Extra_Fee::with( 'basic' , 'bath' , 'beauty' )
                        ->where( 'account_id' , $account_id )
                        ->where( 'payment_date' , $date )
                        ->get() ;
    
    }


}