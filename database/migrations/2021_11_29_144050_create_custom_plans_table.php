<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



class CreateCustomPlansTable extends Migration{

   
    public function up(){

        Schema::create('custom_plans', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string( 'plan_name' , 30 )->comment( '方案名稱' ) ;

            $table->integer( 'bath_num' )->nullable()->comment( '洗澡次數' ) ;
            $table->integer( 'beauty_num' )->nullable()->comment( '美容次數' ) ;
            
            $table->integer( 'plan_period' )->nullable()->default( 90 )->comment( '方案使用期限( 預設 90 天)' ) ;
            $table->integer( 'default_price' )->nullable()->comment( '方案預設價格' ) ;

            $table->string( 'plan_note' , 100 )->nullable()->comment( '方案備註' ) ;
        

            $table->timestamps();

        });

         // 資料表註解
         DB::statement("ALTER TABLE `custom_plans` comment '自訂方案'") ;

    }

   
    public function down(){

        Schema::dropIfExists('custom_plans');

    }

}
