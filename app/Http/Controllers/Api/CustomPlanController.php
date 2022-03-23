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

    // 搜尋 : 自訂方案 : 名稱    
    public function show_By_Plan_Name(  $param ){

        return CustomPlan::where( 'plan_name'  , $param )->get() ;

    }


}
