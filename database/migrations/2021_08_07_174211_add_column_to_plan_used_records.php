<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPlanUsedRecords extends Migration {


    public function up() {

        Schema::table('plan_used_records', function (Blueprint $table) {

            $table->string( 'service_note' , 80 )
                           ->after('service_type')
                           ->nullable()
                           ->comment('服務備註 ( Ex. 包月洗澡第 1 次  )') ;

        });

    }

    public function down() {

        Schema::table('plan_used_records', function (Blueprint $table) {

             $table->dropColumn('service_note') ;


        });

    }

}
