<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/*
 *
 *
 *  @ 客戶_關係人資料
 *
 *
 */


class CreateCustomerRelation extends Migration {

    public function up() {

        // 如果 Table 已經存在就先 Drop
        Schema::dropIfExists('customer_relation');

        Schema::create('customer_relation', function (Blueprint $table) {

            $table->bigIncrements('relation_id');

            $table->string('customer_id' , 25 )->comment('關係人所屬客戶_身分證字號');

            $table->string('type' , 20 )->comment('類型 : 緊急聯絡人、介紹人');
            $table->string('tag' , 20 )->comment('關係 : 父母、朋友...');
            $table->string('name' , 20 )->comment('姓名');

            $table->string('mobile_phone' , 20 )->comment('手機號碼');
            $table->string('tel_phone' , 20 )->nullable()->comment('室內電話');

            $table->timestamps();

        });

        //  幫 Table 寫入註解
        DB::statement("ALTER TABLE `customer_relation` comment '客戶關係人'");

    }


    public function down() {

        Schema::dropIfExists('customer_relation');

    }

}
