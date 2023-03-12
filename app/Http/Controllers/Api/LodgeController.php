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
    public function show_With_Cus_Relative_Pet( $account_id = 1 , $is_Archive , Request $request ){

        // 取得 _ 查詢字串參數值
        $search = $request->query( 'search' ) ;  // 搜尋關鍵字
        $date_1 = $request->query( 'date_1' ) ;  // 篩選 _ 住宿開始日期
        $date_2 = $request->query( 'date_2' ) ;  // 篩選 _ 住宿結束日期
  

        return Lodge::with('customer' , 'customer_relative' , 'pet' )
                     ->where( 'account_id' , $account_id )                                                 // < 按照店家 id >
                     ->where( 'is_archive' , $is_Archive )
                     // 視 '查詢關鍵字' 有無，決定是否加入以下查詢條件
                     ->when( isset( $search ) && $search !== '' , function( $query ) use ( $search , $account_id ){  
                                          
                        return $query->where( 'account_id' , $account_id )                                 // < 按照店家 id >
                                     ->where( 'room_type' , 'like' , '%'.$search.'%' )                     // 房型  
                                     ->orWhere( 'room_number' , 'like' , '%'.$search.'%' )                 // 房號
                                     ->orWhereHas( 'customer' , function( $query ) use ( $search , $account_id ){ 

                                            $query->where( 'account_id' , $account_id )                    // < 按照店家 id >
                                                  ->where( 'name' , 'like' , '%'.$search.'%' )             // 客戶：姓名
                                                  ->orWhere( 'id' , 'like' , '%'.$search.'%' )             // 客戶：身分證字號
                                                  ->orWhere( 'mobile_phone' , 'like' , '%'.$search.'%' ) ; // 客戶：手機號碼

                                       })
                                     ->orWhereHas( 'pet' , function( $query ) use ( $search , $account_id ){ 

                                            $query->where( 'account_id' , $account_id )                   // < 按照店家 id >
                                                  ->where( 'name' , 'like' , '%'.$search.'%' )            // 寵物：名字
                                                  ->orWhere( 'species' , 'like' , '%'.$search.'%' )       // 寵物：品種
                                                  ->orWhere( 'serial' , 'like' , '%'.$search.'%' ) ;      // 寵物：序號

                                     }) ;  
                                          
                     })
                     // 視 '篩選 _ 住宿開始日期 與 住宿結束日期' 有無，決定是否加入以下查詢條件
                     ->when( ( isset( $date_1 ) && isset( $date_2 ) ) && ( $date_1 !== '' && $date_2 !== '' ) , function( $query ) use ( $date_1 , $date_2 ){  
                                      
                        return $query->where( 'start_date' , '>=' , $date_1 )                              // 住宿 : 開始日期
                                     ->where( 'end_date' , '<=' , $date_2 ) ;                              // 住宿 : 結束日期
                   
                     })
                     ->orderBy( 'created_at' , 'desc' )   
                     ->paginate( 10 ) ;


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
                    ->orderBy( 'created_at' , 'desc' )    // 依 : 建檔日期
                    ->where( 'pet_id' , $pet_Serial )
                    ->get() ;

   }





}
