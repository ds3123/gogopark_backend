<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/* 基礎單 */

class Basic extends Model {

    protected $table      = 'basic' ;     // 設定 _ 資料表為 basic ( 非預設 basics )
    protected $primaryKey = 'basic_id' ;  // 更改 _ 主鍵名稱為 basic_id

// public $timestamps = false ;           // 關閉 _ 時間戳記 ( created_at 與 updated_at )

//    protected $fillable   = [
//                              'service_status' , 'service_date' , 'q_code' , 'expected_arrive' , 'actual_arrive' , 'expected_leave' , 'way_arrive' , 'way_leave' ,
//                              'customer_id' , 'pet_id' ,
//                              'customer_object' , 'customer_object_other' , 'customer_note' , 'admin_note' ,
//                              'basic_data' , 'basic_foot' ,
//                              'basic_fee' , 'pickup_fee' ,
//                              'admin_user' , 'shop_status' , 'beautician' , 'report' , 'wait_way' , 'wait_time' , 'beautician_star' , 'beautician_note'
//                            ] ;

    protected $guarded = [] ; // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位

    // ----------------------------------------------------------------------------------------------------------------

    // @類型 : 建立關係
    // ~ 客戶
    public function customer(){

      // return $this->hasOne( Customer::class , 'id' ) ;
      return $this->belongsTo(Customer::class , 'customer_id' , 'id' ) ;

    }

    // ~ 客戶 _ 關係人
    public function customer_relative(){

        return $this->belongsTo( Customer_Relation::class , 'customer_id' , 'customer_id' ) ;

    }

    // ~ 寵物
    public function pet(){

      return $this->belongsTo( Pet::class , 'pet_id' , 'serial' ) ;

    }

    // ~ 服務異常
    public function serviceError(){

       return $this->hasMany( ServiceErrorRecords::class , 'service_id' , 'basic_id' ) ;

    }


    // ~ 加價單
    public function extra_fee(){

      return $this->hasMany( Extra_Fee::class , 'service_id' , 'basic_id' ) ;

    }






}
