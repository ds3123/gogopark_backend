<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ServicePrice;


// @ 各類服務 ( 基礎、洗澡、美容... )
class ServicePriceController extends Controller {

    public function index(){  return ServicePrice::with('pet_species')->orderBy('id','desc')->get() ; }

    public function show($id) { return ServicePrice::findOrFail($id); }

    public function store(Request $request) {

        ServicePrice::create( $request->all() );
        return '服務價格 _ 新增成功' ;

    }

    public function update(Request $request, $id){

        ServicePrice::findOrFail( $id )->update( $request->all() );
        return '服務價格 _ 更新成功' ;

    }

    public function destroy($id){

        ServicePrice::findOrFail( $id )->delete();
        return '服務價格 _ 刪除成功' ;

    }

    // -----------------------------------------------------------------------------------------


    // 查詢 : 特定類別 _ 所有價錢
    public function show_Type_Prices( $service_type ){

        return ServicePrice::with('pet_species')->where('service_type' , $service_type )->orderBy('id','desc')->get();

    }

    // 查詢 : 特定品種 id ( pet_species 資料表 ) _ 所有價錢
    public function show_SpecieId_Prices( $species_id ){

       return ServicePrice::with('pet_species')->where('species_id' , $species_id )->orderBy('id','desc')->get();

    }

}
