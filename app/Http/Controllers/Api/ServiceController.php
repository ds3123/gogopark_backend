<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Basic ;   // 匯入 Basic Model
use App\Bath ;    // 匯入 Bath Model
use App\Beauty ;  // 匯入 Beauty Model
use App\Care ;    // 匯入 Care Model
use App\Lodge ;   // 匯入 Lodge Model


/*
 *
 *  @ 服務( 基礎、洗澡、美容、住宿 ) 共同管理
 *
 */


class ServiceController extends Controller{

  /* ---- 自訂查詢 ----  */

    // 查詢 : 所有 _ 服務 + 客戶 + 寵物
    public function show_With_Cus_Pet(){

       $basic_Arr  = Basic::with('customer' , 'pet' )->get() ;
       $bath_Arr   = Bath::with('customer' , 'pet' )->get() ;
       $beauty_Arr = Beauty::with('customer' , 'pet' )->get() ;
       $arr        = array() ;

       forEach( $basic_Arr as $basic ){   $arr[] = $basic;  }
       forEach( $bath_Arr as $bath ){     $arr[] = $bath;   }
       forEach( $beauty_Arr as $beauty ){ $arr[] = $beauty; }

       // 無法直接用 array_mere() ;
       // return array_merge( $basic_Arr , $bath_Arr , $beauty_Arr ) ;

       return $arr ;

    }


