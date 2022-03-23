<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ServicePrice ;
use App\SpeciesSort ;



// @ 寵物品種
class PetSpecies extends Model {

    protected $guarded = [] ;  // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位

    /* 自訂查詢 ----------------------------------------------------------------------------- */

    // 建立關係 :

    // 服務價格
    public function service_prices(){

       return $this->hasMany( ServicePrice::class , 'species_id' , 'id' ) ;

    }

    // 排列順序
    public function sort_order(){

       return $this->hasOne( SpeciesSort::class , 'pet_id' , 'id' ) ;

    }


}
