<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {

    return [
               'name'         => $faker->randomElement(['李國豪', '張佩芬', '李雪琴', '黃玉芬' , '陳佳君' , '謝佩珊' , '黃珮君' , '李婉婷']) ,
               'id'           => $faker->randomElement(['D121700125', 'F141702121', 'R141702133', 'S141743111' , 'G141702255' , 'B1417341356']) ,
               'mobile_phone' => $faker->randomElement(['0952637122', '0933637144', '0910637144', '0922637164' , '0957637133' , '0922637165']) ,
               'email'        => $faker->email ,
           ] ;

});