    // 查詢 : < 分頁 > 所有 _ 服務 + 客戶 + 客戶關係人 + 寵物 ( 參數 : 是否封存 )
    public function show_All_With_Cus_Relative_Pet( $account_id , $is_Archive , Request $request ){


        // 取得 _ 查詢字串參數值
        $search = $request->query( 'search' ) ;  // 搜尋關鍵字
        $f_Date = $request->query( 'date_1' ) ;  // 篩選 _ 來店日期



        // $basic_Arr  = Basic::with([ 
        //     'customer' => function( $query ){ $query->select( 'name' , 'id' , 'mobile_phone' );  } ,
        //     'pet'      => function( $query ){ $query->select( 'pet_id' , 'account_id' , 'customer_id' , 'serial' , 'name' , 'species' , 'birthday'  ,  'sex' , 'color' , 'note' , 'lodge_note' , 'private_note' ); } 
        //   ])



        // 基礎  
        $basic_Arr  = Basic::with( 'customer' , 'pet' , 'extra_fee' )
                             ->orderBy( 'service_date' , 'desc' )    // 依 : 來店日期                 
                             ->where( 'account_id' , $account_id )   // < 按照店家 id >
                             ->where( 'is_archive' , $is_Archive ) 
                             // 視 '查詢關鍵字' 有無，決定是否加入以下查詢條件
                             ->when( isset( $search ) && $search !== '' , function( $query ) use ( $search , $account_id ){  
                                            
                                return $query->whereHas( 'customer' , function( $query ) use ( $search , $account_id ){ 

                                                      $query->where( 'account_id' , $account_id )   // < 按照店家 id >
                                                            ->where( 'name' , 'like' , '%'.$search.'%' )             // 客戶：姓名
                                                            ->orWhere( 'id' , 'like' , '%'.$search.'%' )             // 客戶：身分證字號
                                                            ->orWhere( 'mobile_phone' , 'like' , '%'.$search.'%' ) ; // 客戶：手機號碼

                                               })
                                               ->orWhereHas( 'pet' , function( $query ) use ( $search , $account_id ){ 

                                                    $query->where( 'account_id' , $account_id )   // < 按照店家 id >
                                                          ->where( 'name' , 'like' , '%'.$search.'%' )               // 寵物：名字
                                                          ->orWhere( 'species' , 'like' , '%'.$search.'%' )          // 寵物：品種
                                                          ->orWhere( 'serial' , 'like' , '%'.$search.'%' ) ;         // 寵物：序號

                                               }) ;       
                                            
                            })
                            // 視 '篩選 _ 來店日期' 有無，決定是否加入以下查詢條件
                            ->when( isset( $f_Date ) && $f_Date !== '' , function( $query ) use ( $f_Date , $account_id ){  
                                      
                                return $query->where( 'account_id' , $account_id )   // < 按照店家 id >
                                             ->where( 'service_date' , $f_Date ) ;                                   // 來店日期
                                            
                            })
                            ->get() ; 
                            
        // 洗澡
        $bath_Arr   = Bath::with( 'customer' , 'pet' , 'plan' , 'extra_fee' )
                            ->orderBy( 'service_date' , 'desc' )    // 依 : 來店日期      
                            ->where( 'account_id' , $account_id )   // < 按照店家 id >
                            ->where( 'is_archive' , $is_Archive ) 
                            // 視 '查詢關鍵字' 有無，決定是否加入以下查詢條件
                            ->when( isset( $search ) && $search !== '' , function( $query ) use ( $search , $account_id ){  
                                            
                                return $query->whereHas( 'customer' , function( $query ) use ( $search , $account_id ){ 

                                                      $query->where( 'account_id' , $account_id )                     // < 按照店家 id >
                                                            ->where( 'name' , 'like' , '%'.$search.'%' )              // 客戶：姓名
                                                            ->orWhere( 'id' , 'like' , '%'.$search.'%' )              // 客戶：身分證字號
                                                            ->orWhere( 'mobile_phone' , 'like' , '%'.$search.'%' ) ;  // 客戶：手機號碼

                                               })
                                               ->orWhereHas( 'pet' , function( $query ) use ( $search , $account_id ){ 

                                                      $query->where( 'account_id' , $account_id )                     // < 按照店家 id >
                                                            ->where( 'name' , 'like' , '%'.$search.'%' )              // 寵物：名字
                                                            ->orWhere( 'species' , 'like' , '%'.$search.'%' )         // 寵物：品種
                                                            ->orWhere( 'serial' , 'like' , '%'.$search.'%' ) ;        // 寵物：序號

                                               }) ;    
                                            
                            })
                            // 視 '篩選 _ 來店日期' 有無，決定是否加入以下查詢條件
                            ->when( isset( $f_Date ) && $f_Date !== '' , function( $query ) use ( $f_Date , $account_id ){  
                                      
                                return $query->where( 'account_id' , $account_id )   // < 按照店家 id >
                                             ->where( 'service_date' , $f_Date ) ;   // 來店日期
                                            
                            })
                            ->limit( 100 )    // 洗澡限制在 100 筆 2023.02.22
                            ->get() ;
                        
        // 美容
        $beauty_Arr = Beauty::with( 'customer' , 'pet' , 'plan' , 'extra_fee' )
                              ->orderBy( 'service_date' , 'desc' )    // 依 : 來店日期      
                              ->where( 'account_id' , $account_id )   // < 按照店家 id >
                              ->where( 'is_archive' , $is_Archive )
                              // 視 '查詢關鍵字' 有無，決定是否加入以下查詢條件
                              ->when( isset( $search ) && $search !== '' , function( $query ) use ( $search , $account_id ){  
                                            
                                return $query->whereHas( 'customer' , function( $query ) use ( $search , $account_id ){ 

                                                    $query->where( 'account_id' , $account_id )                    // < 按照店家 id >
                                                          ->where( 'name' , 'like' , '%'.$search.'%' )             // 客戶：姓名
                                                          ->orWhere( 'id' , 'like' , '%'.$search.'%' )             // 客戶：身分證字號
                                                          ->orWhere( 'mobile_phone' , 'like' , '%'.$search.'%' ) ; // 客戶：手機號碼

                                               })
                                               ->orWhereHas( 'pet' , function( $query ) use ( $search , $account_id ){ 

                                                    $query->where( 'account_id' , $account_id )                    // < 按照店家 id >
                                                          ->where( 'name' , 'like' , '%'.$search.'%' )             // 寵物：名字
                                                          ->orWhere( 'species' , 'like' , '%'.$search.'%' )        // 寵物：品種
                                                          ->orWhere( 'serial' , 'like' , '%'.$search.'%' ) ;       // 寵物：序號

                                              }) ;        
                                            
                              }) 
                              // 視 '篩選 _ 來店日期' 有無，決定是否加入以下查詢條件
                              ->when( isset( $f_Date ) && $f_Date !== '' , function( $query ) use ( $f_Date , $account_id ){  
                                      
                                   return $query->where( 'account_id' , $account_id )  // < 按照店家 id >
                                                ->where( 'service_date' , $f_Date ) ;  // 來店日期
                                            
                              })
                              ->limit( 100 )    // 美容限制在 100 筆 2023.02.22
                              ->get() ; 
                              
           
                   
        // 合併 3 類服務陣列
        $merge_Bath   = $basic_Arr->mergeRecursive( $bath_Arr ) ;     // 合併 _ 洗澡 
        $merge_Beauty = $merge_Bath->mergeRecursive( $beauty_Arr ) ;  // 合併 _ 美容
        
        $sort_Arr     = $merge_Beauty->sortByDesc( 'created_at' ) ;  // 降冪排序                  
        $reslut       = $sort_Arr->paginate( 10 ) ;                  // 為所合併的陣列集合，執行分頁 
        
        return $reslut ;

    }


