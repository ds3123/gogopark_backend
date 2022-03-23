<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/*
 *
 *
 *  @ 客戶資料
 *
 *
 */



class CreateCustomersTable extends Migration {


    public function up() {

        // 如果 Table 已經存在就先 Drop
        Schema::dropIfExists('customer');

        Schema::create('customer', function (Blueprint $table){

            $table->bigIncrements('customer_id');

            $table->string('name' , 20 )->comment('姓名');
            $table->string('id' , 30 )->comment('身分證字號');
            $table->string('mobile_phone' , 20 )->comment('手機號碼');
            $table->string('tel_phone' , 20 )->nullable()->comment('市內電話');
            $table->string('line' , 20 )->nullable()->comment('Line ID');
            $table->string('email' , 50 )->nullable()->comment('E-mail');
            $table->string('address' , 60 )->nullable()->comment('通訊地址');

            $table->timestamps();

        });

        //  幫 Table 寫入註解
        DB::statement("ALTER TABLE `customer` comment '客戶資料'");

    }


    public function down() {

        Schema::dropIfExists('customer');

    }
}
