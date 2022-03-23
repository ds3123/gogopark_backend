<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Customer ;
use App\Pet ;



// @ 美容師請櫃台向客戶確認 ( 加價 ) 紀錄
class CustomerConfirm extends Model {

   protected $guarded = [] ;


   // 與客戶關聯
   public function customer(){

     return $this->belongsTo(Customer:: class , 'customer_id' , 'id' ) ;

   }

   // 與寵物關聯
   public function pet(){

     return $this->belongsTo(Pet:: class , 'pet_serial' , 'serial' ) ;

   }




}
