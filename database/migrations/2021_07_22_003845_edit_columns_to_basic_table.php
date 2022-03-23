<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// 修改 _ 基礎單欄位
class EditColumnsToBasicTable extends Migration {


    public function up() {

        Schema::table('basic', function (Blueprint $table) {

            // # 修改
            $table->renameColumn( 'admin_note' , 'admin_customer_note' ) ;   // 主人交代下，櫃台備註

            $table->renameColumn( 'beautician' , 'beautician_name' ) ;       // 負責美容師姓名
            $table->renameColumn( 'report' , 'beautician_report' ) ;         // 美容師報告


            // # 刪除
            $table->dropColumn('basic_foot') ;                       // 修腳緣

            // # 新增
            $table->integer( 'amount_payable' )->after('pickup_fee')->nullable()->comment('應收金額小計') ;
            $table->integer( 'amount_paid' )->after('amount_payable')->nullable()->comment('實收金額小計') ;
            $table->integer( 'amount_discount' )->after('amount_paid')->nullable()->comment('優惠金額') ;

            $table->string( 'payment_method' , 20 )->after('amount_discount')->nullable()->comment('付款方式') ;
            $table->string( 'admin_service_note' , 50 )->after('admin_user')->nullable()->comment('櫃台人員服務備註') ;



        });

    }


    public function down() {

        Schema::table('basic', function (Blueprint $table) {

            $table->renameColumn( 'admin_customer_note' , 'admin_note' ) ;   // 主人交代下，櫃台備註
            $table->renameColumn( 'beautician_name' , 'beautician' ) ;       // 負責美容師姓名
            $table->renameColumn( 'beautician_report' , 'report' ) ;         // 美容師報告

            $table->string('basic_foot' , 60 )->after('basic_data')->nullable()->comment('修腳緣') ;

            $table->dropColumn( 'amount_payable' ) ;
            $table->dropColumn( 'amount_paid' ) ;
            $table->dropColumn( 'amount_discount' ) ;

            $table->dropColumn( 'payment_method' ) ;
            $table->dropColumn( 'admin_service_note' ) ;


        });

    }

}
