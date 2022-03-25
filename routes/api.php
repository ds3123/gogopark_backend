<?php

use Illuminate\Http\Request ;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. Thes e
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::namespace('Api')->group(function(){

    /*
     * NOTE : 要向資源控制器新增 : "額外的路由 " --> 應該在呼叫 Route::resource 之 "前"，定義這些路由。
     */

     // @ 客戶 ( customer ) 、客戶關係人 ( customer_relation )
     Route::group( ['prefix' => 'customers'] , function(){

          // # 查詢 ------
            // 特定客戶 ( 依 : 手機號碼 )
            Route::get('/show_by_mobile/{mobile}' , 'CustomerController@show_By_Mobile') ;

            // 特定客戶 ( 依 : 身分證字號 )
            Route::get('/show_by_id/{id}' , 'CustomerController@show_By_Id') ;

            // 多個客戶 ( LIKE 模糊搜尋 ) ( 依 : 傳入參數 : 查詢欄位 與 查詢值 ，如 : 'id' & 身分證字號 或 'mobile_phone' & 手機號碼 )
            Route::get('/show_by_param/{col}/{param}' , 'CustomerController@show_By_Param') ;

            // & 一對多關係 : 特定客戶 ( 依 : 身分證字號 )，有 ( 多個 ) :
            Route::get('/show_relations/{id}' , 'CustomerController@show_Relations') ; // 關係人(s)
            Route::get('/show_pets/{id}'      , 'CustomerController@show_Pets') ;      // 寵物(s)
            Route::get('/show_basics/{id}'    , 'CustomerController@show_Basics') ;    // 基礎單(s)
            Route::get('/show_bathes/{id}'    , 'CustomerController@show_Bathes') ;    // 洗澡單(s)
            Route::get('/show_beauties/{id}'  , 'CustomerController@show_Beauties') ;  // 美容單(s)

            // 關係人 (s) + 寵物 (s)
            Route::get('/show_relations_pets/{id}' , 'CustomerController@show_Relations_Pets') ; // 關係人(s) + 寵物(s)

            // & 多對多關係 :
            Route::get('/show_customers_pets' , 'CustomerController@show_Customers_Pets') ;  // 所有客戶(s) 及其寵物(s)

            Route::get('/show_customers_relatives_pets/{is_Archive}/{data_Num}' , 'CustomerController@show_Customers_Relatives_Pets') ; // 部分客戶(s) 及其寵物(s)

            Route::get('/show_all_customers_relatives_pets/{is_Archive}' , 'CustomerController@show_All_Customers_Relatives_Pets') ;    // 所有客戶(s) 及其寵物(s)


          // # 新增 ------

            // 特定客戶 _ 關係人
            Route::post('/store_relation' , 'CustomerController@store_Relation') ;

          // # 更新 ------

            // 特定客戶 _ 關係人
            Route::put('/update_relation/{relation_id}' , 'CustomerController@update_Relation') ;


          // # 刪除 ------
         
            // 特定客戶 _ 關係人 ( 依 : `customer_relation 主鍵` )
            Route::delete('/destroy_relation/{relation_id}' , 'CustomerController@destroy_Relation') ;


            // 特定客戶 _ 關係人 ( 依 : 客戶身分證字號 ) ( 有問題 )
            Route::delete('/destroy_relation_by_cus_id/{cus_Id}' , 'CustomerController@destroy_Relation_By_Customer_Id') ;



     });

     Route::apiResource( '/customers' , 'CustomerController' );

     // @ 寵物 ( pet )  -----------------------------------------------------------------------------------
     Route::group( [ 'prefix' => 'pets'] , function(){

        // 查詢 : 單一寵物 及 其主人
        Route::get( '/show_pet_customer/{serial}' , 'PetController@show_Pet_Customer' ) ;

        // 查詢 : 所有寵物 (s) 及其主人
        Route::get( '/show_pets_customers/' , 'PetController@show_Pets_Customers' ) ;

        // 查詢 : 部分 _ 寵物 (s) 及其主人 + 關係人
        Route::get( '/show_pets_customers_relatives/{is_Archive}/{data_Num}' , 'PetController@show_Pets_Customers_Relatives' ) ;

        // 查詢 : 所有 _ 寵物 (s) 及其主人 + 關係人
        Route::get( '/show_all_pets_customers_relatives/{is_Archive}' , 'PetController@show_All_Pets_Customers_Relatives' ) ;

        // 查詢 : 目前某品種的所有寵物
        Route::get( '/show_current_pet_species/{species_Name}' , 'PetController@show_Current_Pet_Species' ) ;

     }) ;

     Route::apiResource( '/pets' , 'PetController' );

     // @ 基礎單 ( basic ) -----------------------------------------------------------------------------------
     Route::group( [ 'prefix' => 'basics' ] , function(){

        // 查詢 : 所有 _ 基礎單 + 客戶 + 寵物
        Route::get( '/show_with_cus_pet/' , 'BasicController@show_With_Cus_Pet' ) ;

        // 查詢 : 單一 _ 基礎單 + 客戶 + 寵物
        Route::get( '/show_with_cus_pet/{id}' , 'BasicController@show_Single_With_Cus_Pet' ) ;

        // 僅 _ 查詢該基礎單，相對應的 _ 客戶
        Route::get( '/show_customer/{id}' , 'BasicController@show_Customer' ) ;

        // 僅 _ 查詢該基礎單，相對應的 _ 寵物消費紀錄
        Route::get( '/show_pet/{pet_serial}/{type}' , 'BasicController@show_Pet' ) ;

        // 查詢 : 特定日期，基礎單已使用 Q 碼
        Route::get( '/show_qcode/{date}' , 'BasicController@show_Date_Qcode' ) ;

        // 查詢 : 特定客戶身分證字號，所有基礎單紀錄
        Route::get( '/show_customer_id/{id}' , 'BasicController@show_Customer_ID' ) ;

        // 僅 _ 查詢該寵物 ( 依 "寵物編號") ， 所有基礎紀錄
        Route::get( '/show_pet_records/{pet_serial}/' , 'BasicController@show_Pet_Records' ) ;

        // 更新 : 特定欄位
        Route::put( '/update_column/{basic_id}/{column}/{value}' , 'BasicController@update_Column') ;

     }) ;

     Route::apiResource( '/basics' , 'BasicController' );

     // @ 洗澡單 ( bath ) -----------------------------------------------------------------------------------
     Route::group( ['prefix' => 'bathes'] , function(){

         // 查詢 : 所有 _ 洗澡單 + 客戶 + 寵物
         Route::get( '/show_with_cus_pet/' , 'BathController@show_With_Cus_Pet' ) ;

         // 查詢 : 單一 _ 洗澡單 + 客戶 + 寵物
         Route::get( '/show_with_cus_pet/{id}' , 'BathController@show_Single_With_Cus_Pet' ) ;

         // 查詢 : 特定日期，洗澡單已使用 Q 碼
         Route::get( '/show_qcode/{date}' , 'BathController@show_Date_Qcode' ) ;

         // 查詢 : 特定客戶身分證字號，所有洗澡單紀錄 ( 判斷 _ 是否有洗澡單紀錄，以確認是否為 : "初次洗澡客戶" )
         Route::get( '/show_customer_id/{id}' , 'BathController@show_Customer_ID' ) ;
         
         // 僅 _ 查詢該寵物 ( 依 "寵物編號") ， 所有洗澡紀錄
         Route::get( '/show_pet_records/{pet_serial}/' , 'BathController@show_Pet_Records' ) ;

         // 僅 _ 查詢該洗澡單 ( 依 "寵物編號"、"付款方式  Ex.現金、包月洗澡" ) ，相對應的 _ 寵物消費紀錄
         Route::get( '/show_pet/{pet_serial}/{type}' , 'BathController@show_Pet' ) ;

         // 更新 : 特定欄位
         Route::put('/update_column/{bath_id}/{column}/{value}' , 'BathController@update_Column') ;

     }) ;

     Route::apiResource( '/bathes' , 'BathController' ) ;


     // @ 美容單 ( beauty ) -----------------------------------------------------------------------------------
     Route::group( ['prefix' => 'beauties'] , function(){

         // 查詢 : 所有 _ 美容單 + 客戶 + 寵物
         Route::get( '/show_with_cus_pet/' , 'BeautyController@show_With_Cus_Pet' ) ;

         // 查詢 : 單一 _ 洗澡單 + 客戶 + 寵物
         Route::get( '/show_with_cus_pet/{id}' , 'BeautyController@show_Single_With_Cus_Pet' ) ;

         // 查詢 : 特定日期，美容單已使用 Q 碼
         Route::get( '/show_qcode/{date}' , 'BeautyController@show_Date_Qcode' );

         // 查詢 : 特定客戶身分證字號，所有美容單紀錄
         Route::get( '/show_customer_id/{id}' , 'BeautyController@show_Customer_ID' ) ;

         // 僅 _ 查詢該美容單，相對應的 _ 寵物消費紀錄
         Route::get( '/show_pet/{pet_serial}/{type}' , 'BeautyController@show_Pet' ) ;

         // 僅 _ 查詢該寵物 ( 依 "寵物編號") ， 所有美容紀錄
         Route::get( '/show_pet_records/{pet_serial}/' , 'BeautyController@show_Pet_Records' ) ;

         // 更新 : 特定欄位
         Route::put('/update_column/{beauty_id}/{column}/{value}' , 'BeautyController@update_Column' ) ;

     }) ;

     Route::apiResource( '/beauties' , 'BeautyController' ) ;


     // @ 服務綜合 _ 基礎、洗澡、美容 ( basic、bath、beauty ) ------------------------------------------------
     Route::group( ['prefix' => 'services'] , function(){

        // 查詢 : 特定日期，各項服務已使用 Q 碼 
        Route::get( '/show_qcode/{date}' , 'ServiceController@show_Date_Qcode' );

        // 查詢 : 特定日期，所有服務資料( 基礎、洗澡、美容 )
        Route::get( '/show_services/{date}' , 'ServiceController@show_Date_Services' );

        // 查詢 : 特定日期【 之後 】，所有服務資料( 基礎、洗澡、美容 )
        Route::get( '/show_after_services/{date}' , 'ServiceController@show_After_Date_Services' );

        // 查詢 : 今日之後，所有 【 預約 】 資料 
        Route::get( '/show_service_reservations/{date}' , 'ServiceController@show_Service_Reservations' );

        // 查詢 : 特定服務_特定資料表 id_ 的 Q 碼
        Route::get( '/show_single_qcode/{service}/{id}' , 'ServiceController@show_Service_Id_Qcode' );

        // 查詢 : 各項服務 + 客戶 + 寵物
        Route::get( '/show_with_cus_pet/' , 'ServiceController@show_With_Cus_Pet' );


        // 查詢 : 部分 _ 各項服務 + 客戶 + 客戶關係人 + 寵物 --> 是否封存 
        Route::get( '/show_with_cus_relative_pet/{is_Archive}/{data_Num}' , 'ServiceController@show_With_Cus_Relative_Pet' );

        // 查詢 : 所有 _ 各項服務 + 客戶 + 客戶關係人 + 寵物 --> 是否封存 
        Route::get( '/show_all_with_cus_relative_pet/{is_Archive}' , 'ServiceController@show_All_With_Cus_Relative_Pet' );


        // 查詢 : 各項服務 + 客戶 + 客戶關係人 + 寵物 --> 是否異常 
        Route::get( '/show_services_by_error/{is_Error}' , 'ServiceController@show_Services_by_Error' );

        // 查詢 : 各項服務 + 客戶 + 客戶關係人 + 寵物 --> 是否銷單 
        Route::get( '/show_services_by_delete/{is_Delete}' , 'ServiceController@show_Services_by_Delete' );

        // 查詢 : 各項服務 + 客戶 + 客戶關係人 + 寵物  --> 是否銷單、是否異常 
        Route::get( '/show_services_is_delete_error_by_date/{date}' , 'ServiceController@show_Services_Is_Delete_Error_By_Date' );

 
        // 查詢 : 各項服務 + 客戶 + 客戶關係人 + 寵物 --> 是否在 "已回家( 房 )" 情況
        Route::get( '/show_services_is_gohome_by_date/{date}' , 'ServiceController@show_Services_Is_GoHome_By_Date' );


     }) ;

     // @ 品種 ( 資料表 : pet_species )
     Route::group( ['prefix' => 'pet_species'] , function(){

         // 查詢 ( 依照 _ 傳入參數 : 欄位、欄位值 )
         Route::get( '/show_by_col_param/{col}/{param}' , 'PetSpeciesController@show_By_Col_Param' );

         // 查詢 : 所有品種，其資料 + 所有服務價格
         Route::get( '/show_all_species_service_prices' , 'PetSpeciesController@show_all_species_service_prices' );

         // 查詢 : 特定品種，其資料 + 所有服務價格
         Route::get( '/show_single_species_service_prices/{pet_id}' , 'PetSpeciesController@show_single_species_service_prices' );

         // 刪除 _ 所有品種
         Route::any( '/destroy_all_species/' , 'PetSpeciesController@destroy_All_Species' );

         // 取得 _ 排序 + 寵物 資料
         Route::get( '/show_sort_data' , 'PetSpeciesController@show_Sort_Order_Data' ) ;

     });

     Route::apiResource( '/pet_species' , 'PetSpeciesController' );

     // @ 品種 & 價錢 ( 資料表 : species --> 之後刪除 2021.07.13 ) -----------------------------------------------------------------------------
     Route::group( ['prefix' => 'species'] , function (){

        // # 查詢 ------
        // 特定品種 ( 依 : 品種名稱 )
        Route::get( '/show_by_species/{species}' , 'SpeciesController@show_By_Species' ) ;

     });

     Route::apiResource( '/species' , 'SpeciesController' );

     // @ 品種 : 排序
     Route::group( [ 'prefix' => 'species_sorts' ] , function (){

         // 取得 _ 排序 + 寵物 資料
         Route::get( '/show_sort_data' , 'SpeciesSortController@show_Sort_Order_Data' ) ;

         // 新增 _ 多筆資料
         Route::post( '/create_multi_data' , 'SpeciesSortController@create_Multi_Data' ) ;

         // 清除 _ 資料表( species_sort ) 所有資料
         Route::get( '/clear_table_data' , 'SpeciesSortController@clear_Table_Data' ) ;

     });

     Route::apiResource( '/species_sorts' , 'SpeciesSortController' );


     // @ 價錢 _ 共同、不因寵物品種而變動的價格設定  ( 資料表 : price --> 之後刪除 2021.07.13 ) -----------------------------------------------------------------------------
     Route::group( ['prefix' => 'prices'] , function (){

         // 查詢 : 特定類別 _ 所有價錢
         Route::get( '/show_type/{type}' , 'PriceController@show_Type_Prices' ) ;

         // 查詢 : 特定類別 _ 特定項目 _ 價錢
         Route::get( '/show_type_item/{type}/{item}' , 'PriceController@show_Single_Type_Item_Price' ) ;

     }) ;

     Route::apiResource( '/prices' , 'PriceController' );


    // @ 價錢 _ 各項服務 ( 資料表 : service_prices ) -----------------------------------------------------------------------------
     Route::group( ['prefix' => 'service_prices'] , function (){

         // 查詢 : 特定類別 _ 所有價錢
         Route::get( '/show_type_prices/{type}' , 'ServicePriceController@show_Type_Prices' ) ;

         // 查詢 : 特定品種 id ( pet_species 資料表 ) _ 所有價錢
         Route::get( '/show_specie_id_prices/{id}' , 'ServicePriceController@show_SpecieId_Prices' ) ;

     }) ;

     Route::apiResource( '/service_prices' , 'ServicePriceController' );

     // @ 員工 -----------------------------------------------------------------------------------

     Route::group( ['prefix' => 'employees'] , function (){


      // 查詢 : 為特定帳號的員工 ( Ex. for 檢查新增員工時，帳號是否重複 )
      Route::get( '/show_employee_with_account/{account}' , 'EmployeeController@show_Employee_With_Account' ) ;



     }) ; 

     Route::apiResource( '/employees' , 'EmployeeController' );


     // @ 時間紀錄 _ 美容師所處理各項服務( 基礎、洗澡、美容 ) 的各種階段 ，所點選的 "時間按鈕" 紀錄
     Route::group( ['prefix' => 'time_records'] , function (){

       // 查詢 : 服務單資料表 ID、服務單型態
       Route::get( '/show_by_type_id/{type}/{id}' , 'TimeRecordsController@show_By_ServiceType_ServiceId' ) ;


       // 查詢 : 服務單資料表 ID 、時間按鈕名稱
       Route::get( '/show_by_id_button/{id}/{button}' , 'TimeRecordsController@show_By_ServiceId_ButtonName' ) ;


       // 刪除 : 時間紀錄 ( 依照 _ 服務單資料表 ID 、時間按鈕名稱 )
       Route::delete( '/destroy_by_id_button/{id}/{button}' , 'TimeRecordsController@destroy_By_ServiceId_ButtonName') ;


    }) ;

    Route::apiResource( '/time_records' , 'TimeRecordsController' );


    // @ 方案 ( for 客戶使用 : 包月洗澡、包月美容、住宿券 ... ) ----------------------------------------------------
    Route::group( [ 'prefix' => 'plans' ] , function (){


        // 查詢 _ 部分：方案 + 客戶資料 + 寵物品種資料
        Route::get( '/show_with_customer_species_records/{data_Num}' , 'PlanController@show_Plans_With_Customer_PetSpecies_PlanUsedRecords' ) ;


        // 查詢 _ 所有：方案 + 客戶資料 + 寵物品種資料
        Route::get( '/show_all_with_customer_species_records' , 'PlanController@show_All_Plans_With_Customer_PetSpecies_PlanUsedRecords' ) ;


        // 查詢 ( 藉由 _ 客戶身分證字號 ) _ 特定方案 + 客戶資料 + 寵物品種資料
        Route::get( '/show_single_with_customer_species_records/{customerId}' , 'PlanController@show_SinglePlan_With_Customer_PetSpecies_PlanUsedRecords' ) ;

        // 查詢 : 特定客戶身分證字號，所有美容單紀錄 ( 與以上方法類似，同樣藉由客戶ID查詢 )
        Route::get( '/show_customer_id/{id}' , 'PlanController@show_Customer_ID' ) ;

        // 查詢 ( 藉由 _ 寵物編號) : 特定寵物，所屬方案紀錄
        Route::get( '/show_Single_Pet_Plans/{petSerial}' , 'PlanController@show_Single_Pet_Plans' ) ;


        // 僅 _ 查詢該寵物 ( 依 "寵物編號") ， 所有美容紀錄 )( 與以上 show_Single_Pet_Plans 相同，show_Single_Pet_Plans 考慮刪除 2022.01.19  )
        Route::get( '/show_pet_records/{pet_serial}/' , 'PlanController@show_Pet_Records' ) ;


        // 查詢 _ 特定寵物 : 方案紀錄
        Route::get( '/show_pet_plans/{pet_Serial}/{pet_Type}' , 'PlanController@show_Pet_Plans' ) ;

        // 查詢 _ 特定日期購買的方案 
        Route::get( '/show_plans_by_date/{date}' , 'PlanController@show_Plans_By_Date' ) ;

    }) ;

    Route::apiResource( '/plans' , 'PlanController' ) ;


    // @ 方案 ( for 自訂方案 ) ----------------------------------------------

    Route::group( [ 'prefix' => 'custom_plans' ] , function (){

      // 搜尋 : 自訂方案 : 名稱           
      Route::get('/show_by_plan_name/{param}' , 'CustomPlanController@show_By_Plan_Name') ;

    }) ;

    Route::apiResource( '/custom_plans' , 'CustomPlanController' ) ;

    
    // @ 方案 ( 使用紀錄 ) ----------------------------------------------------
    Route::apiResource( '/plan_records' , 'PlanUsedRecordsController' ) ;


    // @ 美容師請求櫃台，向客戶確認 ( 加價 ) 紀錄 -------------------------------
    Route::group( [ 'prefix' => 'customer_confirms' ] , function (){

        //  依 服務/確認日期 查詢
        Route::get( '/show_by_service_date/{serviceDate}' , 'CustomerConfirmController@show_By_Service_Date' ) ;

        // 依 _ 服務類型( 基礎、洗澡、美容 ) + 服務單 id 查詢
        Route::get( '/show_by_service_type_id/{serviceType}/{serviceId}' , 'CustomerConfirmController@show_By_Service_Type_Id' ) ;

    }) ;

    Route::apiResource( '/customer_confirms' , 'CustomerConfirmController' ) ;

    // @ 住宿 ----------------------------------------------------

    Route::group( [ 'prefix' => 'lodges' ] , function (){

        // 查詢 : 所有住宿 + 客戶 + 客戶關係人 + 寵物
        Route::get( '/show_with_cus_relative_pet/{is_Archive}' , 'LodgeController@show_With_Cus_Relative_Pet' );

        // 查詢 : 特定客戶身分證字號，所有住宿紀錄
        Route::get( '/show_customer_id/{id}' , 'LodgeController@show_Customer_ID' ) ;


        // 僅 _ 查詢該寵物 ( 依 "寵物編號") ， 所有住宿紀錄
        Route::get( '/show_pet_records/{pet_serial}/' , 'LodgeController@show_Pet_Records' ) ;


    }) ;

    Route::apiResource( '/lodges' , 'LodgeController' ) ;

    // @ 安親 ----------------------------------------------------

    Route::group( [ 'prefix' => 'cares' ] , function (){

        // 查詢 : 所有安親 + 客戶 + 客戶關係人 + 寵物
        Route::get( '/show_with_cus_relative_pet/{is_Archive}' , 'CareController@show_With_Cus_Relative_Pet' );

        // 查詢 : 特定客戶身分證字號，所有安親紀錄
        Route::get( '/show_customer_id/{id}' , 'CareController@show_Customer_ID' ) ;

        // 僅 _ 查詢該寵物 ( 依 "寵物編號") ， 所有安親紀錄
        Route::get( '/show_pet_records/{pet_serial}/' , 'CareController@show_Pet_Records' ) ;

    }) ;

    Route::apiResource( '/cares' , 'CareController' ) ;


    // @ 服務異常處理紀錄 ----------------------------------------------------

    Route::group( [ 'prefix' => 'service_error_records' ] , function (){

      // 查詢 : 異常紀錄 ( 依照 : 特定服務 _ 類別、id )
      Route::get( '/show_by/{service_type}/{service_id}' , 'ServiceErrorRecordsController@show_Service_Error_Records' );

    }) ;

    Route::apiResource( '/service_error_records' , 'ServiceErrorRecordsController' ) ;


    // @ 其他收支項目 ----------------------------------------------------

    Route::group( [ 'prefix' => 'others' ] , function (){

    
      // 查詢 _ 特定日期購買的方案 
      Route::get( '/show_others_by_date/{date}' , 'OtherController@show_Plans_By_Date' ) ;



    }) ;

    Route::apiResource( '/others' , 'OtherController' ) ;




});
