<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBathMonthToBathTable extends Migration {

    public function up() {

        Schema::table('bath', function (Blueprint $table) {

            $table->integer('bath_month_fee')
                  ->after('bath_fee')
                  ->nullable()
                  ->comment('使用單次 : 包月洗澡價格') ;

        });

    }

    public function down() {

        Schema::table('bath', function (Blueprint $table) {

            $table->dropColumn('bath_month_fee') ;

        });

    }

}
