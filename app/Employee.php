<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {



    protected $guarded = [] ; // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位

    // -------------------------------------------

    // @類型 : 建立關係



}
