<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



/* 品種 & 價格 ( Species.php 設定的價格，因 '品種' 而有所不同 ; 共同、不因品種而變動的價格，則設定在 Price.php ) */


class Species extends Model{

    protected $table      = 'species' ;
    protected $primaryKey = 'species_id' ;

//    protected $fillable = [
//                              'serial' , 'type' , 'size' , 'fur' , 'species_name' , 'note' ,
//                              'bath_first' , 'bath_single' , 'bath_month' , 'beauty_single' , 'beauty_month'
//                          ] ;

    protected $guarded = [] ; // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位


}
