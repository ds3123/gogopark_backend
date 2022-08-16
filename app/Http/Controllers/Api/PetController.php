<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Pet ;           // 匯入 : 寵物 Model


class PetController extends Controller{

    // @ API Resource

    public function index(){  return Pet::all(); }

    // 查詢 _　單一寵物 ( 寵物編號 )
    public function show( $serial ){ return Pet::where( 'serial' , $serial )->first() ; }

    public function store( Request $request ){  return Pet::create( $request->all() ); }

    public function update( Request $request , $serial ){

        Pet::where( 'serial' , $serial )->first()->update( $request->all() ) ;
        return '寵物更新成功' ;

    }

    public function destroy( $serial ){

        Pet::where( 'serial' , $serial )->first()->delete();
        return '寵物刪除成功' ;

    }

    // @ 自訂函式 --------------------------------------------------------

    // # 一對一 :
    // 單一寵物，及其客戶
    public function show_Pet_Customer( $serial ){

      return Pet::with( 'customer' )->where( 'serial' , $serial )->first();

    }

    // 所有寵物，及其客戶
    public function show_Pets_Customers(){

       $pet_cus = Pet::with( 'customer' )->orderBy( 'created_at' , 'desc' )->get();
       return $pet_cus ? $pet_cus : [] ;

    }



    // 部分 _ 寵物，及其客戶 + 關係人
    public function show_Pets_Customers_Relatives( $is_Archive , $data_Num = 50 ){


       $pet_cus = Pet::with( array( 'customer' => function( $query ){
  
                                                     $query->select(  'name' , 'id'  , 'mobile_phone' , 'is_rejected' ) ;     

                                                  }  
                                    ))
                        ->select( 'customer_id' , 'serial' , 'name' , 'species' , 'sex' , 'color' , 'birthday' , 'is_rejected' , 'is_dead' , 'created_at' )            
                        ->limit( $data_Num )
                        ->where( 'is_archive' , $is_Archive )
                        ->orderBy( 'pet_id' , 'desc' )     // 前端已經有排序
                        ->get() ;

    //    $pet_cus = Pet::with( 'customer' , 'customer_relative' )
    //                    ->limit( $data_Num )
    //                    ->where( 'is_archive' , $is_Archive )
    //                    ->orderBy( 'pet_id' , 'desc' )     // 前端已經有排序
    //                    ->get();

       return $pet_cus ;

    }


    // 所有 _ 寵物，及其客戶 + 關係人
    public function show_All_Pets_Customers_Relatives( $is_Archive ){

        $pet_cus = Pet::with( array( 'customer' => function( $query ){
  
                                                       $query->select( 'name' , 'id'  , 'mobile_phone' , 'is_rejected' ) ;     
 
                                                   }  
                            ))
                        ->select( 'customer_id' , 'serial' , 'name' , 'species' , 'sex' , 'color' , 'birthday' , 'is_rejected' , 'is_dead' , 'created_at' )
                        ->where( 'is_archive' , $is_Archive )
                        ->orderBy( 'pet_id' , 'desc' )    // 前端已經有排序
                        ->get() ;

        // $pet_cus = Pet::with( 'customer' , 'customer_relative' )
        //                 ->where( 'is_archive' , $is_Archive )
        //                 ->orderBy( 'pet_id' , 'desc' )    // 前端已經有排序
        //                 ->get();


        return $pet_cus ;
 
     }


    // 取得 _ 目前某品種的所有寵物
    public function show_Current_Pet_Species( $species_Name ){

       return Pet::where( 'species' , $species_Name )->get() ;
       
    }


}
