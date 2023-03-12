<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/* 客戶關係人 */


class Customer_Relation extends Model {

  protected $table      = 'customer_relation' ;  // 設定 _ 資料表為 customer_relation ( 非預設 customer_relations )
  protected $primaryKey = 'relation_id' ;        // 更改 _ 主鍵名稱為 relation_id

  protected $guarded    = [] ; // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位


    // ----------------------------------------------------------------------------------------------------------------

    // @類型 : 建立關係
    // ~ 客戶
    public function customer(){

        // return $this->hasOne( Customer::class , 'id' ) ;
        return $this->belongsTo( Customer::class , 'customer_id' , 'id' ) ;

    }


}
