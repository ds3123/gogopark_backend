<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Plan ;


// @ 方案 ( Ex. 包月洗澡、包月美容 ... )
class PlanController extends Controller {

    public function index(){  return Plan::orderBy('id','desc')->get() ; }
    public function show($id) {  return Plan::findOrFail( $id ) ;}

    public function store(Request $request) {

        Plan::create( $request->all() );
        return '新增 _ 方案資料成功' ;

    }

    public function update(Request $request, $id) {

        Plan::findOrFail( $id )->update( $request->all() ) ;
        return '更新 _ 方案資料成功' ;

    }

    public function destroy($id){

        Plan::findOrFail( $id )->delete();
        return '刪除 _ 方案資料成功' ;

    }

    // -----------------------------------------------------------------------------

    // 查詢 _ 所有 : 方案 + 客戶資料 + 寵物品種資料 + 方案使用紀錄
    public function show_All_Plans_With_Customer_PetSpecies_PlanUsedRecords( $account_id , Request $request ){

    
        // 取得 _ 查詢字串參數值
        $search = $request->query( 'search' ) ;  // 搜尋關鍵字


        return Plan::with( 'customer' , 'customer_relative' , 'custom_plan'  , 'pet' , 'pet_species' , 'plan_used_records' )
                    ->where( 'account_id' , $account_id )                                                  // < 按照店家 id >
                    // 視 '查詢關鍵字' 有無，決定是否加入以下查詢條件
                    ->when( isset( $search ) && $search !== '' , function( $query ) use ( $search , $account_id  ){  
                                                
                        return $query->where( 'account_id' , $account_id )                                 // < 按照店家 id >
                                     ->where( 'plan_type' , 'like' , '%'.$search.'%' )                     // 方案 : 類型 / 名稱  
                                     ->orWhereHas( 'customer' , function( $query ) use ( $search , $account_id  ){ 

                                            $query->where( 'account_id' , $account_id )                    // < 按照店家 id >
                                                  ->where( 'name' , 'like' , '%'.$search.'%' )             // 客戶：姓名
                                                  ->orWhere( 'id' , 'like' , '%'.$search.'%' )             // 客戶：身分證字號
                                                  ->orWhere( 'mobile_phone' , 'like' , '%'.$search.'%' ) ; // 客戶：手機號碼

                                    })
                                    ->orWhereHas( 'pet' , function( $query ) use ( $search , $account_id  ){ 

                                            $query->where( 'account_id' , $account_id )                    // < 按照店家 id >
                                                  ->where( 'name' , 'like' , '%'.$search.'%' )             // 寵物：名字
                                                  ->orWhere( 'species' , 'like' , '%'.$search.'%' )        // 寵物：品種
                                                  ->orWhere( 'serial' , 'like' , '%'.$search.'%' ) ;       // 寵物：序號

                                    }) ;       
                                    
                    })
                    ->orderBy( 'id' , 'desc' )
                    ->limit( 100 )                                                                          // 方案限制在 100 筆 2023.02.22
                    ->get()
                    ->paginate( 10 ) ;

    }

    // 查詢 _ 部分 : 方案 + 客戶資料 + 寵物品種資料 + 方案使用紀錄
    public function show_Plans_With_Customer_PetSpecies_PlanUsedRecords( $account_id = 1 , $data_Num = 50 ){

        return Plan::with( 'customer' , 'customer_relative' ,
                            'custom_plan'  , 'pet' , 'pet_species' , 'plan_used_records' )
                     ->limit( $data_Num )       
                     ->orderBy( 'id' , 'desc' )
                     ->where( 'account_id' , $account_id )
                     ->get() ;

    }


    // 查詢 ( 藉由 _ 客戶身分證字號 ) : 特定方案 + 客戶資料 + 寵物品種資料 + 方案使用紀錄
    public function show_SinglePlan_With_Customer_PetSpecies_PlanUsedRecords( $customerId ){

       return Plan::where( 'customer_id' , $customerId )
                    ->with( 'customer' , 'pet_species' , 'plan_used_records' )
                    ->get() ;

    }

    // 查詢 : 特定客戶身分證字號，所有美容單紀錄
    public function show_Customer_ID( $customerID ){

        return Plan::with( "customer" , "pet" )
                    ->where( 'customer_id' , $customerID  )
                    ->get() ;

    }



    // 查詢 ( 藉由 _ 寵物編號) : 特定寵物，所屬方案紀錄
    public function show_Single_Pet_Plans( $pet_Serial ){

        return Plan::where( 'apply_pet_serial' , $pet_Serial )
                   ->with( 'customer' , 'pet_species' , 'plan_used_records' , 'custom_plan' )
                   ->get() ;

    }

    
    // 查詢 _ 特定寵物 ( 依 "寵物編號") ，所有方案紀錄
    public function show_Pet_Records( $pet_Serial ){

        return Plan::with( "customer" , "pet" )
                    ->orderBy( 'created_at' , 'desc' )    // 依 : 建檔日期   
                    ->where( 'apply_pet_serial' , $pet_Serial )
                    ->get() ;

    }


    // 查詢 _ 特定寵物 : 方案紀錄
    public function show_Pet_Plans( $pet_Serial , $plan_Type ){

       return Plan::where( 'apply_pet_serial' , $pet_Serial )->where( 'plan_type' , $plan_Type )->get() ;

    }


    // 查詢 _ 特定日期 ( 建檔日期 : created_at -> 方案沒有 service_date )，購買的方案
    public function show_Plans_By_Date( $account_id = 1 , $date ){

       return Plan::with( 'customer' , 'pet' )
                    ->orderBy( 'created_at' , 'desc' )    // 依 : 建檔日期   
                    ->where( 'account_id' , $account_id )
                    ->where( 'created_at' , 'like'  , $date.'%' )
                    ->get() ;
 
    }
    
    // 查詢 _ 特定日期（ 付款日期 ），購買的方案
    public function show_Plans_By_Paymentdate( $account_id = 1 , $date ){

       return Plan::with( 'customer' , 'pet' )
                    ->orderBy( 'created_at' , 'desc' )    // 依 : 建檔日期
                    ->where( 'account_id' , $account_id ) 
                    ->where( 'payment_date' , 'like'  , $date.'%' )
                    ->get() ;
 
    }







}
