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


    // 查詢 : 部分 _ 服務 + 客戶 + 客戶關係人 + 寵物 ( 參數 : 是否封存 )
    public function show_With_Cus_Relative_Pet( $account_id = 1 , $is_Archive , $data_Num = 50 ){

        $basic_Arr  = Basic::with( [ 
                                      'customer' => function( $query ){ $query->select( 'name' , 'id' , 'mobile_phone' );  } ,
                                      'pet'      => function( $query ){ $query->select( 'customer_id' , 'serial' , 'name' , 'species', 'birthday' , 'sex' , 'color' );  } 
                                   ] )
                             // ->select( 'customer_id' , 'basic_id' , 'service_type' , 'service_date' , 'q_code' , 'pet_id' ,
                             //           'basic_fee' , 'self_adjust_amount' , 'pickup_fee' ,
                             //           'amount_payable' , 'amount_paid' , 'payment_type' , 'beautician_note' , 'created_at' )  
                             ->orderBy( 'service_date' , 'desc' )    // 依 : 來店日期      
                             ->limit( $data_Num )
                             ->where( 'account_id' , $account_id )
                             ->where( 'is_archive' , $is_Archive )
                             ->get() ;


        $bath_Arr   = Bath::with( [ 
                                     'customer' => function( $query ){ $query->select( 'name' , 'id' , 'mobile_phone' );  } ,
                                     'pet'     => function( $query ){ $query->select( 'customer_id' , 'serial' , 'name' , 'species' , 'birthday'  , 'sex' , 'color' , 
                                                                                      'single_bath_price' , 'single_beauty_price' , 'month_bath_price' , 'month_beauty_price' );  } ,
                                     'plan'    => function( $query ){  $query->select( 'id' , 'service_id' , 'service_note' ); } 
                                  ] )
                            // ->select( 'bath_id' , 'customer_id' , 'bath_id' , 'service_type' , 'service_date' , 'q_code' , 'pet_id' ,
                            //            'bath_fee' , 'self_adjust_amount' , 'extra_service_fee' , 'extra_beauty_fee' , 'pickup_fee' , 'bath_month_fee' , 
                            //            'amount_payable' , 'amount_paid' , 'payment_type' , 'beautician_note' , 'created_at' )
                            ->orderBy( 'service_date' , 'desc' )    // 依 : 來店日期                 
                            ->limit( $data_Num )
                            ->where( 'account_id' , $account_id )
                            ->where( 'is_archive' , $is_Archive )
                            ->get() ;


        $beauty_Arr = Beauty::with( [  
                                       'customer' => function( $query ){ $query->select( 'name' , 'id' , 'mobile_phone' ) ; } ,
                                       'pet'      => function( $query ){ $query->select( 'customer_id' , 'serial' , 'name' , 'species' , 'birthday'   , 'sex' , 'color' ,
                                                                                          'single_bath_price' , 'single_beauty_price' , 'month_bath_price' , 'month_beauty_price' ); },
                                       'plan'     => function( $query ){ $query->select( 'id' , 'service_id' , 'service_note' );  }
                                     ] )
                            //   ->select(  'beauty_id' , 'customer_id' , 'beauty_id' , 'service_type' , 'service_date' , 'q_code' , 'pet_id' , 
                            //             'beauty_fee' , 'self_adjust_amount' , 'extra_service_fee' , 'pickup_fee' , 'beauty_month_fee' ,
                            //             'amount_payable' , 'amount_paid' , 'payment_type' , 'beautician_note' , 'created_at' )
                              ->orderBy( 'service_date' , 'desc' )    // 依 : 來店日期                
                              ->limit( $data_Num )
                              ->where( 'account_id' , $account_id )
                              ->where( 'is_archive' , $is_Archive )
                              ->get() ;


                              
        // $basic_Arr  = Basic::with( 'customer' , 'pet' )
        //                      ->select( 'customer_id' , 'basic_id' , 'service_type' , 'service_date' , 'q_code' , 'pet_id' )  
        //                      ->orderBy( 'service_date' , 'desc' )    // 依 : 來店日期      
        //                      ->limit( $data_Num )
        //                      ->where( 'is_archive' , $is_Archive )
        //                      ->get() ;
 
        // $bath_Arr   = Bath::with( 'customer' , 'pet' , 'plan' )
        //                     ->select(  'customer_id' , 'bath_id' , 'service_type' , 'service_date' , 'q_code' , 'pet_id' )
        //                     ->orderBy( 'service_date' , 'desc' )    // 依 : 來店日期  
        //                     ->limit( $data_Num )
        //                     ->where( 'is_archive' , $is_Archive )
        //                     ->get() ;
 
        // $beauty_Arr = Beauty::with( 'customer'  , 'pet' , 'plan' )
        //                     ->select( 'customer_id' , 'beauty_id' , 'service_type' , 'service_date' , 'q_code' , 'pet_id' )
        //                     ->orderBy( 'service_date' , 'desc' )    // 依 : 來店日期    
        //                     ->limit( $data_Num )
        //                     ->where( 'is_archive' , $is_Archive )
        //                     ->get() ;                      

        
        
        $arr = array() ;

        forEach( $basic_Arr as $basic ){   $arr[] = $basic;  }
        forEach( $bath_Arr as $bath ){     $arr[] = $bath;   }
        forEach( $beauty_Arr as $beauty ){ $arr[] = $beauty; }


        return $arr ;

    }

    // 查詢 : 所有 _ 服務 + 客戶 + 客戶關係人 + 寵物 ( 參數 : 是否封存 )
    public function show_All_With_Cus_Relative_Pet( $account_id = 1 , $is_Archive ){


        $basic_Arr  = Basic::with( [ 
                                       'customer' => function( $query ){ $query->select( 'name' , 'id' , 'mobile_phone' );  } ,
                                       'pet'      => function( $query ){ $query->select( 'customer_id' , 'serial' , 'name' , 'species' , 'birthday'  ,  'sex' , 'color' ); } 
                                    ] )
                            //  ->select( 'customer_id' , 'service_type' , 'service_date' , 'q_code' , 'pet_id' ,
                            //             'basic_fee' , 'self_adjust_amount' , 'pickup_fee' , 
                            //             'amount_payable' , 'amount_paid' , 'payment_type' , 'beautician_note' , 'created_at' )  
                             ->orderBy( 'service_date' , 'desc' )    // 依 : 來店日期                 
                             ->where( 'account_id' , $account_id )
                             ->where( 'is_archive' , $is_Archive )
                             ->get() ;


        $bath_Arr   = Bath::with( [ 
                                      'customer' => function( $query ){ $query->select( 'name' , 'id' , 'mobile_phone' ); } ,
                                      'pet'      => function( $query ){ $query->select( 'customer_id' , 'serial' , 'name' , 'species' , 'sex' , 'birthday'  , 'color' ,
                                                                                        'single_bath_price' , 'single_beauty_price' , 'month_bath_price' , 'month_beauty_price' ); } ,
                                      'plan'     => function( $query ){ $query->select( 'id' , 'service_id' , 'service_note' ); } 
                                  ] )
                            // ->select( 'bath_id' , 'customer_id'  , 'service_type' , 'service_date' , 'q_code' , 'pet_id' ,
                            //           'bath_fee' , 'self_adjust_amount' , 'extra_service_fee' , 'extra_beauty_fee' , 'pickup_fee' , 'bath_month_fee' ,
                            //           'amount_payable' , 'amount_paid' , 'payment_type' , 'beautician_note' , 'created_at' ) 
                            ->orderBy( 'service_date' , 'desc' )    // 依 : 來店日期      
                            ->limit( 500 )        // 先限制在 500 筆資料  2022.04.06   
                            ->where( 'account_id' , $account_id )
                            ->where( 'is_archive' , $is_Archive )
                            ->get() ;


        $beauty_Arr = Beauty::with( [
                                      'customer' => function( $query ){ $query->select( 'name' , 'id' , 'mobile_phone' ); } ,
                                      'pet'      => function( $query ){ $query->select( 'customer_id' , 'serial' , 'name' , 'species' , 'sex' , 'birthday' , 'color' , 
                                                                                        'single_bath_price' , 'single_beauty_price' , 'month_bath_price' , 'month_beauty_price' );  } ,
                                      'plan'     => function( $query ){ $query->select( 'id' , 'service_id' , 'service_note' );  } 
                                    ] )
                            //   ->select( 'beauty_id' ,'customer_id' , 'service_type' , 'service_date' , 'q_code' , 'pet_id' , 
                            //             'beauty_fee' , 'self_adjust_amount' , 'extra_service_fee' , 'pickup_fee' , 'beauty_month_fee' ,
                            //             'amount_payable' , 'amount_paid' , 'payment_type' , 'beautician_note'  , 'created_at' )
                              ->orderBy( 'service_date' , 'desc' )    // 依 : 來店日期      
                              ->limit( 500 )     // 先限制在 500 筆資料  2022.04.06     
                              ->where( 'account_id' , $account_id )
                              ->where( 'is_archive' , $is_Archive )
                              ->get() ;



        // $basic_Arr  = Basic::with( 'customer' , 'pet' )
        //                      ->select(  'customer_id' , 'basic_id' , 'service_type' , 'service_date' , 'q_code' , 'pet_id' ) 
        //                      ->where( 'is_archive' , $is_Archive )
        //                      ->get() ;
 
        // $bath_Arr   = Bath::with( 'customer' , 'pet' , 'plan' )
        //                     ->select( 'customer_id' , 'bath_id' , 'service_type' , 'service_date' , 'q_code' , 'pet_id' ) 
        //                     ->where( 'is_archive' , $is_Archive )
        //                     ->get() ;
 
        // $beauty_Arr = Beauty::with( 'customer' , 'pet' , 'plan' )
        //                       ->select( 'customer_id' , 'beauty_id' , 'service_type' , 'service_date' , 'q_code' , 'pet_id' )
        //                       ->where( 'is_archive' , $is_Archive )
        //                       ->get() ;                      



        $arr        = array() ;
        forEach( $basic_Arr as $basic ){   $arr[] = $basic;  }
        forEach( $bath_Arr as $bath ){     $arr[] = $bath;   }
        forEach( $beauty_Arr as $beauty ){ $arr[] = $beauty; }

        return $arr ;

    }


    // 查詢 : 所有 _ 服務 + 客戶 + 客戶關係人 + 寵物 ( 與上述相似  / 參數 : 是否服務異常 )
    public function show_Services_by_Error( $is_Error ){

        $basic_Arr  = Basic::with('customer' , 'customer_relative' , 'pet' , 'serviceError' )
                      ->where('is_error' , $is_Error )
                      ->get() ;

        $bath_Arr   = Bath::with('customer' , 'customer_relative' , 'pet' , 'plan' , 'serviceError' )
                      ->where('is_error' , $is_Error )
                      ->get() ;

        $beauty_Arr = Beauty::with('customer' , 'customer_relative' , 'pet' , 'plan' , 'serviceError')
                      ->where('is_error' , $is_Error )
                      ->get() ;


        $lodge_Arr  = Lodge::with( 'customer' , 'customer_relative' , 'pet' , 'serviceError')
                      ->where('is_error' , $is_Error )
                      ->get() ;            

        $care_Arr   = Care::with( 'customer' , 'customer_relative' , 'pet' , 'serviceError')
                      ->where('is_error' , $is_Error )
                      ->get() ;                  



        $arr        = array() ;

        forEach( $basic_Arr as $basic ){   $arr[] = $basic;  }
        forEach( $bath_Arr as $bath ){     $arr[] = $bath;   }
        forEach( $beauty_Arr as $beauty ){ $arr[] = $beauty; }
        
        forEach( $lodge_Arr as $lodge ){ $arr[] = $lodge; }
        forEach( $care_Arr as $care ){ $arr[] = $care; }

        return $arr ;

    }

     // 查詢 : 所有 _ 服務 + 客戶 + 客戶關係人 + 寵物 ( 與上述相似  / 參數 : 是否銷單 )
     public function show_Services_by_Delete( $is_Delete ){

        $basic_Arr  = Basic::with( 'customer' , 'customer_relative' , 'pet' )
                      ->where( 'is_delete' , $is_Delete )
                      ->get() ;

        $bath_Arr   = Bath::with( 'customer' , 'customer_relative' , 'pet' , 'plan' )
                      ->where( 'is_delete' , $is_Delete )
                      ->get() ;

        $beauty_Arr = Beauty::with( 'customer' , 'customer_relative' , 'pet' , 'plan' )
                      ->where( 'is_delete' , $is_Delete )
                      ->get() ;

        $arr        = array() ;

        forEach( $basic_Arr as $basic ){   $arr[] = $basic;  }
        forEach( $bath_Arr as $bath ){     $arr[] = $bath;   }
        forEach( $beauty_Arr as $beauty ){ $arr[] = $beauty; }

        return $arr ;

    }

    // 特定日期，為 "銷單( is_delete )" 、 "異常( is_error )" 的服務單
    public function show_Services_Is_Delete_Error_By_Date( $date ){

        $basic_Arr  = Basic::with( 'customer' , 'pet' )
                           ->where( 'service_date' ,  $date )
                           ->where( function( $query ){
                               $query->where( 'is_delete' , 1  ) ;  
                               $query->orWhere( 'is_error' , 1  ) ;
                             })
                           ->get() ;

        $bath_Arr   = Bath::with( 'customer' , 'pet'  )
                          ->where( 'service_date' , $date )
                          ->where( function( $query ){
                               $query->where( 'is_delete' , 1  ) ;  
                               $query->orWhere( 'is_error' , 1  ) ;
                            })
                          ->get() ;

        $beauty_Arr = Beauty::with( 'customer' , 'pet' )
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
    public function show_Date_Qcode( $date ){

        // 基礎 Qcode
        $data_Basic = Basic::where( 'service_date' , $date )->get() ;
        $q_Basic    = array();
        foreach( $data_Basic  as $obj ){ $q_Basic[] = $obj->q_code ; }

        // 洗澡 Qcode
        $data_Bath = Bath::where( 'service_date' , $date )->get() ;
        $q_Bath    = array();
        foreach( $data_Bath  as $obj ){ $q_Bath[] = $obj->q_code ; }

        // 美容 Qcode
        $data_Beauty = Beauty::where( 'service_date' , $date )->get() ;
        $q_Beauty    = array();
        foreach( $data_Beauty  as $obj ){ $q_Beauty[] = $obj->q_code ; }

        // 安親 Qcode
        $data_Care = Care::where( 'start_date' , $date )->get() ;
        $q_Care    = array();
        foreach( $data_Care  as $obj ){ $q_Care[] = $obj->q_code ; }

        // 合併 _ 以上取得的 Qcode 陣列
        $arr = array_merge( $q_Basic , $q_Bath , $q_Beauty , $q_Care ) ;

        return count( $arr ) > 0 ? $arr : [] ;

    }

    // 查詢 : 特定 “到店日期”，所有服務資料( Ex. 基礎、洗澡、美容、安親、住宿 )
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


    // 查詢 : 特定 “付款日期”，所有服務資料( 基礎、洗澡、美容、安親、住宿 )
    public function show_Services_By_Paymentdate( $date ){ 


        // 基礎
        $data_Basic = Basic::with( 'customer' , 'customer_relative' , 'pet' )->where( 'payment_date' , $date )->get() ;
        $s_Basic    = array();
        foreach( $data_Basic as $obj ){ $s_Basic[] = $obj ; }
       

        // 洗澡
        $data_Bath = Bath::with( 'customer' , 'customer_relative' , 'pet' , 'plan' )->where( 'payment_date' , $date )->get() ;
        $s_Bath    = array();
        foreach( $data_Bath  as $obj ){ $s_Bath[] = $obj ; }
      

        // 美容
        $data_Beauty = Beauty::with( 'customer' , 'customer_relative' , 'pet' , 'plan' )->where( 'payment_date' , $date )->get() ;
        $s_Beauty    = array();
        foreach( $data_Beauty  as $obj ){ $s_Beauty[] = $obj ; }
        

        // 安親
        $data_Care = Care::with( 'customer' , 'customer_relative' , 'pet' )->where( 'payment_date' , $date )->get() ;
        $s_Care    = array();
        foreach( $data_Care  as $obj ){ $s_Care[] = $obj ; }
       

        // 住宿
        $data_Lodge = Lodge::with( 'customer' , 'customer_relative' , 'pet' )->where( 'payment_date' , $date )->get() ;
        $s_Lodge    = array();
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
    public function show_Service_Reservations( $date ){

        // 基礎
        $data_Basic = Basic::with('customer' , 'customer_relative' , 'pet' )
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
