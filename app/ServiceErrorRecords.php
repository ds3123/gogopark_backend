<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


//  @ for 服務異常處理紀錄
class ServiceErrorRecords extends Model{
    
    public $guarded = [] ;

    // ----------------------


   // ~ 客戶 _ 關係人
    public function customer_relative(){

        return $this->belongsTo(Customer_Relation::class , 'customer_id' , 'customer_id' ) ;

    }



}
