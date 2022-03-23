<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicePricesTable extends Migration {

    public function up() {

        // 如果 Table 已經存在就先 Drop
        Schema::dropIfExists('service_prices');

        Schema::create('service_prices', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('service_type',15)->comment('服務類型 ( Ex.基礎、洗澡、美容 )' ) ;
            $table->string('service_plan',25)->nullable()->comment('服務方案 ( Ex.包月洗澡 )' ) ;

            $table->integer('species_id')->nullable()->comment('寵物品種 _ 資料表 id' ) ;

            $table->string('service_name',30)->nullable()->comment('具體服務名稱 ( Ex. 剪指甲 )' ) ;
            $table->integer('service_price')->comment('服務價格') ;

            $table->string('note' , 100)->nullable()->comment('備 註') ;

            $table->timestamps();

        });

        //  幫 Table 寫入註解
        DB::statement("ALTER TABLE `service_prices` comment '各項服務 _ 價格'");

    }


    public function down() {

        Schema::dropIfExists('service_prices');

    }

}
