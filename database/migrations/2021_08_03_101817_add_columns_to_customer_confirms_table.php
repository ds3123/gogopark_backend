<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCustomerConfirmsTable extends Migration {


    public function up() {

        Schema::table('customer_confirms', function (Blueprint $table) {


            $table->string( 'customer_id' , 30 )->after('service_id')->comment('客戶身分證字號') ;
            $table->string( 'pet_serial' , 30 )->after('customer_id')->comment('寵物編號') ;

            $table->string( 'response_content' , 60 )->change();


        });


    }


    public function down() {

        Schema::table('customer_confirms', function (Blueprint $table) {

            $table->dropColumn('customer_id') ;
            $table->dropColumn('pet_serial') ;

            $table->string( 'response_content' , 40 )->change();

        });

    }

}
