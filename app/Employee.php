<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


use App\Account ;


class Employee extends Model {



    protected $guarded = [] ; // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位

    // -------------------------------------------

    // @類型 : 建立關係
    
    // 該員工所屬商店
    public function shop_account(){

        return $this->belongsTo( Account::class , 'account_id' , 'account_id' ) ;

    }



}
