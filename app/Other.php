<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


// @ 其他收支項目
class Other extends Model{
 
    
    protected $guarded = [] ; // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位



}
