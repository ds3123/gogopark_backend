<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Other ;     // 匯入 Other Model

class OtherController extends Controller{
    
    public function index(){ return Other::get(); }

    public function show($id){ return Other::findOrFail( $id ) ; }

    public function store(Request $request){
        
        Other::create( $request->all() );
        return '其他項目新增成功' ;

    }

    public function update(Request $request, $id){
        
        Other::findOrFail( $id )->update( $request->all());
        return '其他收支項目更新成功' ;

    }

    public function destroy($id){
        
        Other::findOrFail( $id )->delete();
        return '其他收支項目刪除成功' ;

    }


   // ---------------------------------------------------------

 
    // 查詢 _ 特定日期 ( 建檔日期 : created_at ) , 收支  
    public function show_Others_By_Date( $account_id = 1 , $date ){

        return Other::where( 'account_id' , $account_id ) 
                      ->where( 'created_at' , 'like'  , $date.'%' )
                      ->orderBy( 'created_at' , 'desc' )    // 依 : 建檔日期
                      ->get() ;
                      
  
    }



}
