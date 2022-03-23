<?php

use Illuminate\Database\Seeder;


use App\Pet ;     // 匯入 Pet Model

class PetsSeeder extends Seeder {

    public function run() {

        DB::table('pet')->truncate();           // 先清空資料表 ( 避免每執行一次，都會再增加以下設定的資料筆數 )
        Pet::unguard();                         // 批量賦值 _ 解除
        factory( Pet::class , 10 )->create();   // 利用 Factory 類別，新增 10 筆資料
        Pet::reguard();                         // 批量賦值 _ 設定

    }

}
