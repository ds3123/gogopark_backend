<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


// @ 服務單建立後，額外新增 _ 加價單
class Extra_Fee extends Model{
 
    
    protected $table      = 'extra_fee' ;     // 設定 _ 資料表為 extra_fee ( 非預設 extra_fees )
    protected $primaryKey = 'extra_fee_id' ;  // 更改 _ 主鍵名稱為 extra_fee_id
    protected $guarded    = [] ;              // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位

    // ----------------------------------------------------------------------------------------------------------------

    // @類型 : 建立關係


     // 基礎單
     public function basic(){

        return $this->belongsTo( Basic::class , 'service_id' , 'basic_id' ) ;

     }
     
     // 洗澡單
     public function bath(){

        return $this->belongsTo( Bath::class , 'service_id' , 'bath_id' ) ;

     }
     
     // 美容單 
     public function beauty(){

        return $this->belongsTo( Beauty::class , 'service_id' , 'beauty_id' ) ;

     }  
  
    








}
