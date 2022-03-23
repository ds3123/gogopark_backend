<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnsToEmployeesTable extends Migration {


    public function up() {

        Schema::table('employees', function (Blueprint $table) {


            $table->string('employee_serial' , 40)->nullable()->change();
            $table->string('salary_type' , 20)->nullable()->change();
            $table->string('position_type' , 20)->nullable()->change();
            $table->string('position_status' , 20)->nullable()->change();
            $table->string('brand' , 20 )->nullable()->change();
            $table->string('shop' , 20 )->nullable()->change();

            $table->string('employee_name' , 25)->nullable()->change();
            $table->string('employee_sex' , 15)->nullable()->change();
            $table->string('employee_id', 40)->nullable()->change();
            $table->string('employee_mobile_phone', 35)->nullable()->change();
            $table->string('employee_tel_phone', 35)->nullable()->change();
            $table->string('employee_birthday', 30)->nullable()->change();
            $table->string('employee_line', 40)->nullable()->change();
            $table->string('employee_email',80)->nullable()->change();
            $table->string('employee_transportation',25)->nullable()->change();
            $table->string('employee_address' , 100)->nullable()->change();
            $table->string('employee_residence_address' ,100)->nullable()->change();

            $table->string('relative_name_1' , 25)->nullable()->change();
            $table->string('relative_family_1' , 20)->nullable()->change();
            $table->string('relative_mobile_phone_1' , 35)->nullable()->change();
            $table->string('relative_tel_phone_1',35)->nullable()->change();
            $table->string('relative_address_1',100)->nullable()->change();

            $table->string('relative_name_2' , 25)->nullable()->change();
            $table->string('relative_family_2' , 20)->nullable()->change();
            $table->string('relative_mobile_phone_2' , 35)->nullable()->change();
            $table->string('relative_tel_phone_2',35)->nullable()->change();
            $table->string('relative_address_2',100)->nullable()->change();

            $table->string('relative_name_3' , 25)->nullable()->change();
            $table->string('relative_family_3' , 20)->nullable()->change();
            $table->string('relative_mobile_phone_3' , 35)->nullable()->change();
            $table->string('relative_tel_phone_3',35)->nullable()->change();
            $table->string('relative_address_3',100)->nullable()->change();



        });
    }


    public function down() {

        Schema::table('employees', function (Blueprint $table) {


            $table->string( 'employee_serial' )->change();

        });

    }

}
