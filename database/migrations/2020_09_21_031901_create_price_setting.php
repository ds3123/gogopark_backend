<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/*
 *
 *  各項服務價格
 *
 */

class CreatePriceSetting extends Migration {


    public function up() {


        // 如果 Table 已經存在就先 Drop
        Schema::dropIfExists('price');

        Schema::create('price', function (Blueprint $table) {

            $table->bigIncrements('price_id');

            $table->string('type' , 20)->comment('服務類別( Ex. 基礎、洗澡、美容 )');
            $table->string('plan' , 20)->nullable()->comment('服務次分類 / 包月  /方案 / 優惠 ( Ex. 新客優惠、美容包月.. )');
            $table->string('item' , 30)->comment('整體 OR 個別項目( Ex. 修指甲... )');
            $table->integer('price')->comment('單次服務價格');
            $table->string('note' , 60)->nullable()->comment('備註');

            $table->timestamps();

        });

        //  幫 Table 寫入註解
        DB::statement("ALTER TABLE `price` comment '各項服務價格'");


    }


    public function down() {

        Schema::dropIfExists('price');

    }

}