    // 查詢 : < 分頁 > 所有 _ 服務 + 客戶 + 客戶關係人 + 寵物 ( 與上述相似  / 參數 : 是否服務異常 )
    public function show_Services_by_Error_Page( $account_id = 1 , $is_Error ){

        $basic_Arr  = Basic::with('customer' , 'customer_relative' , 'pet' , 'serviceError' )
                      ->where( 'account_id' , $account_id )
                      ->where('is_error' , $is_Error )
                      ->get() ;

        $bath_Arr   = Bath::with('customer' , 'customer_relative' , 'pet' , 'plan' , 'serviceError' )
                      ->where( 'account_id' , $account_id )
                      ->where('is_error' , $is_Error )
                      ->get() ;

        $beauty_Arr = Beauty::with('customer' , 'customer_relative' , 'pet' , 'plan' , 'serviceError')
                      ->where( 'account_id' , $account_id )
                      ->where('is_error' , $is_Error )
                      ->get() ;


        $lodge_Arr  = Lodge::with( 'customer' , 'customer_relative' , 'pet' , 'serviceError')
                      ->where( 'account_id' , $account_id )
                      ->where('is_error' , $is_Error )
                      ->get() ;            

        $care_Arr   = Care::with( 'customer' , 'customer_relative' , 'pet' , 'serviceError')
                      ->where( 'account_id' , $account_id )
                      ->where('is_error' , $is_Error )
                      ->get() ;                  

        
        $merge_Bath   = $basic_Arr->mergeRecursive( $bath_Arr ) ;     // 合併 _ 洗澡 
        $merge_Beauty = $merge_Bath->mergeRecursive( $beauty_Arr ) ;  // 合併 _ 美容 
        $merge_Care   = $merge_Beauty->mergeRecursive( $care_Arr ) ;  // 合併 _ 安親 
        $merge_Lodge  = $merge_Care->mergeRecursive( $lodge_Arr ) ;   // 合併 _ 住宿

        $sort_Arr     = $merge_Lodge->sortByDesc( "updated_at" ) ;    // 依照更新時間排序
        $page_Arr     = $sort_Arr->paginate( 10 ) ;                   // 分頁處理
       
        return $page_Arr ;

    }


