<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEmployeesTable extends Migration {

    public function up() {

        Schema::table('employees', function (Blueprint $table) {


            $table->string('employee_serial' , 30 )->after('nickname')->comment('員工編號') ;
            $table->string('salary_type' , 20 )->after('employee_serial')->comment('計薪類別 ( Ex. 正職 / 計時 )') ;
            $table->string('position_type' , 20 )->after('salary_type')->comment('職位類別 ( Ex. 櫃台 / 美容 / 接送 )') ;
            $table->string('position_status' , 20 )->after('position_type')->comment('職位現況 ( Ex. 在職 / 離職 )') ;
            $table->string('brand' , 20 )->after('position_status')->comment('所屬品牌 ( Ex. 狗狗公園 )') ;
            $table->string('shop' , 20 )->after('brand')->comment('所屬店別 ( Ex. 淡水店 )') ;

            // -------------------------

            $table->string('employee_sex' , 10 )->nullable()->after('employee_name')->comment('員工性別' ) ;
            $table->string('employee_tel_phone' , 30 )->nullable()->after('employee_mobile_phone')->comment('員工家用電話' ) ;
            $table->string('employee_birthday' , 30 )->nullable()->after('employee_tel_phone')->comment('員工生日' ) ;
            $table->string('employee_line' , 40 )->nullable()->after('employee_birthday')->comment('員工 LINE' ) ;
            $table->string('employee_email' , 80 )->nullable()->after('employee_line')->comment('員工 Email' ) ;
            $table->string('employee_transportation' , 30 )->nullable()->after('employee_email')->comment('員工交通工具') ;

            $table->string('employee_residence_address' , 100 )->nullable()->after('employee_address')->comment('員工戶籍地址') ;

            // -------------------------

            $table->string('relative_name_1' , 30 )->after('employee_residence_address')->comment('緊急聯絡人(1) _ 姓名') ;
            $table->string('relative_family_1' , 25 )->after('relative_name_1')->comment('緊急聯絡人(1) _ 關係') ;
            $table->string('relative_mobile_phone_1' , 35 )->after('relative_family_1')->comment('緊急聯絡人(1) _ 手機號碼') ;
            $table->string('relative_tel_phone_1' , 35 )->nullable()->after('relative_mobile_phone_1')->comment('緊急聯絡人(1) _ 家用電話') ;
            $table->string('relative_address_1' , 35 )->nullable()->after('relative_tel_phone_1')->comment('緊急聯絡人(1) _ 通訊地址') ;

            $table->string('relative_name_2' , 30 )->nullable()->after('relative_address_1')->comment('緊急聯絡人(2) _ 姓名') ;
            $table->string('relative_family_2' , 25 )->nullable()->after('relative_name_2')->comment('緊急聯絡人(2) _ 關係') ;
            $table->string('relative_mobile_phone_2' , 35 )->nullable()->after('relative_family_2')->comment('緊急聯絡人(2) _ 手機號碼') ;
            $table->string('relative_tel_phone_2' , 35 )->nullable()->after('relative_mobile_phone_2')->comment('緊急聯絡人(2) _ 家用電話') ;
            $table->string('relative_address_2' , 35 )->nullable()->after('relative_tel_phone_2')->comment('緊急聯絡人(2) _ 通訊地址') ;

            $table->string('relative_name_3' , 30 )->nullable()->after('relative_address_2')->comment('緊急聯絡人(3) _ 姓名') ;
            $table->string('relative_family_3' , 25 )->nullable()->after('relative_name_3')->comment('緊急聯絡人(3) _ 關係') ;
            $table->string('relative_mobile_phone_3' , 35 )->nullable()->after('relative_family_3')->comment('緊急聯絡人(3) _ 手機號碼') ;
            $table->string('relative_tel_phone_3' , 35 )->nullable()->after('relative_mobile_phone_3')->comment('緊急聯絡人(3) _ 家用電話') ;
            $table->string('relative_address_3' , 35 )->nullable()->after('relative_tel_phone_3')->comment('緊急聯絡人(3) _ 通訊地址') ;


        });

    }

    public function down() {

        Schema::table('employees', function (Blueprint $table) {


            $table->dropColumn('employee_serial') ;
            $table->dropColumn('salary_type') ;
            $table->dropColumn('position_type') ;
            $table->dropColumn('position_status') ;
            $table->dropColumn('brand') ;
            $table->dropColumn('shop') ;

            // -------------------------

            $table->dropColumn('employee_sex') ;
            $table->dropColumn('employee_tel_phone') ;
            $table->dropColumn('employee_birthday') ;
            $table->dropColumn('employee_line') ;
            $table->dropColumn('employee_email') ;
            $table->dropColumn('employee_transportation') ;
            $table->dropColumn('employee_residence_address') ;

            // -------------------------

            $table->dropColumn('relative_name_1') ;
            $table->dropColumn('relative_family_1') ;
            $table->dropColumn('relative_mobile_phone_1') ;
            $table->dropColumn('relative_tel_phone_1') ;
            $table->dropColumn('relative_address_1') ;

            $table->dropColumn('relative_name_2') ;
            $table->dropColumn('relative_family_2') ;
            $table->dropColumn('relative_mobile_phone_2') ;
            $table->dropColumn('relative_tel_phone_2') ;
            $table->dropColumn('relative_address_2') ;

            $table->dropColumn('relative_name_3') ;
            $table->dropColumn('relative_family_3') ;
            $table->dropColumn('relative_mobile_phone_3') ;
            $table->dropColumn('relative_tel_phone_3') ;
            $table->dropColumn('relative_address_3') ;

        });

    }

}
