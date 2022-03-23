<?php

use Illuminate\Database\Seeder;



use App\Customer ;     // 匯入 Customer Model


class CustomersSeeder extends Seeder {

    public function run() {

        DB::table('customer')->truncate();           // 先清空資料表 ( 避免每執行一次，都會再增加以下設定的資料筆數 )
        Customer::unguard();                         // 批量賦值 _ 解除
        factory( Customer::class , 10 )->create();   // 利用 Factory 類別，新增 10 筆資料
        Customer::reguard();                         // 批量賦值 _ 設定

    }

}
