<?php

 /* @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Basic;
use App\Customer;
use App\Pet;
use Faker\Generator as Faker;

$factory->define(Basic::class, function (Faker $faker) {

    return [
              'service_type'   => '基礎' ,
              'service_status' => '已到店' ,
              // 目前日期，往後在 1~15 內，隨機日期
              'service_date'   => date('Y-m-d', strtotime('now +' . $this->faker->numberBetween(1,15) . ' days')),
              'q_code'         => $faker->randomElement(['01','03','44','23','15','19','27','42','34']) ,
              'customer_id'    => Customer::all()->random()->id ,
              'pet_id'         => Pet::all()->random()->serial ,
              'shop_status'    => $faker->randomElement(['到店等候中' , '到店美容中' , '洗完等候中' , '已回家( 房 )']) ,
           ] ;

});
