<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


// @ 方案 ( Ex. 包月洗澡 ) 使用紀錄
class PlanUsedRecords extends Model {

    protected $guarded = [] ; // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位

    // ------------------------------------------------------------------------

    // @類型 : 建立關係

    // 該方案使用紀錄，所屬 _ 洗澡單 ( 資料表 : bath )
    public function bath(){

       return $this->belongsTo( Bath::class , 'service_id' , 'bath_id' ) ;

    }

    // 該方案使用紀錄，所屬 _ 美容單 ( 資料表 : beauty )
    public function beauty(){

       return $this->belongsTo( Beauty::class , 'service_id' , 'beauty_id' ) ;
 
    }

    // 該方案使用紀錄，所屬 _ 方案 ( 資料表 : plans )
    public function plan(){

      return $this->belongsTo( Plan::class , 'plan_id' , 'id' ) ;

    }


}
