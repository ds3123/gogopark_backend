<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToBasicTable extends Migration {

    public function up() {

        Schema::table('basic', function (Blueprint $table) {

            $table->string('admin_star' , 10 )
                             ->after('admin_user')
                             ->nullable()
                             ->comment('櫃台行政評分') ;

        });

    }

    public function down() {

        Schema::table('basic', function (Blueprint $table) {

            $table->dropColumn('admin_star') ;

        });

    }

}
