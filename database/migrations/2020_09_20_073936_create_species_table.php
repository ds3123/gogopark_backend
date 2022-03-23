<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/*
 *
 *
 *  @ 品種 & (相對應) 價格
 *
 *
 */

class CreateSpeciesTable extends Migration {

    public function up() {

        // 如果 Table 已經存在就先 Drop
        Schema::dropIfExists('species');

        Schema::create('species', function (Blueprint $table) {

            $table->bigIncrements('species_id');

            $table->string('serial' ,20 )->comment('代碼( 01、02、03.... )');
            $table->string('type' , 20 )->nullable()->comment('代號( G、K .... )');
            $table->string('size' , 20 )->nullable()->comment('體型( 大、中、小型 )');
            $table->string('fur' , 20 )->comment('毛量( 長毛、短毛 )');
            $table->string('species_name' , 20 )->comment('品種名稱');
            $table->string('note' , 20 )->nullable()->comment('備註');

            $table->integer('bath_first')->comment('洗澡價格_初次優惠');
            $table->integer('bath_single')->comment('洗澡價格_單次');
            $table->integer('bath_month')->comment('洗澡價格_包月');
            $table->integer('beauty_single')->comment('美容價格_單次');
            $table->integer('beauty_month')->comment('美容價格_包月');

            $table->timestamps();

        });

        //  幫 Table 寫入註解
        DB::statement("ALTER TABLE `species` comment '品種 & (相對應) 價格'");

    }


    public function down() {

        Schema::dropIfExists('species');

    }

}
