<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetSpeciesTable extends Migration {

    public function up() {

        Schema::dropIfExists("pet_species") ;

        Schema::create('pet_species', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('name',40)->comment('品種名稱') ;

            $table->string('serial',10)->nullable()->comment('代碼( Ex. 01、02 ... )') ;
            $table->string('character',10)->nullable()->comment('代號( Ex. HS、GR ... )') ;

            $table->string('size',10)->nullable()->comment('體型( Ex. 大、中、小型 ... )') ;
            $table->string('fur',10)->nullable()->comment('毛髮( Ex. 長毛、短毛 ... )') ;

            $table->string('note',50)->nullable()->comment('備註') ;

            $table->timestamps();

        });

        //  幫 Table 寫入註解
        DB::statement( "ALTER TABLE `pet_species` comment '寵物品種'" ) ;

    }

    public function down()
    {
        Schema::dropIfExists('pet_species');
    }
}
