<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// 修改 _ 方案資料表
class EditPlansTable extends Migration {


    public function up(){

        Schema::table('plans', function (Blueprint $table) {

            $table->string('customer_id' , 30 )->after('plan_type')->comment('客人身份證字號') ;

            $table->renameColumn( 'pet_species' , 'pet_species_id' ) ;   // 改為 _ 寵物品種 "資料表 ID"

            $table->tinyInteger( 'lodge_coupon_number' )->nullable()->after('plan_adjust_price')->comment('住宿券 _ 本數') ;

            $table->integer('pickup_fee')->nullable()->after('plan_adjust_price')->comment('接送費') ;

            $table->integer('plan_fee_total')->nullable()->after('pickup_fee')->comment('方案價格總計 ( 基礎價格+自行增減+接送費 )') ;


        });

    }

    public function down() {

        Schema::table('plans', function (Blueprint $table) {

            $table->dropColumn('customer_id') ;

            $table->dropColumn('pickup_fee') ;

            $table->renameColumn( 'pet_species_id' , 'pet_species' ) ;

            $table->dropColumn('lodge_coupon_number') ;

            $table->dropColumn('plan_fee_total') ;

        });

    }

}
