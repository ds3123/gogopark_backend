<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPlansTable extends Migration {

    public function up() {

        Schema::table('plans' , function( Blueprint $table ){

            $table->integer('amount_payable' )->after('lodge_coupon_price')->nullable()->comment('應收金額小計') ;
            $table->integer('amount_paid' )->after('amount_payable')->nullable()->comment('實收金額小計') ;

            $table->string('payment_method' , 20 )->after('amount_paid')->nullable()->comment('付款方式') ;

            $table->string('admin_user' , 20 )->after('payment_method')->nullable()->comment('櫃台人員') ;
            $table->string('admin_service_note' , 100 )->after('admin_user')->nullable()->comment('櫃台人員 _ 備註') ;

        });

    }

    public function down() {

        Schema::table('plans' , function( Blueprint $table ){

            $table->dropColumn('amount_payable' ) ;
            $table->dropColumn('amount_paid' ) ;

            $table->dropColumn('payment_method' ) ;

            $table->dropColumn('admin_user' ) ;
            $table->dropColumn('admin_service_note' ) ;

        });

    }

}
