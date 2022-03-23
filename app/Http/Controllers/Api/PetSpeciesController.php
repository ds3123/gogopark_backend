<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\PetSpecies ;
use App\SpeciesSort ;


// @ 寵物品種
class PetSpeciesController extends Controller {

    public function index(){ return PetSpecies::orderBy('id','desc')->get(); }

    public function show($id){ return PetSpecies::findOrFail($id); }

    public function store(Request $request){

       $id = PetSpecies::create( $request->all() )->id ;

       return $id ; // 回傳 : 所新增資料的 id

    }

    public function update(Request $request, $id){

        PetSpecies::findOrFail( $id )->update( $request->all() ) ;
        return '寵物品種 _ 更新成功' ;

    }

    public function destroy($id){

        PetSpecies::findOrFail( $id )->delete() ;
        return '寵物品種 _ 刪除成功' ;

    }


    /* 自訂查詢 ----------------------------------------------------------------------------- */


    //  查詢 ( 依照 _ 傳入參數 : 欄位、欄位值 )
    public function show_By_Col_Param( $col , $param ){

        return PetSpecies::with('service_prices')->where( $col , $param )->get() ;

    }

    // 查詢 : 所有品種，其資料 + 所有服務價格
    public function show_all_species_service_prices(  ){

        return PetSpecies::with('service_prices')->orderBy('id','desc')->get() ;

    }

    // 查詢 : 特定品種，其資料 + 所有服務價格
    public function show_single_species_service_prices( $pet_id ){

       return PetSpecies::where( 'id' , $pet_id )->with('service_prices')->get() ;

    }

    // 刪除 _ 所有品種資料
    public function destroy_All_Species(){

        PetSpecies::truncate(); ;
        return '所有寵物品種 _ 刪除成功' ;

    }


    // 查詢 : 連結 _ 排序資料表( species_sorts) 的品種資料
    public function show_Sort_Order_Data(){

      return PetSpecies::with( 'sort_order' )->orderBy('id' , 'desc')->get() ;


    }

}
