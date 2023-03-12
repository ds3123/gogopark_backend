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
    public function show_With_Cus_Relative_Pet( $account_id , $is_Archive , Request $request ){


        // 取得 _ 查詢字串參數值
        $search = $request->query( 'search' ) ;  // 搜尋關鍵字


        return Care::with( 'customer' , 'customer_relative' , 'pet' )
                     ->where( 'account_id' , $account_id )                                                  // < 按照店家 id >
                     ->where( 'is_archive' , $is_Archive )
                     // 視 '查詢關鍵字' 有無，決定是否加入以下查詢條件
                     ->when( isset( $search ) && $search !== '' , function( $query ) use ( $search , $account_id ){  
                                            
                        return $query->whereHas( 'customer' , function( $query ) use ( $search , $account_id  ){ 

                                            $query->where( 'account_id' , $account_id )                     // < 按照店家 id >
                                                  ->where( 'name' , 'like' , '%'.$search.'%' )              // 客戶：姓名
                                                  ->orWhere( 'id' , 'like' , '%'.$search.'%' )              // 客戶：身分證字號
                                                  ->orWhere( 'mobile_phone' , 'like' , '%'.$search.'%' ) ;  // 客戶：手機號碼

                                    })
                                    ->orWhereHas( 'pet' , function( $query ) use ( $search , $account_id ){ 

                                            $query->where( 'account_id' , $account_id )                     // < 按照店家 id >
                                                  ->where( 'name' , 'like' , '%'.$search.'%' )              // 寵物：名字
                                                  ->orWhere( 'species' , 'like' , '%'.$search.'%' )         // 寵物：品種
                                                  ->orWhere( 'serial' , 'like' , '%'.$search.'%' ) ;        // 寵物：序號

                                    }) ;       
                                
                     })
                     ->orderBy( 'created_at' , 'desc' )   
                     ->paginate( 10 ) ;

    }

    // 查詢 : 特定客戶身分證字號，所有安親紀錄
    public function show_Customer_ID( $customerID ){

        return Care::with( "customer" , "pet" )
                    ->where( 'customer_id' , $customerID  )
                    ->get() ;

    }

    // 查詢安親單，相對應的 : 安親消費紀錄
    public function show_Pet_Records( $pet_Serial ){

         return Care::with( "customer" , "pet" )
                     ->orderBy( 'created_at' , 'desc' )    // 依 : 建檔日期
                     ->where( 'pet_id' , $pet_Serial )
                     ->get() ;

    }


}
