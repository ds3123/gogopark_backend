<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model {


    protected $guarded = [] ;               // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位

    protected $primaryKey = 'account_id' ;  // 更改 _ 主鍵名稱為 account_id


    // -------------------------------------------

    // @類型 : 建立關係



}
