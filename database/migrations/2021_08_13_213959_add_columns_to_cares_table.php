<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCaresTable extends Migration {

    public function up() {

        Schema::table('cares', function (Blueprint $table) {

           $table->string('customer_id' , 30 )->after('id')->comment('客戶身分證字號	') ;
           $table->string('pet_id' , 30 )->after('customer_id')->comment('寵物編號') ;

           $table->string('wat_arrive' , 20 )->after('pet_id')->nullable()->comment('到店方式 ( Ex. 主人送來 )') ;
           $table->string('wat_leave' , 20 )->after('wat_arrive')->nullable()->comment('離店方式 ( Ex. 主人接走 )') ;

           $table->integer('amount_payable' )->after('pickup_fee')->nullable()->comment('應收金額小計') ;
           $table->integer('amount_paid' )->after('amount_payable')->nullable()->comment('實收金額小計') ;

           $table->string('payment_method' ,25 )->after('amount_paid')->nullable()->comment('付款方式') ;

           $table->string('admin_user' ,15 )->after('payment_method')->nullable()->comment('櫃台工作人員') ;
           $table->string('admin_star' ,10 )->after('admin_user')->nullable()->comment('櫃台工作人員評分') ;
           $table->string('admin_service_note' ,100 )->after('admin_star')->nullable()->comment('櫃台工作人員備註') ;

           $table->boolean('is_error' )->after('admin_service_note')->default(false)->comment('服務單是否異常 _ 否 : 0 / 是 : 1') ;
           $table->string('error_cause' , 100 )->after('is_error')->comment('異常原因') ;
           $table->boolean('is_archive' )->after('error_cause')->default(false)->comment('是否封存資料 _ 否 : 0 / 是 : 1') ;


        });

    }

    public function down() {

        Schema::table('cares', function (Blueprint $table) {

            $table->dropColumn('customer_id') ;
            $table->dropColumn('pet_id') ;

            $table->dropColumn('wat_arrive') ;
            $table->dropColumn('wat_leave') ;

            $table->dropColumn('amount_payable') ;
            $table->dropColumn('amount_paid') ;

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
