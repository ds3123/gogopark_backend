<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnsToBathTable extends Migration {


    public function up() {

        Schema::table('bath', function (Blueprint $table) {


            $table->Integer('bath_fee')->after('extra_beauty')->comment('洗澡單 _ 消費價格') ;


        });

    }

    public function down() {

        Schema::table('bath', function (Blueprint $table) {

            $table->dropColumn('bath_fee') ;


        });

    }

}
