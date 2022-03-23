<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/* 價格 : FOR 基礎、住宿 ( 共同、不因寵物品種而變動的價格設定 ) */


class Price extends Model{

    protected $table      = 'price' ;     // 設定 _ 資料表為 price ( 非預設 prices )
    protected $primaryKey = 'price_id' ;  // 更改 _ 主鍵名稱為 price_id

    // protected $fillable   = [ 'type' , 'tag' , 'item' , 'price' , 'note' ] ;

    protected $guarded = [] ; // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位




}
