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
    public function show_Type_Prices( $account_id = 1 , $service_type ){

        return ServicePrice::with('pet_species')
                            ->where( 'account_id' , $account_id  )
                            ->where( 'service_type' , $service_type )
                            ->orderBy('id','desc')
                            ->get();

    }

    // 查詢 : 特定品種 id ( pet_species 資料表 ) _ 所有價錢
    public function show_SpecieId_Prices( $account_id = 1 , $species_id ){

       return ServicePrice::with('pet_species')
                           ->where( 'account_id' , $account_id )
                           ->where( 'species_id' , $species_id )
                           ->orderBy('id','desc')
                           ->get();


    }


    // 查詢 : 特定店家，特定品種 id _ 5 種基本價格 : 初次洗澡、單次洗澡、包月洗澡、單次美容、包月美容 
    public function show_Shop_Species_Id_5_Prices( $account_id = 1 , $species_id ){


            // 初次洗澡優惠
            $first_Bath = ServicePrice::with('pet_species')
                                        ->where( 'account_id' , $account_id )
                                        ->where( 'species_id' , $species_id )
                                        ->where( 'service_type' , "洗澡" )
                                        ->where( 'service_name' , "初次洗澡優惠價格" )
                                        ->first() ;
                
            // 單次洗澡
            $single_Bath = ServicePrice::with('pet_species')
                                        ->where( 'account_id' , $account_id )
                                        ->where( 'species_id' , $species_id )
                                        ->where( 'service_type' , "洗澡" )
                                        ->where( 'service_name' , "單次洗澡價格" )
                                        ->first() ;

            // 包月洗澡
            $month_Bath = ServicePrice::with('pet_species')
                                        ->where( 'account_id' , $account_id )
                                        ->where( 'species_id' , $species_id )
                                        ->where( 'service_type' , "洗澡" )
                                        ->where( 'service_plan' , "包月洗澡" )
                                        ->first() ;

            // 單次美容
            $single_Beauty = ServicePrice::with('pet_species')
                                           ->where( 'account_id' , $account_id )
                                           ->where( 'species_id' , $species_id )
                                           ->where( 'service_type' , "美容" )
                                           ->where( 'service_name' , "單次美容價格" )
                                           ->first() ;

            // 包月美容
            $month_Beauty = ServicePrice::with('pet_species')
                                          ->where( 'account_id' , $account_id )
                                          ->where( 'species_id' , $species_id )
                                          ->where( 'service_type' , "美容" )
                                          ->where( 'service_plan' , "包月美容" )
                                          ->first() ;


            // 若無相關品種，回傳 Null                               
            if( !isset( $first_Bath ) ){ return Null ; }                               


            // 回傳 _ 5 種基本價格                   
            return [

                "species_Name"  => $first_Bath["pet_species"]["name"] ,   // 品種名稱

                "first_Bath"    => $first_Bath["service_price"] ,         // 初次洗澡
                "single_Bath"   => $single_Bath["service_price"] ,        // 單次洗澡
                "month_Bath"    => $month_Bath["service_price"] ,         // 包月洗澡

                "single_Beauty" => $single_Beauty["service_price"] ,      // 單次美容 
                "month_Beauty"  => $month_Beauty["service_price"]         // 包月美容   

            ] ;       






    }




    
    // 查詢 : 特定商店，所有服務價格 
    public function show_Shop_Service_Prices( $account_id = 1 ){

        return ServicePrice::with( 'pet_species' )
                            ->where( 'account_id' , $account_id )
                            ->get();

 
     }

}
