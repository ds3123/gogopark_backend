<?php

namespace App\Http\Controllers\Api;


use Cache ;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Pet ;               // 匯入 : 寵物 Model
use App\Customer ;          // 匯入 : 客戶 Model
use App\Customer_Relation ; // 匯入 : 客戶_關係人 Model
use App\Basic ;             // 匯入 : 基礎單 Model


class CustomerController extends Controller{

    // @ API Resource
    // 查詢 _　所有客戶
    public function index(){  return Customer::get();  }

    // 查詢 _　單一客戶 ( 依照 _ 身分證字號 )
    public function show( $cus_id ){  return Customer::where( 'id' , $cus_id )->first();  }

    public function store( Request $request ){  return Customer::create( $request->all() );  }

    // 更改 _　單一客戶 ( 依照 _ 主鍵 )
    public function update( Request $request , $cus_id ){

      Customer::where( 'customer_id' , $cus_id )->first()->update( $request->all() );
      return '客戶更新成功' ;

    }

    // 刪除 _　單一客戶
    public function destroy( $id ){

      Customer::where( 'customer_id' , $id )->first()->delete();
      return '客戶刪除成功' ;

    }

    // @ 自訂函式 --------------------------------------------------------


    // 測試用，之後刪除 ( 2022.11.26 回傳 _ 物件，而非陣列 )
        public function show_Customer_Object(){


         $cus_relative_pet = Customer::with( [ 
            'pets'              => function( $query ){ $query->select( 'customer_id' , 'serial' , 'name' , 'species' , 'sex' , 'color' , 'birthday' , 'is_dead' , 'is_rejected'  ) ; } ,
            'customer_relation' => function( $query ){ $query->select( 'customer_id' , 'name' , 'tag'  , 'mobile_phone' , 'tel_phone' ,  'is_archive' ) ;  } 
         ])
                                    ->select(  'customer_id' , 'name' , 'id'  , 'mobile_phone' , 'address' , 'is_rejected' , 'created_at' )  // 僅查詢客戶特定欄位 
                                    ->where( 'account_id' , 1 )
                                    ->where( 'is_archive' , 0 )
                                    ->orderBy( 'customer_id' , 'desc' ) 
                                    ->paginate( 10 ) ;
                                 

           return $cus_relative_pet ; 

        }

    // # 查詢 :

        // 特定客戶 ( 依 : 手機號碼 )
        public function show_By_Mobile( $mobile ){  return Customer::where( 'mobile_phone' , $mobile )->first() ;  }

        // 特定客戶 ( 依 : 身分證字號 )
        public function show_By_Id( $id ){  return Customer::where( 'id' , $id )->first() ; }

        // 特定店家，依 : 傳入參數 : 查詢欄位 與 查詢值 ，如 : 'id' & 身分證字號 或 'mobile_phone' & 手機號碼 
        public function show_By_Param( $account_id , $col , $param ){

           // 模糊搜尋、前 5 筆資料
           return Customer::with( 'pets' , 'customer_relation' )
                            ->where( 'account_id' , $account_id  )
                            ->where( $col , 'like' , '%'.$param.'%' )
                            ->offset(0)
                            ->take(5)
                            ->get() ;

        }

        // 所有店家， 依 : 傳入參數 : 查詢欄位 與 查詢值 ，如 : 'id' & 身分證字號 或 'mobile_phone' & 手機號碼 
        public function show_By_Param_All( $col , $param ){

            // 精確搜尋
            return Customer::with( 'pets' , 'customer_relation' )
                             ->where( $col , $param )
                             ->get() ;
 
        }


    // # 新增 :

        // 特定客戶 _ 關係人
        public function store_Relation( Request $request ){  return Customer_Relation::create( $request->all() ); }

    // # 更新 :

        // 特定客戶 _ 關係人 ( 依 : `customer_relation 主鍵 ` )
        public function update_Relation( Request $request , $relation_id ){

           Customer_Relation::findOrFail( $relation_id )->update( $request->all() );
           return '客戶關係人更新成功' ;

        }

    // # 刪除 :

        //  特定客戶 _ 關係人 ( 依 : `customer_relation 主鍵` )
        public function destroy_Relation( $relation_id ){

           Customer_Relation::findOrFail( $relation_id )->delete();
           return '已刪除關係人' ;

        }

        // 特定客戶 _ 關係人 ( 依 : 客戶身分證字號 )
        public function destroy_Relation_By_Customer_Id( $cus_Id ){

           Customer_Relation::where( 'customer_id' , $cus_Id )->delete();
           return '已刪除關係人' ;

        }


    // @ 表單關聯 --------------------------------------------------------

    // # 一對多 : 某特定客戶，有 ~

    // 關係人(s)
    public function show_Relations( $id ){

       $customer = Customer::where( 'id' , $id )->first() ;
       return $customer ? $customer->customer_relation : [] ;  // 先檢查 _ 是否有該客戶

    }

    // 寵物(s)
    public function show_Pets( $id ){

        $customer = Customer::where( 'id' , $id )->first() ;
        return $customer ? $customer->pets : [] ;             // 先檢查 _ 是否有該客戶

    }

