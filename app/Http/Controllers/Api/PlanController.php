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

    public function destroy($id) {

        Plan::findOrFail( $id )->delete();
        return '刪除 _ 方案資料成功' ;

    }

    // -----------------------------------------------------------------------------

    // 查詢 _ 所有方案 + 客戶資料 + 寵物品種資料 + 方案使用紀錄
    public function show_AllPlans_With_Customer_PetSpecies_PlanUsedRecords( ){

        return Plan::with( 'customer' , 'customer_relative' , 'custom_plan'  , 'pet' , 'pet_species' , 'plan_used_records' )->orderBy( 'id' , 'desc' )->get() ;

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

    
    // 查詢方案單，相對應的 : 方案消費紀錄 ( 與以上類似，考慮整合 2022.01.19 )
    public function show_Pet_Records( $pet_Serial ){

        return Plan::where( 'apply_pet_serial' , $pet_Serial )
                   ->get() ;

    }


    // 查詢 _ 特定寵物 : 方案紀錄
    public function show_Pet_Plans( $pet_Serial , $plan_Type ){

       return Plan::where( 'apply_pet_serial' , $pet_Serial )->where( 'plan_type' , $plan_Type )->get() ;

    }


    // 查詢 _ 特定日期購買的方案
    public function show_Plans_By_Date( $date ){

       return Plan::where( 'created_at' , 'like'  , $date.'%' )
                    ->with( 'customer' , 'pet' )
                    ->get() ;
 
    }







}
