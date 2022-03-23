<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Customer ;  // 匯入 : 客戶 Model


/* 寵物 */

class Pet extends Model {

    protected $table      = 'pet' ;     // 設定 _ 資料表為 pet ( 非預設 pets )
    protected $primaryKey = 'pet_id' ;  // 更改 _ 主鍵名稱為 pet_id

//    protected $fillable   = [
//                              'customer_id' , 'serial' , 'species' , 'name' , 'sex' , 'color' , 'weight' , 'age' ,
//                              'injection' , 'flea' , 'ligate' , 'chip' , 'infection' , 'together' , 'drug' , 'bite' , 'health' , 'feed' , 'toilet' ,
//                              'ownerProvide' , 'note'
//                             ] ;

    protected $guarded = [] ; // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位


    // 特定寵物 _ 客戶 ( 一對一 )
    public function customer(){

      return $this->belongsTo( Customer::class , 'customer_id' , 'id' ) ;

    }

    // 特定寵物 _ 客戶關係人
    public function customer_relative(){

        return $this->belongsTo(Customer_Relation::class , 'customer_id' , 'customer_id' ) ;

    }




}
