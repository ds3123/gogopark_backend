<?php

namespace App;

use App\PetSpecies ;

// @ for 紀錄 _ 寵物品種列表 : 排列順序
use Illuminate\Database\Eloquent\Model;

class SpeciesSort extends Model {

   public $guarded = [] ;

   // ----------------------


   // 寵物品種資料
   public function pet_species(){

      return $this->belongsTo( PetSpecies :: class , 'pet_id' , 'id' ) ;

   }




}