    // 關係人( s ) + 寵物( s )
    public function show_Relations_Pets( $id ){

       return Customer::with( 'pets' , 'customer_relation' )->where( 'id' , $id )->first();

    }

    // 基礎單(s)
    public function show_Basics( $id ){

       $customer = Customer::where( 'id' , $id )->first() ;
       return $customer ? $customer->basics : [] ;             // 先檢查 _ 是否有該客戶

    }

    // 洗澡單(s)
    public function show_Bathes( $id ){

      $customer = Customer::where( 'id' , $id )->first() ;
      return $customer ? $customer->bathes : [] ;             // 先檢查 _ 是否有該客戶

    }

    // 美容單(s)
    public function show_Beauties( $id ){

      $customer = Customer::where( 'id' , $id )->first() ;
      return $customer ? $customer->beauties : [] ;            // 先檢查 _ 是否有該客戶

    }

    // # 多對多 : 所有客戶，有 ~

    // 特定店家，所有客戶及其寵物
    public function show_Customers_Pets( $account_id = 1 ){

       $cus_pet = Customer::with( 'pets' )
                          ->where( 'account_id' , $account_id )   
                          ->orderBy( 'created_at' , 'desc' )
                          ->get();
     
       return $cus_pet ;

    }

    // 特定店家，被拒接 ( 狀態 : 通過、審核中 ) 的客戶及其寵物 
    public function show_Customers_On_Rejected( $account_id = 1 ){

      $cus_pet = Customer::with( 'pets' )
                         ->where( 'account_id' , $account_id )
                         ->where( function( $query ){

                               return $query->where( 'rejected_status' , "審核中"  ) 
                                            ->orWhere( 'rejected_status' , "通過"  ) ;
                           
                         })   
                         ->orderBy( 'rejected_status' , 'asc' )  // 以審核狀態排序 ( 審核中 -> 排在一起，並優先排在最上層 )
                         ->orderBy( 'updated_at' , 'desc' )      // 再以更新時間排序 
                         ->paginate( 10 );
    
      return $cus_pet ;

   }


    // 所有 _ 客戶，及其關係人、寵物
    public function show_All_Customers_Relatives_Pets( $account_id , $is_Archive , Request $request ){



           // 取得 _ 查詢字串參數值
           $search = $request->query( 'search' ) ;  
      
           // 查詢 _ 客戶、關係人、寵物資料 
           $cus_Relative_Pet = Customer::with([ 
           // dd( Customer::with([               // 配合以下 .toSql()，印出 sql 查詢式 

                                             'pets'              => function( $query ){ $query->select( 'account_id' , 'pet_id' , 'customer_id' , 'serial' , 'name' , 'species' , 'sex' , 'color' , 'note' , 'lodge_note' , 'private_note' , 'birthday' , 'is_dead' , 'is_rejected' , 'single_bath_price' , 'single_beauty_price' , 'month_bath_price' , 'month_beauty_price' ) ;  } ,
                                             'customer_relation' => function( $query ){ $query->select( 'customer_id' , 'name' , 'tag'  , 'mobile_phone' , 'tel_phone' , 'is_archive'  ) ; } 
                                          
                                          ])
                                          ->select( 'customer_id' , 'name' , 'id'  , 'mobile_phone' , 'address' , 'is_rejected' , 'created_at' )  // 僅查詢客戶特定欄位 
                                          ->where( 'is_archive' , $is_Archive )
                                          // 視 '查詢關鍵字' 有無，決定是否加入以下查詢條件
                                          ->when( isset( $search ) && $search !== '' , function( $query ) use ( $search , $account_id ){  
                                          
                                                return $query->where( 'account_id' , $account_id )                                   // < 按照店家 id >
                                                             ->where( 'name' , 'like' , $search.'%' )                                // 客戶：姓名 
                                                             ->orWhere( 'id' , $search )                                             // 客戶：身分證字號
                                                             ->orWhere( 'mobile_phone' , 'like' , $search.'%' )                      // 客戶：手機號碼
                                                             ->orWhereHas( 'customer_relation' , function( $query ) use ( $search , $account_id ){ 

                                                                  return $query->where( 'account_id' , $account_id )                 // < 按照店家 id >
                                                                               ->where( 'name' , 'like' , $search.'%' )              // 關係人：姓名
                                                                               ->orWhere( 'mobile_phone' , $search )                 // 關係人：手機號碼
                                                                               ->orWhere( 'tel_phone' , 'like' , '%'.$search.'%' ) ; // 關係人：家用電話
         
                                                               }) ;
                                                                  
                                          })
                                          ->orderBy( 'created_at' , 'desc' )    // 以 created_at 欄位，降冪排序  
                                          ->where( 'account_id' , $account_id ) // < 按照店家 id >
                                          // ->toSql() ) ;     // 配合以上 dd()，印出 sql 查詢式   
                                          ->paginate( 10 ) ;   // 每頁 10 筆資料              
                                           

            return $cus_Relative_Pet ;
            
          
    }



}
