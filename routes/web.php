<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function (){
    $a= sprintf("%03d", 15) ;
    echo 'XM'.date('Yms',time()).$a;
});
Route::post('login','UserController@login');

Route::get('login','UserController@loginPage');
Route::get('logout','UserController@logout');
Route::post('project/create','ProjectController@createProject');
Route::group(['middleware'=>'auth'],function (){
   Route::get('project/list','ProjectController@listProject');
   Route::get('index','UserController@index');
   Route::get('project/create','ProjectController@createProjectPage');
   Route::get('supplier/list','SystemController@listSupplierPage');
   Route::post('supplier/create','SystemController@createSupplier');
   Route::get('supplier/create','SystemController@createSupplierPage');
   Route::get('material/list','SystemController@listMaterialPage');
   Route::get('material/create','SystemController@createMaterialPage');
   Route::post('material/create','SystemController@createMaterialPage');
   Route::get('warehouse/create','SystemController@createWarehousePage');
   Route::post('warehouse/create','SystemController@createWarehouse');
   Route::get('bank/create','SystemController@createBankAccountPage');
   Route::get('bank/list','SystemController@listBankAccountsPage');
   Route::post('bank/create','SystemController@createBankAccount');
   Route::get('invoice/create','SystemController@createInvoice');
   Route::get('invoice/list','SystemController@listInvoicesPage');
   Route::post('invoice/create','SystemController@createInvoicePage');
   Route::get('team/create','SystemController@createTeam');
   Route::get('team/list','SystemController@listTeamsPage');
   Route::post('team/create','SystemController@createTeamPage');
   Route::get('project/type/create','SystemController@createProjectType');
   Route::get('project/types/list','SystemController@createTeamPage');
   Route::post('project/type/create','SystemController@createTeamPage');

});