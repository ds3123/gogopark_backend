<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer_Relation ;
use App\Customer ;

use Faker\Generator as Faker;

$factory->define(Customer_Relation::class, function (Faker $faker) {

    return [
              'customer_id'  => Customer::all()->random()->id ,
              'type'         => '緊急連絡人' ,
              'tag'          => $faker->randomElement(['父','同學']) ,
              'name'         => $faker->randomElement(['李慶堂','江添財']) ,
              'mobile_phone' => $faker->randomElement(['0952637122', '0933637144', '0910637144', '0922637164' , '0957637133' , '0922637165']) ,
           ];

});
