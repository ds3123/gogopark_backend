<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\CustomPlan ;

class CustomPlanController extends Controller{
    
    public function index(){  return CustomPlan::get(); }

    public function show( $plan_id ){ return CustomPlan::findOrFail( $plan_id ) ; }

   
    public function store(Request $request){

        CustomPlan::create( $request->all() );
        return '自訂方案新增成功' ;
        
    }

    public function update(Request $request, $plan_id){

       CustomPlan::findOrFail( $plan_id )->update( $request->all());
       return '方案更新成功' ;
        
    }

    public function destroy($plan_id){

       CustomPlan::findOrFail( $plan_id )->delete();
       return '方案刪除成功' ;
 
    }

    // @ 自訂函式 --------------------------------------------------------

   

    // 搜尋 : 特定店家，特定名稱，自訂方案
    public function show_Shop_Custom_Plan_By_Name( $account_id = 1 , $plan_name ){


        $result = CustomPlan::where( 'account_id' , $account_id ) 
                              ->where( 'plan_name'  , $plan_name )
                              ->first() ;

        if( !isset( $result ) ){ return NULL ; }

        return $result ;

    }



    // 搜尋 : 特定商店 _ 所有自訂方案     
    public function show_Shop_Custom_Plans( $account_id = 1 ){

        return CustomPlan::where( 'account_id' , $account_id ) 
                           ->orderBy( 'created_at' , 'desc' )    // 依 : 建檔日期
                           ->get() ;

    }


}
