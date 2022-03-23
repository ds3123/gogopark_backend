<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Price ;             // 匯入 : 價錢 Model

class PriceController extends Controller{

    // @ API Resource
    // 查詢 _　所有價錢
    public function index(){  return Price::get(); }

    // 查詢 _　單一價錢
    public function show( $price_id ){  return Price::where( 'price_id' , $price_id )->first();  }

    // 新增 _ 價錢
    public function store( Request $request) {  return Price::create( $request->all() );  }

    // 更新 _ 價錢
    public function update( Request $request , $price_id ){

        Price::where( 'price_id' , $price_id )->first()->update( $request->all() );
        return '價錢更新成功' ;

    }

    // 刪除 _ 價錢
    public function destroy( $price_id ){

        Price::where( 'price_id' , $price_id )->first()->delete();
        return '價錢刪除成功' ;

    }

    /* 自訂查詢 ----------------------------------------------------------------------------- */

    public function show_Single_Type_Item_Price( $type , $item ){

      $arr   = Price::where( 'type' , $type )->get();
      $price = 0 ;

      if( count( $arr ) > 0 ){

          foreach( $arr as $a ){

            $data = json_decode( $a ) ;

            if( trim($data->item) == trim($item) ){
                $price = $data->price ;
            }

          }

      }

      return $price ;

    }


    // 查詢 : 特定類別 _ 所有價錢
    public function show_Type_Prices( $type ){

       return Price::where( 'type' , $type )->get();

    }

}
