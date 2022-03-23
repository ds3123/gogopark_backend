<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Customer ;
use App\PetSpecies ;
use App\PlanUsedRecords ;
use App\CustomPlan ;


/* 方案  */
class Plan extends Model {

     protected $guarded = [] ; // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位

    // -------------------------------------------

    // @類型 : 建立關係

      // 客戶資料 ( 資料表 : customer )
      public function customer(){

          return $this->belongsTo( Customer::class , 'customer_id' , 'id' ) ;

      }


      // 客戶關係人資料 ( 資料表 : customer_relation )
      public function customer_relative(){

          return $this->belongsTo( Customer_Relation::class , 'customer_id' , 'customer_id' ) ;

      }

      // 寵物資料 ( 資料表 : pet )
      public function pet(){

          return $this->belongsTo( Pet::class , 'apply_pet_serial' , 'serial' ) ;

      }


      // 寵物品種資料 ( 資料表 : pet_species )
      public function pet_species(){

          return $this->belongsTo( PetSpecies::class , 'pet_species_id' , 'id'  ) ;

      }


      // 自訂方案資料 ( 資料表 : custom_plan )
      public function custom_plan(){

        return $this->belongsTo( CustomPlan::class , 'plan_type' , 'plan_name'  ) ;

      }

      // 方案 _ 使用紀錄 ( 資料表 : plan_used_records )
      public function plan_used_records(){

          return $this->hasMany( PlanUsedRecords :: class , 'plan_id' , 'id' ) ;

      }



}