    // 查詢 : 所有 _ 服務 + 客戶 + 客戶關係人 + 寵物 ( 與上述相似，但無分頁 paginate )
    public function show_Shop_Services_by_Error( $account_id = 1 , $is_Error ){

        $basic_Arr  = Basic::with('customer' , 'pet' , "serviceError" )
                      ->where( 'account_id' , $account_id )
                      ->where('is_error' , $is_Error )
                      ->get() ;

        $bath_Arr   = Bath::with('customer' , 'pet' , "serviceError" )
                      ->where( 'account_id' , $account_id )
                      ->where('is_error' , $is_Error )
                      ->get() ;

        $beauty_Arr = Beauty::with('customer' , 'pet' , "serviceError" )
                      ->where( 'account_id' , $account_id )
                      ->where('is_error' , $is_Error )
                      ->get() ;


        $lodge_Arr  = Lodge::with( 'customer' , 'pet' , "serviceError" )
                      ->where( 'account_id' , $account_id )
                      ->where('is_error' , $is_Error )
                      ->get() ;            

        $care_Arr   = Care::with( 'customer' , 'pet' , "serviceError" )
                      ->where( 'account_id' , $account_id )
                      ->where('is_error' , $is_Error )
                      ->get() ;                  

        
        $merge_Bath   = $basic_Arr->mergeRecursive( $bath_Arr ) ;     // 合併 _ 洗澡 
        $merge_Beauty = $merge_Bath->mergeRecursive( $beauty_Arr ) ;  // 合併 _ 美容 
        $merge_Care   = $merge_Beauty->mergeRecursive( $care_Arr ) ;  // 合併 _ 安親 
        $merge_Lodge  = $merge_Care->mergeRecursive( $lodge_Arr ) ;   // 合併 _ 住宿

        $sort_Arr     = $merge_Lodge->sortByDesc( "updated_at" ) ;    // 依照更新時間排序
        
       
        return $sort_Arr ;

    }



    // 查詢 : 所有 _ 服務 + 客戶 + 客戶關係人 + 寵物 ( 與上述相似  / 參數 : 是否銷單 )
    public function show_Services_by_Delete( $account_id = 1 , $is_Delete ){

        $basic_Arr  = Basic::with( 'customer' , 'customer_relative' , 'pet' )
                      ->where( 'account_id' , $account_id )
                      ->where( 'is_delete' , $is_Delete )
                      ->get() ;

        $bath_Arr   = Bath::with( 'customer' , 'customer_relative' , 'pet' , 'plan' )
                      ->where( 'account_id' , $account_id )
                      ->where( 'is_delete' , $is_Delete )
                      ->get() ;

        $beauty_Arr = Beauty::with( 'customer' , 'customer_relative' , 'pet' , 'plan' )
                      ->where( 'account_id' , $account_id )
                      ->where( 'is_delete' , $is_Delete )
                      ->get() ;


        $merge_Bath   = $basic_Arr->mergeRecursive( $bath_Arr ) ;     // 合併 _ 洗澡 
        $merge_Beauty = $merge_Bath->mergeRecursive( $beauty_Arr ) ;  // 合併 _ 美容 

        $sort_Arr     = $merge_Beauty->sortByDesc( "updated_at" ) ;    // 依照更新時間排序
        $page_Arr     = $sort_Arr->paginate( 10 ) ;                    // 分頁處理

        return $page_Arr ;

    }

