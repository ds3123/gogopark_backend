<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pet;
use App\Customer;
use Faker\Generator as Faker;




$factory->define(Pet::class, function (Faker $faker) {

    return [
              'customer_id' => Customer::all()->random()->id ,
              'serial'      => $faker->randomElement(['P_20210616_123', 'P_20210603_723', 'P_20210511_433', 'P_20210606_838' , 'P_20210203_622' , 'P_20210112_333']) ,
              'species'     => $faker->randomElement(['比利時狼犬', '長毛吉娃娃', '秋田犬', '德國狼犬' , '貴賓' , '可卡' , '米格魯' , '哈士奇']) ,
              'name'        => $faker->randomElement(['旺福', 'Money', '大胖', 'BOBO' , '小白' , '乖乖' , '阿吉' , '小可愛']) ,
              'sex'        => $faker->randomElement(['公', '母']) ,
          ] ;
});
