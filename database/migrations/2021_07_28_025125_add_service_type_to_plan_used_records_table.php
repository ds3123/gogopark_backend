<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceTypeToPlanUsedRecordsTable extends Migration {

    public function up() {

        Schema::table('plan_used_records', function (Blueprint $table) {

            $table->string('service_type',20)->after('service_id')->comment('服務類型( Ex. 洗澡、美容 )') ;

        });

    }


    public function down() {

        Schema::table('plan_used_records', function (Blueprint $table) {

            $table->dropColumn('service_type') ;

        });

    }

}
