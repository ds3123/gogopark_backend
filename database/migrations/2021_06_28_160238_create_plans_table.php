<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration {


    public function up() {

        // 如果 Table 已經存在就先 Drop
        Schema::dropIfExists('plans');

        Schema::create('plans', function ( Blueprint $table ) {

            $table->bigIncrements('id');

            // # 方案資料 -------------------------------------------
            $table->string('plan_type' , 20 )->comment('方案類型( Ex. 包月洗澡、包月美容、住宿券  )') ;
            $table->string('pet_species' , 25 )->nullable()->comment('寵物品種') ;

            // # 住宿券 -------------------------------------------
            $table->tinyInteger('lodge_coupon_number' )->nullable()->comment('住宿券本數') ;

            // # 相關價格 -------------------------------------------
            $table->integer('plan_basic_price' )->default(0)->comment('方案 _ 基本價格') ;       // 基本價格
            $table->integer('plan_adjust_price' )->nullable()->comment('方案 _ 自訂 : 加 / 減 價格') ; // 加 / 減 價格

            $table->integer('lodge_coupon_price' )->nullable()->comment('住宿券價錢') ;                // 住宿券價格

            $table->integer('pickup_fee')->nullable()->comment('接送費') ;                             // 接送費



            $table->timestamps();

        });

        //  幫 Table 寫入註解
        DB::statement("ALTER TABLE `plans` comment '方案資料( Ex. 包月洗澡 )'");

    }


    public function down() {

        Schema::dropIfExists('plans');

    }

}
