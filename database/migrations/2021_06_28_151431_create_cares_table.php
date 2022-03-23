<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaresTable extends Migration {



    public function up(){

        // 如果 Table 已經存在就先 Drop
        Schema::dropIfExists('cares');

        Schema::create('cares', function (Blueprint $table) {

            $table->bigIncrements('id');


            // # 安親資料
            $table->string('service_status' , 10 )->default('當日安親')->comment('安親性質( Ex. 當日安親、預約安親 )') ;
            $table->string('service_type' , 10 )->default('一般安親')->comment('安親類型( Ex. 一般安親、住宿_提早抵達、住宿_延後帶走 )') ;

            $table->integer('care_hours' )->comment('安親時數( Ex. 4 小時、8 小時、12 小時 )') ;


            // 起、訖 日期/時間 -------------------------------------------
            $table->date('start_date' )->comment('開始日期') ;
            $table->string('start_time' , 10 )->comment('開始時間( Ex. 15:00 )') ;
            $table->date('end_date' )->comment('結束日期') ;
            $table->string('end_time' , 10 )->comment('結束時間 ( Ex. 16:00 )') ;

            // 是否逾期
            $table->tinyInteger('is_overdue'  )->default(0)->comment('是否逾期 ( 1 : 逾期 , 0 : 未逾期 )') ;
            $table->string('overdue_time' , 10 )->comment('逾期時間 ( Ex. 02:30 )') ;


            // # 相關價格 -------------------------------------------
            $table->integer('care_price')->comment('安親費用') ;           // 安親費用

            $table->integer('pickup_fee')->nullable()->comment('接送費') ; // 接送費


            $table->timestamps() ;

        });

        //  幫 Table 寫入註解
        DB::statement("ALTER TABLE `cares` comment '安親單資料'");

    }


    public function down() {

        Schema::dropIfExists('cares');

    }

}
