<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminColumnsToLodgesTable extends Migration {

    public function up() {

        Schema::table('lodges', function (Blueprint $table) {

           $table->integer( 'amount_payable' )->after('pickup_fee')->nullable()->comment('應收金額小計') ;
           $table->integer( 'amount_paid' )->after('amount_payable')->nullable()->comment('實收金額小計') ;
           $table->integer( 'amount_discount' )->after('amount_paid')->nullable()->comment('優惠金額') ;

           $table->string( 'payment_method' , 20 )->after('amount_discount')->nullable()->comment('付款方式') ;

           $table->string( 'admin_user' , 20 )->after('payment_method')->nullable()->comment('櫃台工作人員') ;
           $table->string( 'admin_star' , 20 )->after('admin_user')->nullable()->comment('櫃台行政評分') ;
           $table->string( 'admin_service_note' , 50 )->after('admin_star')->nullable()->comment('櫃台人員服務備註') ;

           $table->boolean( 'is_error' )->after('admin_service_note')->default(0 )->comment('服務單是否異常 _ 否 : 0 / 是 : 1') ;
           $table->string( 'error_cause' , 100 )->after('is_error')->nullable()->comment('異常原因') ;
           $table->boolean( 'is_archive' )->after('error_cause')->default(0 )->comment('	是否封存資料 _ 否 : 0 / 是 : 1') ;

        });

    }

    public function down() {

        Schema::table('lodges', function (Blueprint $table) {

            $table->dropColumn('amount_payable') ;
            $table->dropColumn('amount_paid') ;
            $table->dropColumn('amount_discount') ;

            $table->dropColumn('payment_method') ;

            $table->dropColumn('admin_user') ;
            $table->dropColumn('admin_star') ;
            $table->dropColumn('admin_service_note') ;

            $table->dropColumn('is_error') ;
            $table->dropColumn('error_cause') ;
            $table->dropColumn('is_archive') ;

        });

    }

}
