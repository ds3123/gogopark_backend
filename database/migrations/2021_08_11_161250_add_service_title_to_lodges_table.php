<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceTitleToLodgesTable extends Migration {

    public function up() {

        Schema::table('lodges', function (Blueprint $table) {

            $table->string( 'service_title' , 80 )
                  ->after('contract_serial')
                  ->comment('for Calendar 住宿標題說明 ( Ex. A01 大黃(秋田犬) )') ;

        });

    }

    public function down() {

        Schema::table('lodges', function (Blueprint $table) {

             $table->dropColumn('service_title' ) ;

        });
    }
}
