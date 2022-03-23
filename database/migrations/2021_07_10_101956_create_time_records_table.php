<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeRecordsTable extends Migration {


    public function up() {

        // 如果 Table 已經存在就先 Drop
        Schema::dropIfExists('time_records');

        Schema::create('time_records', function (Blueprint $table) {

            $table->bigIncrements('id') ;

            $table->string('service_table_id',5)->comment('所點選 _ 服務資料表 id') ;
            $table->string('service_type',15)->comment('所點選 _ 服務類型( 基礎、洗澡、美容 )') ;
            $table->string('button_name',20)->comment('所點選 _ 時間按鈕(階段) : 名稱 Ex. 第一次洗澡') ;
            $table->string('button_time',15)->comment('所點選 _ 時間按鈕(階段) : 時間 Ex. 15:30') ;
            $table->string('beautician',15)->comment('點選美容師姓名') ;

            $table->timestamps();

        });

        //  幫 Table 寫入註解
        DB::statement("ALTER TABLE `time_records` comment '美容區時間按鈕紀錄'");

    }


    public function down() {

        Schema::dropIfExists('time_records');

    }

}