    // 特定日期，為 "銷單( is_delete )" 、 "異常( is_error )" 的服務單
    public function show_Services_Is_Delete_Error_By_Date( $account_id = 1 , $date ){

        $basic_Arr  = Basic::with( 'customer' , 'pet' )
                           ->where( 'account_id' , $account_id )
                           ->where( 'service_date' ,  $date )
                           ->where( function( $query ){
                               $query->where( 'is_delete' , 1  ) ;  
                               $query->orWhere( 'is_error' , 1  ) ;
                             })
                           ->get() ;

        $bath_Arr   = Bath::with( 'customer' , 'pet'  )
                          ->where( 'account_id' , $account_id )
                          ->where( 'service_date' , $date )
                          ->where( function( $query ){
                               $query->where( 'is_delete' , 1  ) ;  
                               $query->orWhere( 'is_error' , 1  ) ;
                            })
                          ->get() ;

        $beauty_Arr = Beauty::with( 'customer' , 'pet' )
                            ->where( 'account_id' , $account_id )
                            ->where( 'service_date' , $date )
                            ->where( function( $query ){
                               $query->where( 'is_delete' , 1  ) ;  
                               $query->orWhere( 'is_error' , 1  ) ;
                             })
                           ->get() ;

        $arr        = array() ;

        forEach( $basic_Arr as $basic ){   $arr[] = $basic;  }
        forEach( $bath_Arr as $bath ){     $arr[] = $bath;   }
        forEach( $beauty_Arr as $beauty ){ $arr[] = $beauty; }

        return $arr ;


    }

    
    // 特定日期， 是否在 "已回家( 房 )" 情況的服務單 ( 基礎、洗澡、美容」 )
    public function show_Services_Is_GoHome_By_Date( $account_id = 1 , $date ){


        $basic_Arr  = Basic::with( 'customer' , 'pet' )
                             ->where( 'account_id' , $account_id )
                             ->where( 'service_date' ,  $date )
                             ->where( 'shop_status' ,  '已回家( 房 )' )
                             ->get() ;

        $bath_Arr   = Bath::with( 'customer' , 'pet'  )
                            ->where( 'account_id' , $account_id )
                            ->where( 'service_date' , $date )
                            ->where( 'shop_status' ,  '已回家( 房 )' )
                            ->get() ;

        $beauty_Arr = Beauty::with( 'customer' , 'pet' )
                            ->where( 'account_id' , $account_id )
                            ->where( 'service_date' , $date )
                            ->where( 'shop_status' ,  '已回家( 房 )' )
                            ->get() ;

        $arr        = array() ;

        forEach( $basic_Arr as $basic ){   $arr[] = $basic;  }
        forEach( $bath_Arr as $bath ){     $arr[] = $bath;   }
        forEach( $beauty_Arr as $beauty ){ $arr[] = $beauty; }

        return $arr ;

    
    }    


    // 查詢 : 特定日期，各項服務已使用 Q 碼 (s)
    public function show_Date_Qcode( $account_id = 1 , $date ){

        // 基礎 Qcode
        $data_Basic = Basic::where( 'service_date' , $date )
                            ->where( 'account_id' , $account_id )
                            ->get() ;
        $q_Basic    = array() ;
        foreach( $data_Basic as $obj ){ $q_Basic[] = $obj->q_code ; }


        // 洗澡 Qcode
        $data_Bath = Bath::where( 'service_date' , $date )
                          ->where( 'account_id' , $account_id )
                          ->get() ;
        $q_Bath    = array();
        foreach( $data_Bath as $obj ){ $q_Bath[] = $obj->q_code ; }


        // 美容 Qcode
        $data_Beauty = Beauty::where( 'service_date' , $date )
                              ->where( 'account_id' , $account_id ) 
                              ->get() ;
        $q_Beauty    = array() ;
        foreach( $data_Beauty as $obj ){ $q_Beauty[] = $obj->q_code ; }


        // 安親 Qcode
        $data_Care = Care::where( 'start_date' , $date )
                          ->where( 'account_id' , $account_id )
                          ->get() ;
        $q_Care    = array() ;
        foreach( $data_Care as $obj ){ $q_Care[] = $obj->q_code ; }



        // 合併 _ 以上取得的 Qcode 陣列
        $arr = array_merge( $q_Basic , $q_Bath , $q_Beauty , $q_Care ) ;

        return count( $arr ) > 0 ? $arr : [] ;

    }

