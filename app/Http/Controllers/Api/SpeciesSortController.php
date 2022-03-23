<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\SpeciesSort ;



// @ for 紀錄 _ 寵物品種列表 : 排列順序
class SpeciesSortController extends Controller {

    public function index() { return SpeciesSort::orderBy( 'id' , 'desc' )->get() ; }

    public function show($id) { return SpeciesSort::findOrFail( $id ) ; }

    public function store(Request $request) {

        SpeciesSort::create( $request->all() ) ;
        return '新增 _ 品種順序成功' ;

    }

    public function update(Request $request, $id) {

        SpeciesSort::findOrFail( $id )->update( $request->all() );
        return '更新 _ 品種順序成功' ;

    }

    public function destroy($id) {

        SpeciesSort::findOrFail( $id )->delete();
        return '刪除 _ 品種順序成功' ;

    }

   // ------------------------------------------------------------------

    // 新增 _ 多筆資料
    public function create_Multi_Data( Request $request ){

        // # 先刪除 _ 資料所有資料
        SpeciesSort::truncate();

        // # 新增資料
        // 取得 _ POST 傳來，排序後的資料 ( 陣列 )
        $data = $request->post() ;

        if( count( $data ) > 0 ){

           // 逐一新增資料
           foreach( $data as $d ){  SpeciesSort::create( $d ) ; }

           return '資料排序成功' ;

        }

        return '沒有任何資料' ;

    }


    // 清除 _ 資料表( species_sort ) 所有資料
    public function clear_Table_Data( ) {

        SpeciesSort::truncate();
        return '已清除資料表 ( species_sort ) 所有資料' ;

    }



    // 查詢 : 連結 _ 排序資料表( species_sorts) 的品種資料
    public function show_Sort_Order_Data(){

       return SpeciesSort::with( 'pet_species' )->orderBy( 'id' , 'asc' )->get() ;

    }



}
