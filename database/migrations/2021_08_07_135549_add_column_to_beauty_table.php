<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToBeautyTable extends Migration {

    public function up() {

        Schema::table('beauty', function (Blueprint $table) {

            $table->string('admin_star' , 10 )
                                ->after('admin_user')
                                ->nullable()
                                ->comment('櫃台行政評分') ;

        });

    }

    public function down() {

        Schema::table('beauty', function (Blueprint $table) {

            $table->dropColumn('admin_star') ;

        });

    }

}
