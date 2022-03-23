<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Customer_Relation ;  // 匯入 : 客戶_關係人 Model

use App\Pet ;                // 匯入 : 寵物 Model
use App\Basic ;              // 匯入 : 基礎單 Model
use App\Bath ;               // 匯入 : 洗澡單 Model
use App\Beauty ;             // 匯入 : 美容單 Model

/* 客戶  */

class Customer extends Model{

  protected $table      = 'customer' ;     // 設定 _ 資料表為 customer ( 非預設 customers )
  protected $primaryKey = 'customer_id' ;  // 更改 _ 主鍵名稱為 customer_id

  // protected $fillable   = [ 'name' , 'id' , 'mobile_phone' , 'tel_phone' , 'line' , 'email' , 'address' ] ;

  protected $guarded = [] ; // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位


  // 特定客戶 _ 關係人 ( 一對多 )
  public function customer_relation(){
     return $this->hasMany( Customer_Relation::class , 'customer_id' , 'id' ) ;
  }

  // 特定客戶 _ 寵物 ( 一對多 )
  public function pets(){
     return $this->hasMany( Pet::class , 'customer_id' , 'id' ) ;
  }

  // 特定客戶 _ 基礎單紀錄 ( 一對多 )
  public function basics(){
     return $this->hasMany( Basic::class , 'customer_id' , 'id' ) ;
  }

  // 特定客戶 _ 洗澡單紀錄 ( 一對多 )
  public function bathes(){
     return $this->hasMany( Bath::class , 'customer_id' , 'id' ) ;
  }

  // 特定客戶 _ 美容單紀錄 ( 一對多 )
  public function beauties(){
     return $this->hasMany( Beauty::class , 'customer_id' , 'id' ) ;
  }


}
