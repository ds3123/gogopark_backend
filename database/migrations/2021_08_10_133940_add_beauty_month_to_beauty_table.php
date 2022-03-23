<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBeautyMonthToBeautyTable extends Migration {

    public function up() {

        Schema::table('beauty', function (Blueprint $table) {

            $table->integer('beauty_month_fee')
                  ->after('beauty_fee')
                  ->nullable()
                  ->comment('使用單次 : 包月美容價格') ;

        });

    }


    public function down() {

        Schema::table('beauty', function (Blueprint $table) {

            $table->dropColumn('beauty_month_fee') ;

        });

    }

}