    // 查詢 : 特定 [ 到店日期 ] ( 欄位 : service_date ) ，所有服務資料( Ex. 基礎、洗澡、美容、安親、住宿 )
    public function show_Date_Services( $account_id = 1 , $date ){

        // 基礎
        $data_Basic = Basic::with( 'customer' , 'customer_relative' , 'pet' )
                             ->where( 'account_id' , $account_id )
                             ->where( 'service_date' , $date )
                             ->get() ;

        $s_Basic    = array();
        foreach( $data_Basic as $obj ){ $s_Basic[] = $obj ; }


        // 洗澡
        $data_Bath = Bath::with( 'customer' , 'customer_relative' , 'pet' , 'plan' )
                           ->where( 'account_id' , $account_id )
                           ->where( 'service_date' , $date )
                           ->get() ;

        $s_Bath    = array();
        foreach( $data_Bath  as $obj ){ $s_Bath[] = $obj ; }


        // 美容
        $data_Beauty = Beauty::with( 'customer' , 'customer_relative' , 'pet' , 'plan' )
                               ->where( 'account_id' , $account_id )  
                               ->where( 'service_date' , $date )
                               ->get() ;

        $s_Beauty    = array();
        foreach( $data_Beauty  as $obj ){ $s_Beauty[] = $obj ; }


        // 安親
        $data_Care = Care::with( 'customer' , 'customer_relative' , 'pet' )
                           ->where( 'account_id' , $account_id )  
                           ->where( 'start_date' , $date )
                           ->get() ;

        $s_Care    = array();
        foreach( $data_Care  as $obj ){ $s_Care[] = $obj ; }


        // 住宿
        $data_Lodge = Lodge::with( 'customer' , 'customer_relative' , 'pet' )
                             ->where( 'account_id' , $account_id ) 
                             ->where( 'start_date' , $date )
                             ->get() ;

        $s_Lodge    = array();
        foreach(  $data_Lodge  as $obj ){ $s_Lodge[] = $obj ; }


        // 合併
        $arr = array_merge( $s_Basic  , $s_Bath , $s_Beauty , $s_Care , $s_Lodge ) ;

        return $arr ;

    }


    // 查詢 : 特定 [ 付款日期 ] ( 欄位 : payment_date ) ，所有服務資料( 基礎、洗澡、美容、安親、住宿 )
    public function show_Services_By_Paymentdate(  $account_id = 1 , $date ){ 


        // 基礎
        $data_Basic = Basic::with( 'customer' , 'customer_relative' , 'pet' )
                            ->where( 'account_id' , $account_id )
                            ->where( 'payment_date' , $date )
                            ->get() ;

        $s_Basic    = array() ;

        foreach( $data_Basic as $obj ){ $s_Basic[] = $obj ; }
       

        // 洗澡
        $data_Bath = Bath::with( 'customer' , 'customer_relative' , 'pet' , 'plan' )
                          ->where( 'account_id' , $account_id ) 
                          ->where( 'payment_date' , $date )
                          ->get() ;

        $s_Bath    = array() ;

        foreach( $data_Bath  as $obj ){ $s_Bath[] = $obj ; }
      

        // 美容
        $data_Beauty = Beauty::with( 'customer' , 'customer_relative' , 'pet' , 'plan' )
                              ->where( 'account_id' , $account_id )
                              ->where( 'payment_date' , $date )
                              ->get() ;

        $s_Beauty    = array() ;

        foreach( $data_Beauty  as $obj ){ $s_Beauty[] = $obj ; }
        

        // 安親
        $data_Care = Care::with( 'customer' , 'customer_relative' , 'pet' )
                          ->where( 'account_id' , $account_id )
                          ->where( 'payment_date' , $date )
                          ->get() ;

        $s_Care    = array() ;

        foreach( $data_Care  as $obj ){ $s_Care[] = $obj ; }
       

        // 住宿
        $data_Lodge = Lodge::with( 'customer' , 'customer_relative' , 'pet' )
                            ->where( 'account_id' , $account_id )
                            ->where( 'payment_date' , $date )
                            ->get() ;

        $s_Lodge    = array() ;

        foreach(  $data_Lodge  as $obj ){ $s_Lodge[] = $obj ; }


        // 合併
        $arr = array_merge( $s_Basic  , $s_Bath , $s_Beauty , $s_Care , $s_Lodge ) ;

        return $arr ;


    }


