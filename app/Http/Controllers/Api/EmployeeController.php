<?php

namespace App\Http\Controllers\Api;

use App\Basic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Employee ;     // 匯入 Employee Model

class EmployeeController extends Controller {

    public function index() {  return Employee::orderBy('created_at' , 'desc' )->get(); }

    public function show( $id ){  return Employee::findOrFail( $id ) ; }

    public function store( Request $request ) {
        Employee::create( $request->all() );
        return '員工資料 _ 新增成功' ;
    }


    public function update( Request $request , $id ) {
        Employee::findOrFail( $id )->update( $request->all());
        return '員工資料 _ 更新成功' ;
    }

    public function destroy($id){
        Employee::findOrFail( $id )->delete();
        return '員工資料 _ 刪除成功' ;
    }


    /* 自訂查詢 ----------------------------------------------------------------------------- */


     // 查詢 : 為特定帳號的員工 ( Ex. for 檢查新增員工時，帳號是否重複 )
     public function show_Employee_With_Account( $account ){

        return Employee::where( 'account' , $account )->get() ;

     }

     // 查詢 : 為特定 id 的員工 ( 包含其所屬 _ 商店資料 )
     public function show_Employee_With_Account_By_EmployeeId( $employee_id ){

        return Employee::with( 'shop_account' )
                         ->where( 'id' , $employee_id )
                         ->first() ;

     }





     // 查詢 : 所有員工 ( 包含其所屬 _ 商店資料 )
     public function show_All_Employees_With_Account( ){

        return Employee::with( 'shop_account' )->get() ;

     }


}
