<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToLodgesTable extends Migration {

    public function up() {

        Schema::table('lodges', function (Blueprint $table) {

            $table->string('customer_id' , 30 )->after('id')->comment('客戶身分證字號') ;
            $table->string('pet_id' , 30 )->after('customer_id')->comment('寵物編號') ;

            $table->string('customer_object', 100)->after('pet_id')->comment('自備物品(選項)') ;
            $table->string('customer_object_other', 50)->after('customer_object')->comment('自備物品(其他)') ;
            $table->string('customer_note', 100)->after('customer_object_other')->comment('主人交代') ;
            $table->string('admin_customer_note', 50)->after('customer_note')->comment('櫃台備註') ;

        });

    }

    public function down() {

        Schema::table('lodges', function (Blueprint $table) {

            $table->dropColumn('customer_id') ;
            $table->dropColumn('pet_id') ;

            $table->dropColumn('customer_object') ;
            $table->dropColumn('customer_object_other') ;
            $table->dropColumn('customer_note') ;
            $table->dropColumn('admin_customer_note') ;

        });

    }

}
