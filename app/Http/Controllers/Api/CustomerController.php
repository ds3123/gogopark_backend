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

    // # 查詢 :

        // 特定客戶 ( 依 : 手機號碼 )
        public function show_By_Mobile( $mobile ){  return Customer::where( 'mobile_phone' , $mobile )->first();  }

        // 特定客戶 ( 依 : 身分證字號 )
        public function show_By_Id( $id ){ return Customer::where( 'id' , $id )->first(); }


        // 多個客戶 ( LIKE 模糊搜尋 ， 依 : 傳入參數 : 查詢欄位 與 查詢值 ，如 : 'id' & 身分證字號 或 'mobile_phone' & 手機號碼 )
        public function show_By_Param( $col , $param ){

           // 模糊搜尋、前 5 筆資料
           return Customer::with( 'pets' , 'customer_relation' )->where( $col , 'like' , '%'.$param.'%' )->offset(0)->take(5)->get() ;

        }

    // # 新增 :

        // 特定客戶 _ 關係人
        public function store_Relation( Request $request ){  return Customer_Relation::create( $request->all() ); }

    // # 更新 :

        // 特定客戶 _ 關係人 ( 依 : `customer_relation 主鍵` )
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

       $customer =  Customer::where( 'id' , $id )->first() ;
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

    // 所有客戶及其寵物
    public function show_Customers_Pets(){

       $cus_pet = Customer::with( 'pets' )->orderBy( 'created_at' , 'desc' )->get();
       $cus_pet = Customer::with( 'pets' )->orderBy( 'created_at' , 'desc' )->get();
       // $cus_pet = Customer::with( 'pets' )->get() ;
       return $cus_pet ? $cus_pet : [] ;

    }


    // 部分 _ 客戶，及其關係人、寵物
    public function show_Customers_Relatives_Pets( $is_Archive , $data_Num = 50 ){

      $cus_relative_pet = Customer::with( 'pets' , 'customer_relation' )
                                    ->limit( $data_Num )
                                    ->where( 'is_archive' , $is_Archive )
                                    ->orderBy( 'customer_id' , 'desc' )   // 前端以 ( created_at ) 排序
                                    ->get() ;

      return $cus_relative_pet ;

    }


    // 所有 _ 客戶，及其關係人、寵物
    public function show_All_Customers_Relatives_Pets( $is_Archive ){

      $cus_relative_pet = Customer::with( 'pets' , 'customer_relation' )
                                    ->where( 'is_archive' , $is_Archive )
                                    ->orderBy( 'customer_id' , 'desc' )   // 前端以 ( created_at ) 排序
                                    ->get() ;

      return $cus_relative_pet ;

    }



}
