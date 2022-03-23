<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


// @ 方案 ( Ex. 包月洗澡 ) 使用紀錄
class PlanUsedRecords extends Model {

    protected $guarded = [] ; // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位

    // ------------------------------------------------------------------------


}
