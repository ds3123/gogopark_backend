<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentTypeToBathTable extends Migration {

    public function up() {

        Schema::table('bath', function (Blueprint $table) {

            $table->string('payment_type' , 40)
                  ->nullable()
                  ->after('payment_method')
                  ->comment('付款類別 ( Ex. 初次洗澡優惠、單次洗澡、包月洗澡第 2 次 ... )') ;

        });

    }


    public function down() {

        Schema::table('bath', function (Blueprint $table) {

            $table->dropColumn('payment_type') ;

        });

    }

}
