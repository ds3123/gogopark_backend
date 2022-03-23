<?php

use Illuminate\Database\Seeder;


use App\Basic ;     // 匯入 Basic Model

class BasicsSeeder extends Seeder {

    public function run() {

        DB::table('basic')->truncate();           // 先清空資料表 ( 避免每執行一次，都會再增加以下設定的資料筆數 )

        Basic::unguard();                         // 批量賦值 _ 解除

        factory( Basic::class , 5 )->create();   // 利用 Factory 類別，新增 10 筆資料

        Basic::reguard();                         // 批量賦值 _ 設定

    }

}



