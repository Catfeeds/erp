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

Route::get('/','UserController@index');
Route::post('login','UserController@login');
Route::any('upload','SystemController@upload');
Route::get('login','UserController@loginPage');
Route::get('logout','UserController@logout');
//Route::post('project/create','ProjectController@createProject');
Route::get('projects','ProjectController@searchProject');
Route::get('users','UserController@getUsers');
Route::group(['middleware'=>'auth'],function (){
   Route::get('project/list','ProjectController@listProject');
   Route::get('index','UserController@index');
   Route::get('project/create','ProjectController@createProjectPage');
   Route::post('project/create','ProjectController@createProject');
   Route::get('project/detail','ProjectController@listProjectsDetail');
   Route::get('project/check','ProjectController@showProjectsDetail');
   //数据维护
   Route::get('supplier/list','SystemController@listSupplierPage');
   Route::post('supplier/create','SystemController@createSupplier');
   Route::get('supplier/create','SystemController@createSupplierPage');
   Route::get('material/list','SystemController@listMaterialPage');
   Route::get('material/create','SystemController@createMaterialPage');
   Route::post('material/create','SystemController@createMaterial');
   Route::get('warehouse/create','SystemController@createWarehousePage');
   Route::get('warehouse/list','SystemController@listWarehousesPage');
   Route::post('warehouse/create','SystemController@createWarehouse');
   Route::get('bank/create','SystemController@createBankAccountPage');
   Route::get('bank/list','SystemController@listBankAccountsPage');
   Route::post('bank/create','SystemController@createBankAccount');
   Route::get('invoice/create','SystemController@createInvoice');
   Route::get('invoice/list','SystemController@listInvoicesPage');
   Route::post('invoice/create','SystemController@createInvoicePage');
   Route::post('team/create','SystemController@createTeam');
   Route::get('team/list','SystemController@listTeamsPage');
   Route::get('team/create','SystemController@createTeamPage');
   Route::post('project/type/create','SystemController@createProjectType');
   Route::get('project/type/create','SystemController@createProjectTypePage');
   Route::get('project/types/list','SystemController@createTeamPage');
   Route::post('category/create','SystemController@addCategory');
   Route::post('create/budget','ProjectController@addBudget');
   Route::get('create/budget','ProjectController@addBudgetPage');
   Route::get('budget/list','ProjectController@listBudgetsPage');
//   Route::get('budget/detail','ProjectController@showBudgetPage');
   Route::post('create/user','UserController@register');
   Route::get('user/list','UserController@listUsers');
   Route::get('user/create','UserController@createUserPage');
   Route::get('auth/check','UserController@listUserRole');
   Route::get('auth/edit','UserController@editUserRoles');
   Route::post('auth/edit','UserController@addUserRoles');
   //费用付款管理
   Route::get('pay/add','PayController@createPayApplyPage');
   Route::post('pay/add','PayController@createPayApply');
   Route::get('pay/list','PayController@listPayApply');
   //施工管理
   Route::post('create/contract','ConstructionController@addContract');
   Route::post('finish/add','PayController@addRequestPayment');
   Route::post('pay/apply','PayController@createFinishPayApply');
   //验收和收款管理
   Route::get('check/list','ProjectController@checkListsPage');
   Route::get('check/detail','ProjectController@checkDetailPage');
   //预算管理
   Route::get('budget/detail','ProjectController@detailBudgetsPage');
});