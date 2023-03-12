<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Account ;     // 匯入 Account Model

class AccountController extends Controller {

    public function index() {  return Account::orderBy( 'created_at' , 'desc' )->get(); }

    public function show( $id ){  return  Account::findOrFail( $id ) ; }

    public function store( Request $request ) {

        $account_id = Account::create( $request->all() )->account_id ;
       
        return $account_id ;  // 回傳 : 所新增帳號的 id

    }


    public function update( Request $request , $id ) {
        Account::findOrFail( $id )->update( $request->all());
        return '帳號資料 _ 更新成功' ;
    }

    public function destroy($id){
        Account::findOrFail( $id )->delete();
        return '帳號資料 _ 刪除成功' ;
    }


    /* 自訂查詢 ----------------------------------------------------------------------------- */

    
    public function show_Accounts_With_Employees_By_Zipcode( $zipcode ){

        return Account::with( 'shop_employees' )
                        ->where( 'zipcode' , $zipcode )
                        ->get() ;

     }











}

