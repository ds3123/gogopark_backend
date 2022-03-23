<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLodgesTable extends Migration {

    public function up() {

        // 如果 Table 已經存在就先 Drop
        Schema::dropIfExists('lodges');

        Schema::create('lodges', function (Blueprint $table) {

            $table->bigIncrements('id');

            // # 住宿資料
            $table->string('contract_serial' , 40 )->comment('合約編號 ( Ex.L_20210621_55 )') ;
            $table->string('service_status' , 20 )->default('當日住宿')->comment('住宿性質 ( Ex. 當日住宿、預約住宿 )') ;

            $table->string('room_type' , 15 )->comment('房型 ( Ex. 大房、中房、小房 )') ;
            $table->string('room_number' , 15 )->comment('房號 ( Ex. A01、B01、C01 )') ;

            $table->tinyInteger('bath_number' )->comment('洗澡次數') ;
            $table->tinyInteger('beauty_number' )->comment('美容次數') ;

            // # 起、訖 日期/時間 -----------------------------------
            $table->date('start_date' )->comment('開始日期') ;
            $table->string('start_time' , 10 )->comment('開始時間( Ex. 15:00 )') ;
            $table->date('end_date' )->comment('結束日期') ;
            $table->string('end_time' , 10 )->comment('結束時間 ( Ex. 16:00 )') ;


            // # 相關價格 -------------------------------------------
            $table->integer('lodge_price')->default(0)->comment('住宿費用') ;  // 住宿費

            $table->integer('lodge_bath_price')->nullable()->comment('洗澡費用') ;   // 洗澡費
            $table->integer('lodge_beauty_price')->nullable()->comment('美容費用') ; // 美容費

            $table->integer('pickup_fee')->nullable()->comment('接送費') ;           // 接送費

            $table->timestamps() ;

        });

        //  幫 Table 寫入註解
        DB::statement("ALTER TABLE `lodges` comment '住宿單資料'");

    }


    public function down() {

        Schema::dropIfExists('lodges');

    }

}
