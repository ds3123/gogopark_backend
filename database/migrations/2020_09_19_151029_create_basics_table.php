<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


// 建立 _ 基礎單

class CreateBasicsTable extends Migration {


    public function up() {

        // 如果 Table 已經存在就先 Drop
        Schema::dropIfExists('basic');

        Schema::create('basic' , function (Blueprint $table) {

            $table->bigIncrements('basic_id');

            // # 基本資訊 -----------------------------------------------------------------------------
            $table->string('service_type' , 10 )->default('基礎')->comment('服務類型( 基礎、洗澡、美容、住宿 )') ;
            $table->string('service_status' , 20 )->default('已到店')->comment('服務狀態(Ex.已到店、預約_今天、預約未來)') ;
            $table->string('shop_status' , 30  )->default('到店等候中')->comment('到店狀態( Ex.到店等候中、到店美容中...)') ;

            $table->string('service_date' , 15 )->comment('服務日期') ;
            $table->string('q_code' , 15 )->comment('當日處理碼( Q01 ~ Q60 )') ;

            $table->string('expected_arrive' , 15 )->nullable()->comment('預計到店時間') ;
            $table->string('actual_arrive' , 15 )->nullable()->comment('實際到店時間') ;
            $table->string('expected_leave' , 15 )->nullable()->comment('預計離店時間') ;

            $table->string('way_arrive' , 20 )->nullable()->comment('到店方式') ;
            $table->string('way_leave' , 20 )->nullable()->comment('離店方式') ;

            // # 客戶身分證字號、寵物編號 -----------------------------------------------------------------------------
            $table->string('customer_id' , 20 )->comment('客戶身分證字號') ;
            $table->string('pet_id' , 30 )->comment('寵物編號') ;

            // # 其他資料  -----------------------------------------------------------------------------
            $table->string('customer_object' ,100 )->nullable()->comment('自備物品(選項)') ;
            $table->string('customer_object_other' ,50 )->nullable()->comment('自備物品(其他)') ;
            $table->string('customer_note' ,100 )->nullable()->comment('主人交代') ;
            $table->string('admin_note' , 50 )->nullable()->comment('櫃台備註') ;

            // # 基礎單 _ 基礎選項  ---------------------------------------------------------------------------
            $table->string('basic_data' , 60 )->nullable()->comment('基礎單資料 _ 勾選選項') ;
            $table->string('basic_foot' , 60 )->nullable()->comment('修腳緣') ;

            // # 基礎單 _ 消費價格 ---------------------------------------------------------------------------------------------------
            $table->integer('basic_fee' )->default(0)->comment('基礎單_消費價格') ;  // 基礎單價格
            $table->integer('pickup_fee')->nullable()->comment('接送費') ;                 // 接送費

            // # 工作人員 ----------------------------
            $table->string('admin_user' , 20 )->nullable()->comment('工作人員');

            // # 美容師相關 ----------------------
            $table->string('beautician' , 15 )->nullable()->comment('負責美容師') ;
            $table->string('report' , 100 )->nullable()->comment('美容師處理結果') ;
            $table->string('wait_way' , 20 )->nullable()->comment('等候方式( Ex.進籠子等候 )') ;
            $table->string('wait_time' , 20 )->nullable()->comment('開始等候時間') ;
            $table->string('beautician_star' , 10 )->nullable()->comment('美容師評分') ;
            $table->string('beautician_note' , 60 )->nullable()->comment('美容師備註');

            $table->timestamps();

        });

        //  幫 Table 寫入註解
        DB::statement("ALTER TABLE `basic` comment '基礎單資料'");

    }


    public function down() {

        Schema::dropIfExists('basic');

    }

}
