<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBeautyTable extends Migration {


    public function up() {

        Schema::table('beauty', function (Blueprint $table) {

            $table->boolean('is_error')->after('beautician_note')
                                               ->default(0)
                                               ->comment('服務單是否異常 _ 否 : 0 / 是 : 1 ') ;

            $table->string('error_cause',100)->after('is_error')
                                                            ->nullable()
                                                            ->comment('異常原因') ;


            $table->boolean('is_archive')->after('error_cause')
                                                 ->default( false )
                                                 ->comment('是否封存資料 _ 否 : 0 / 是 : 1 ') ;

        });

    }

    public function down() {

        Schema::table('beauty', function (Blueprint $table) {

            $table->dropColumn('is_error') ;
            $table->dropColumn('error_cause') ;
            $table->dropColumn('is_archive') ;

        });

    }

}
