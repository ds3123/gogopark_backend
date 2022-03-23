<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCustomerConfirmsTable extends Migration {

    public function up() {

        Schema::table('customer_confirms', function (Blueprint $table) {

            $table->string('q_code' , 15 )->after('service_type')->comment('當日處理碼') ;

        });

    }


    public function down() {

        Schema::table('customer_confirms', function (Blueprint $table) {

            $table->dropColumn('q_code' ) ;


        });

    }

}
