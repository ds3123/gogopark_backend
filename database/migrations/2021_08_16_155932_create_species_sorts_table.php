<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpeciesSortsTable extends Migration {

    public function up() {

        Schema::create('species_sorts', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->integer( 'pet_id' )->comment('寵物品種資料表( pet_species ) id') ;


            $table->timestamps();

        });

        // 資料表註解
        DB::statement("ALTER TABLE `species_sorts` comment '紀錄寵物品種 ( pet_species ) 排列順序'") ;

    }


    public function down() {

        Schema::dropIfExists('species_sorts');

    }

}
