<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/* 時間紀錄 ( 美容區中，美容師所點選的基礎、洗澡、美容 _ 時間按鈕 ) */
class Time_Records extends Model{

   protected $table = 'time_records' ;

   protected $guarded = [] ; // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位


}
