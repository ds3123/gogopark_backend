<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentTypeToBeautyTable extends Migration {

    public function up() {

        Schema::table('beauty', function (Blueprint $table) {

            $table->string('payment_type' , 40)
                  ->nullable()
                  ->after('payment_method')
                  ->comment('付款類別 ( Ex. 初次洗澡優惠、單次洗澡、包月洗澡第 2 次 ... )') ;

        });

    }

    public function down() {

        Schema::table('beauty', function (Blueprint $table) {

            $table->dropColumn('payment_type') ;

        });

    }

}
