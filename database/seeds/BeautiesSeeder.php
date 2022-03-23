<?php

use Illuminate\Database\Seeder;


use App\Beauty ;     // 匯入 Beauty Model

class BeautiesSeeder extends Seeder {

    public function run() {

        DB::table('beauty')->truncate();           // 先清空資料表 ( 避免每執行一次，都會再增加以下設定的資料筆數 )
        Beauty::unguard();                         // 批量賦值 _ 解除
        factory( Beauty::class , 10 )->create();   // 利用 Factory 類別，新增 10 筆資料
        Beauty::reguard();                         // 批量賦值 _ 設定

    }

}





