<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration {

    public function up() {

        Schema::create('employees', function (Blueprint $table) {

            $table->bigIncrements('id');

            // # 帳號資料 -------------------------------------------
            $table->string('employee_type' , 20 )->comment('員工類型( Ex. 管理員、美容師 ...  )') ;
            $table->string('account' , 30 )->comment('帳號') ;
            $table->string('password' , 30 )->comment('密碼') ;
            $table->string('nickname' , 30 )->nullable()->comment('暱稱') ;

            // # 員工資料 -------------------------------------------
            $table->string('employee_name' , 20 )->nullable()->comment('員工姓名') ;
            $table->string('employee_id' , 20 )->nullable()->comment('員工身分證字號') ;
            $table->string('employee_mobile_phone' , 20 )->nullable()->comment('員工手機號碼') ;
            $table->string('employee_address' , 60 )->nullable()->comment('員工通訊地址') ;

            $table->timestamps();

        });

    }


    public function down() {

        Schema::dropIfExists('employees');

    }

}
