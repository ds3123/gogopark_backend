<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPlanUsedRecordsTable extends Migration {

    public function up() {

        Schema::table('plan_used_records', function (Blueprint $table) {

            $table->integer('service_price')
                  ->after('service_note')
                  ->nullable()
                  ->comment('使用該次方案單價') ;

        });

    }

    public function down() {

        Schema::table('plan_used_records', function (Blueprint $table) {

            $table->dropColumn('service_price') ;

        });

    }

}
