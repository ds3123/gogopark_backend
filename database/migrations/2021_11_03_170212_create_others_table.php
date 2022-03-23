<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOthersTable extends Migration{
    
    public function up(){

        Schema::create('others', function (Blueprint $table) {

            $table->bigIncrements('id');


            $table->string( 'type' , 15 )->comment( '收支類別 ( 收入 / 支出 )' ) ;
            $table->string( 'item' , 80 )->comment( '收支項目 ' ) ;
            
            $table->integer( 'amount' )->comment( '收支金額' ) ;


            $table->timestamps();

        });

         // 資料表註解
         DB::statement("ALTER TABLE `others` comment '其他收支項目'") ;

    }

    
    public function down(){

        Schema::dropIfExists('others');

    }

}