    // 查詢 : 特定日期 【 之後 】，所有服務資料( Ex. 基礎、洗澡、美容 ... )
    public function show_After_Date_Services( $date ){

        // 基礎
        $data_Basic = Basic::with('customer' , 'customer_relative' , 'pet' )->where( 'service_date' , '>' , $date )->get() ;
        $s_Basic    = array();
        foreach( $data_Basic as $obj ){ $s_Basic[] = $obj ; }

        // 洗澡
        $data_Bath = Bath::with('customer' , 'customer_relative' , 'pet' )->where( 'service_date' , '>' , $date )->get() ;
        $s_Bath    = array();
        foreach( $data_Bath  as $obj ){ $s_Bath[] = $obj ; }

        // 美容
        $data_Beauty = Beauty::with('customer' , 'customer_relative' , 'pet' )->where( 'service_date' , '>' , $date )->get() ;
        $s_Beauty    = array();
        foreach( $data_Beauty  as $obj ){ $s_Beauty[] = $obj ; }

        // 安親
        $data_Care = Care::with('customer' , 'customer_relative' , 'pet' )->where( 'start_date' , '>' , $date )->get() ;
        $s_Care    = array();
        foreach( $data_Care  as $obj ){ $s_Care[] = $obj ; }

        // 合併
        $arr = array_merge( $s_Basic  , $s_Bath , $s_Beauty , $s_Care  ) ;

        return $arr ;

    }


    // 查詢 : 今日之後，所有 【 預約 】 資料
    public function show_Service_Reservations( $account_id = 1 , $date ){

        // 基礎
        $data_Basic = Basic::with('customer' , 'customer_relative' , 'pet' )
                            ->where( 'account_id' , $account_id )
                            ->where( 'service_date' , '>=' , $date )
                            ->where( function( $query ){
                                $query->where( 'service_status' , '預約_未來' ) ;
                                $query->orWhere( 'service_status' , '預約_今天' ) ;
                            })
                            ->get() ;

        $s_Basic    = array();
        foreach( $data_Basic as $obj ){ $s_Basic[] = $obj ; }

        // 洗澡
        $data_Bath = Bath::with('customer' , 'customer_relative' , 'pet' )
                          ->where( 'account_id' , $account_id )
                          ->where( 'service_date', '>=' , $date )
                          ->where( function( $query ){
                              $query->where( 'service_status' , '預約_未來' ) ;
                              $query->orWhere( 'service_status' , '預約_今天' ) ;
                          })
                          ->get() ;

        $s_Bath    = array();
        foreach( $data_Bath  as $obj ){ $s_Bath[] = $obj ; }

        // 美容
        $data_Beauty = Beauty::with('customer' , 'customer_relative' , 'pet' )
                              ->where( 'account_id' , $account_id )
                              ->where( 'service_date' ,'>=' , $date )
                              ->where( function( $query ){
                                  $query->where( 'service_status' , '預約_未來' ) ;
                                  $query->orWhere( 'service_status' , '預約_今天' ) ;
                              })
                              ->get() ;

        $s_Beauty    = array();
        foreach( $data_Beauty  as $obj ){ $s_Beauty[] = $obj ; }


        // 安親
        $data_Care = Care::with('customer' , 'customer_relative' , 'pet' )
                          ->where( 'account_id' , $account_id )
                          ->where('start_date' , '>=' , $date )
                          ->where('service_status' , '預約安親' )   // '預約安親' 與上述服務不同，再確認 2021.10.07
                          ->get() ;

        $s_Care    = array();
        foreach( $data_Care  as $obj ){ $s_Care[] = $obj ; }


        // 合併
        $arr = array_merge( $s_Basic  , $s_Bath , $s_Beauty , $s_Care  ) ;

        return $arr ;

    }

    // 查詢 : 特定服務_特定資料表 id_ 的 Q 碼
    public function show_Service_Id_Qcode( $service , $id ){

        $q_Arr = [] ;

        if( $service === 'basics' )   $q_Arr = Basic::where( 'basic_id' , $id )->get() ;   // 基礎
        if( $service === 'bathes' )   $q_Arr = Bath::where( 'bath_id' , $id )->get() ;     // 洗澡
        if( $service === 'beauties' ) $q_Arr = Beauty::where( 'beauty_id' , $id )->get() ; // 美容

        return count( $q_Arr ) > 0 ?  $q_Arr[0]['q_code'] : '' ;

    }


    
}
