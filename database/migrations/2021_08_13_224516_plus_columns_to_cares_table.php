<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PlusColumnsToCaresTable extends Migration {

    public function up() {

        Schema::table('cares', function (Blueprint $table) {

            $table->string('customer_object' , 100 )->after('wat_leave')->nullable()->comment('自備物品(選項)') ;
            $table->string('customer_object_other' , 50 )->after('customer_object')->nullable()->comment('自備物品(其他)') ;
            $table->string('customer_note' , 100 )->after('customer_object_other')->nullable()->comment('主人交代') ;
            $table->string('admin_customer_note' , 50 )->after('customer_note')->nullable()->comment('櫃台備註') ;

        });
    }

    public function down() {

        Schema::table('cares', function (Blueprint $table) {

            $table->dropColumn('customer_object' ) ;
            $table->dropColumn('customer_object_other' ) ;
            $table->dropColumn('customer_note' ) ;
            $table->dropColumn('admin_customer_note' ) ;

        });

    }
}
