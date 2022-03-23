<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnsToBeautyTable extends Migration {

    public function up() {

        Schema::table('beauty', function (Blueprint $table) {

            // # 修改
            $table->renameColumn( 'admin_note' , 'admin_customer_note' ) ;   // 主人交代下，櫃台備註

            $table->renameColumn( 'beautician' , 'beautician_name' ) ;       // 負責美容師姓名
            $table->renameColumn( 'report' , 'beautician_report' ) ;         // 美容師報告

            $table->renameColumn( 'beauty_price' , 'beauty_fee' ) ;          // 美容費用小計

            // # 刪除
            $table->dropColumn('basic_foot') ;                       // 修腳緣

            $table->dropColumn('fur') ;                              // 修廢毛
            $table->dropColumn('flea') ;                             // 跳蚤、壁蝨

            $table->dropColumn('basic_fee') ;                        // 基礎費用小計

            $table->dropColumn('plus_fur') ;                         // 修廢毛 _ 價格
            $table->dropColumn('plus_flea') ;                        // 跳蚤、壁蝨 _ 價格


            // # 新增
            $table->string('extra_service' , 60 )->after('bath_6')->nullable()->comment('加價項目 : 梳廢毛、跳蚤/壁蝨') ;
            $table->integer('extra_service_fee' )->after('beauty_price')->nullable()->comment('加價項目 _ 價格') ;

            $table->integer( 'amount_payable' )->after('pickup_fee')->nullable()->comment('應收金額小計') ;
            $table->integer( 'amount_paid' )->after('amount_payable')->nullable()->comment('實收金額小計') ;
            $table->integer( 'amount_discount' )->after('amount_paid')->nullable()->comment('優惠金額') ;

            $table->string( 'payment_method' , 20 )->after('amount_discount')->nullable()->comment('付款方式') ;
            $table->string( 'admin_service_note' , 50 )->after('admin_user')->nullable()->comment('櫃台人員服務備註') ;


        });

    }


    public function down() {

        Schema::table('beauty', function (Blueprint $table) {

            // # 修改
            $table->renameColumn( 'admin_customer_note' , 'admin_note'  ) ;   // 主人交代下，櫃台備註

            $table->renameColumn( 'beautician_name' , 'beautician'  ) ;       // 負責美容師姓名
            $table->renameColumn( 'beautician_report' ,  'report'  ) ;         // 美容師報告

            $table->renameColumn( 'beauty_fee' , 'beauty_price' ) ;          // 美容費用小計


        });

    }

}
