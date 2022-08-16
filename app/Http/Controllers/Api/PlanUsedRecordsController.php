<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\PlanUsedRecords ;



// @ 方案 ( Ex. 包月洗澡 ) 使用紀錄
class PlanUsedRecordsController extends Controller {


    public function index(){ return PlanUsedRecords::orderBy('id','desc')->get() ; }

    public function show( $id ){ return PlanUsedRecords::findOrFail( $id ) ; }

    public function store( Request $request ){

        PlanUsedRecords::create( $request->all() ) ;
        return '新增 _ 使用紀錄成功' ;

    }

    public function update( Request $request , $id ){

        PlanUsedRecords::findOrFail( $id )->update( $request->all() ) ;
        return '修改 _ 使用紀錄成功' ;

    }

    public function destroy($id){

        PlanUsedRecords::findOrFail( $id )->delete() ;
        return '刪除 _ 使用紀錄成功' ;

    }

    // ------------------------ 

   
    // 查詢 _ 特定方案使用紀錄( 包含該紀錄 洗澡 / 美容 的服務內容 )
    public function show_Sigle_PlanUsedRecord_With_Service( $record_Id ){

        return PlanUsedRecords::with( 'bath' , 'beauty' )->where( 'id' ,  $record_Id )->first();

    }





}
