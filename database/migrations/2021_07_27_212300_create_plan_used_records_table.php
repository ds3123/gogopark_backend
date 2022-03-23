<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


// 方案使用紀錄
class CreatePlanUsedRecordsTable extends Migration {


    public function up() {

        Schema::dropIfExists('plan_used_records') ;

        Schema::create('plan_used_records' , function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('plan_type' , 20 )->comment('方案類別名稱 ( Ex.包月洗澡 )') ;
            $table->string('plan_id' , 20 )->comment('方案 id ( 資料表 : plan )') ;

            $table->string('customer_id' , 30 )->comment('客戶身分證字號') ;
            $table->string('pet_serial' , 30 )->comment('寵物序號') ;

            $table->integer('service_id')->comment('使用該方案之服務( 洗澡 / 美容 ) id') ;

            $table->timestamps();

        });

        // 資料表註解
        DB::statement("ALTER TABLE `plan_used_records` comment '方案 ( Ex. 包月洗澡 ) 使用紀錄'") ;

    }


    public function down(){

        Schema::dropIfExists('plan_used_records');

    }


}
