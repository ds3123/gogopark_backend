<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PetSpecies ;


// @ 各項服務 _ 價格
class ServicePrice extends Model {

    protected $guarded = [] ; // 直接設定 $guarded 為空陣列，就不用在 $fillable 中一一列出欄位

    /* 自訂查詢 ----------------------------------------------------------------------------- */

    // 建立關係 : 寵物品種
    public function pet_species(){

        return $this->belongsTo(PetSpecies::class , 'species_id' , 'id' ) ;

    }

}
