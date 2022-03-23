<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


use App\PlanUsedRecords ;


/* 美容單  */

class Beauty extends Model {

    protected $table      = 'beauty' ;     // 設定 _ 資料表為 beauty ( 非預設 beautys )
    protected $primaryKey = 'beauty_id' ;  // 更改 _ 主鍵名稱為 beauty_id

//    protected $fillable   = [
//
//                              'service_status' , 'service_date' , 'q_code' , 'expected_arrive' , 'actual_arrive' , 'expected_leave' , 'way_arrive' , 'way_leave' ,
//                              'customer_id' , 'pet_id' , 'common_data' , 'obj_other' , 'admin_note' ,
//
//                              'bath_1' , 'bath_2' , 'bath_3' , 'bath_4' , 'bath_5' , 'bath_6' ,
//                              'b_body' , 'b_head' , 'b_ear' , 'b_tail' , 'b_foot' , 'b_other' ,
//                              'fur' , 'flea' , 'basic' ,
//
//                              'admin_user' , 'shop_status' ,
//                              'beautician' , 'report' , 'wait_way' , 'wait_time' , 'beautician_star' , 'beautician_note'
//
//                             ] ;

    protected $guarded = [] ; // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位


    // @類型 : 建立關係
    // ~ 客戶
    public function customer(){

        return $this->belongsTo(Customer::class , 'customer_id' , 'id' ) ;

    }

    // ~ 客戶 _ 關係人
    public function customer_relative(){

        return $this->belongsTo(Customer_Relation::class , 'customer_id' , 'customer_id' ) ;

    }


    // ~ 寵物
    public function pet(){

        return $this->belongsTo( Pet::class , 'pet_id' , 'serial' ) ;

    }


    // ~ 方案 ( Ex. 包月洗澡 ) 使用紀錄
    public function plan(){

        return $this->hasOne( PlanUsedRecords::class , 'service_id' , 'beauty_id' ) ;

    }


     // ~ 服務異常
     public function serviceError(){

        return $this->hasMany( ServiceErrorRecords::class , 'service_id' , 'beauty_id' ) ;
 
     }



}
