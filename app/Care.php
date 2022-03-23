<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


use App\Customer ;
use App\Customer_Relation ;
use App\Pet ;


/*  安親單  */

class Care extends Model {

    protected $guarded = [] ; // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位

    // -------------------------------------------

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

    // ~ 服務異常
    public function serviceError(){

        return $this->hasMany( ServiceErrorRecords::class , 'service_id' , 'id' ) ;
 
     }






}
