<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerConfirmsTable extends Migration {

    public function up() {

        Schema::create('customer_confirms', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string( 'service_date' , 20 )->comment('服務日期') ;
            $table->string( 'service_type' , 15 )->comment('服務類型 ( Ex.基礎、洗澡、美容 )') ;
            $table->string( 'service_id' , 10 )->comment('服務表單 id') ;

            $table->string( 'request_beautician' , 20 )->comment('請求確認 _ 美容師姓名') ;
            $table->string( 'confirm_item_title' , 40 )->comment('請櫃檯確認(加價)項目名稱') ;
            $table->string( 'confirm_status' , 15 )->comment('確認狀態( Ex. 送交櫃台確認 )') ;

            $table->string( 'response_admin' , 20 )->nullable()->comment('回應確認 _ 櫃台姓名') ;
            $table->string( 'response_content' , 40 )->nullable()->comment('櫃台回應確認內容') ;

            $table->timestamps() ;

        });

    }


    public function down() {

        Schema::dropIfExists('customer_confirms');

    }

}
