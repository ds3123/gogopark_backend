<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceErrorRecordsTable extends Migration{
   
    public function up(){

        Schema::create('service_error_records', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string( 'service_type' , 30 )->comment( '服務類型 ( Ex. 基礎、洗澡、美容... )' ) ;
            $table->integer( 'service_id' )->comment( '服務資料表( Ex. 洗澡、美容 ) id' ) ;
            $table->string( 'handle_status' , 40 )->nullable()->comment( '異常處理狀況( Ex. 已處理 ... )' ) ;
            $table->string( 'handle_note' , 100 )->nullable()->comment( '異常處理 _ 備註' ) ;
            $table->string( 'handle_user' , 30 )->nullable()->comment( '異常處理 _ 人員' ) ;
            
            

            $table->timestamps();

        });

        // 資料表註解
        DB::statement("ALTER TABLE `service_error_records` comment '服務異常處理紀錄'") ;

    }

    
    public function down(){

        Schema::dropIfExists('service_error_records');


    }

}
