<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/*
 *
 *
 *  @ 寵物資料
 *
 *
 */



class CreatePetsTable extends Migration {


    public function up() {

        // 如果 Table 已經存在就先 Drop
        Schema::dropIfExists('pet');

        Schema::create('pet', function (Blueprint $table) {

            $table->bigIncrements('pet_id');

            $table->string('customer_id' , 20 )->comment('客戶身分證字號');
            $table->string('serial' , 20 )->comment('寵物編號');

            $table->string('species' ,20 )->comment('品種');
            $table->string('name' , 20 )->comment('名字');
            $table->string('sex' , 20 )->nullable()->comment('公 / 母');
            $table->string('color' , 20 )->nullable()->comment('毛色');
            $table->integer('weight' )->nullable()->comment('體重');
            $table->integer('age' )->nullable()->comment('年齡');

            $table->string('injection' , 30 )->nullable()->comment('每年預防注射');
            $table->string('flea' , 30 )->nullable()->comment('滴除蚤');
            $table->string('ligate' , 30 )->nullable()->comment('結 紮');
            $table->string('chip' , 30 )->nullable()->comment('晶 片');
            $table->string('infection' , 30 )->nullable()->comment('傳染病');
            $table->string('together' , 30 )->nullable()->comment('與其他狗共處');
            $table->string('drug' , 30 )->nullable()->comment('服藥中');
            $table->string('bite' , 30 )->nullable()->comment('咬 人');
            $table->string('health' , 30 )->nullable()->comment('健 康');
            $table->string('feed' , 30 )->nullable()->comment('餵食方式');
            $table->string('toilet' , 30 )->nullable()->comment('如廁方式');
            $table->string('ownerProvide' , 30 )->nullable()->comment('飼主提供');

            $table->text('note' )->nullable()->comment('備註事項');

            $table->timestamps();

        });

        //  幫 Table 寫入註解
        DB::statement("ALTER TABLE `pet` comment '寵物資料'");

    }

    public function down() {

        Schema::dropIfExists('pet');

    }
}
