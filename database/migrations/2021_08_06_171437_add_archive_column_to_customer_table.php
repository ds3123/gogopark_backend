<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArchiveColumnToCustomerTable extends Migration {

    public function up() {

        Schema::table('customer', function (Blueprint $table) {

           $table->boolean('is_archive')->after('address')
                                                ->default( false )
                                                ->comment('是否封存資料 _ 否 : 0 / 是 : 1 ') ;

        });

    }


    public function down() {

        Schema::table('customer', function (Blueprint $table) {

           $table->dropColumn('is_archive') ;

        });

    }

}
