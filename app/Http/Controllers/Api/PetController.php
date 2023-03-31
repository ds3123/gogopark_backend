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

      return Pet::with( 'customer' )
                  ->where( 'serial' , $serial )
                  ->first();

    }

    // 特定店家，特定寵物
    public function show_Shop_Pet( $account_id = 1 , $serial ){

        return Pet::with( 'customer' )
                   ->where( 'account_id' , $account_id )
                   ->where( 'serial' , $serial )
                   ->get() ;


    }

    // 所有寵物，及其客戶
    public function show_Pets_Customers( $account_id = 1 ){

       $pet_cus = Pet::with( 'customer' )
                       ->where( 'account_id' , $account_id )
                       ->orderBy( 'created_at' , 'desc' )
                       ->get();
       
       return $pet_cus ;

    }


    // 特定店家，被拒接 ( 通過、審核中 ) 的寵物 ( 及其主人 )
    public function show_Pets_On_Rejected( $account_id = 1 ){

        $pet_cus = Pet::with( 'customer' )
                       ->where( 'account_id' , $account_id )
                       ->where( function( $query ){

                            return $query->where( 'rejected_status' , "審核中"  ) 
                                         ->orWhere( 'rejected_status' , "通過"  ) ;
                    
                        })   
                       ->orderBy( 'rejected_status' , 'asc' )  // 以審核狀態排序 ( 審核中 -> 排在一起，並優先排在最上層 )
                       ->orderBy( 'updated_at' , 'desc' )      // 再以更新時間排序 
                       ->paginate( 10 );
        
        
        return $pet_cus ;
 
     }




    // 所有 _ 寵物，及其客戶 + 關係人
    public function show_All_Pets_Customers_Relatives( $account_id , $is_Archive , Request $request ){


        // 取得 _ 查詢字串參數值
        $search = $request->query( 'search' ) ;  


        // 查詢 _ 寵物、客戶資料 
        $pet_cus = Pet::with( array( 'customer' => function( $query ){
  
                                                       $query->select( 'customer_id' , 'name' , 'id'  , 'mobile_phone' , 'is_rejected' ) ;     
 
                                                   }  
                            ))
                        ->select( 'pet_id', 'account_id' , 'customer_id' , 'serial' , 'name' , 'species' , 'sex' , 'color' , 'note' , 'lodge_note' , 'private_note' , 'birthday' , 'is_rejected' , 'is_dead' , 'created_at' , 'single_bath_price' , 'single_beauty_price' , 'month_bath_price' , 'month_beauty_price' )
                        ->where( 'is_archive' , $is_Archive )
                        // 視 '查詢關鍵字' 有無，決定是否加入以下查詢條件
                        ->when( isset( $search ) && $search !== '' , function( $query ) use ( $search , $account_id ){  
                                          
                            return $query->where( 'account_id' , $account_id )                                    // < 按照店家 id >
                                         ->where( 'name' , 'like' , '%'.$search.'%' )                             // 寵物：名字  
                                         ->orWhere( 'species' , 'like' , '%'.$search.'%' )                        // 寵物：品種
                                         ->orWhere( 'serial' , 'like' , '%'.$search.'%' )                         // 寵物：序號    
                                         ->orWhereHas( 'customer' , function( $query ) use ( $search , $account_id ){ 

                                            return $query->where( 'account_id' , $account_id )                    // < 按照店家 id >
                                                         ->where( 'name' , 'like' , '%'.$search.'%' )             // 客戶：姓名
                                                         ->orWhere( 'id' , 'like' , '%'.$search.'%' )             // 客戶：身分證字號
                                                         ->orWhere( 'mobile_phone' , 'like' , '%'.$search.'%' ) ; // 客戶：手機號碼

                                         }) ;   
                                         


                        })
                        ->orderBy( 'created_at' , 'desc' )   
                        ->where( 'account_id' , $account_id )  // < 按照店家 id >
                        ->paginate( 10 ) ;
                        

        return $pet_cus ;
 
     }


    // 取得 _ 目前某品種的所有寵物
    public function show_Current_Pet_Species( $account_id = 1 , $species_Name ){

       return Pet::where( 'species' , $species_Name )
                   ->where( 'account_id' , $account_id )
                   ->get() ;
       
    }


}
