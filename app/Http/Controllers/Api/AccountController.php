<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Account ;     // 匯入 Account Model

class AccountController extends Controller {

    public function index() {  return Account::orderBy( 'created_at' , 'desc' )->get(); }

    public function show( $id ){  return  Account::findOrFail( $id ) ; }

    public function store( Request $request ) {
        Account::create( $request->all() );
        return '帳號資料 _ 新增成功' ;
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



}

