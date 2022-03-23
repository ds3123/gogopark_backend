<?php

use Illuminate\Database\Seeder;


use App\Bath ;     // 匯入 Bath Model

class BathesSeeder extends Seeder {

    public function run(){

        DB::table('bath')->truncate();           // 先清空資料表 ( 避免每執行一次，都會再增加以下設定的資料筆數 )
        Bath::unguard();                         // 批量賦值 _ 解除
        factory( Bath::class , 10 )->create();   // 利用 Factory 類別，新增 10 筆資料
        Bath::reguard();                         // 批量賦值 _ 設定

    }

}



