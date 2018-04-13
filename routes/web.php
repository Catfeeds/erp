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
Route::get('project/unit','ProjectController@searchProjectUnit');
Route::get('teams','SystemController@getTeams');
Route::get('suppliers','SystemController@searchSupplier');
Route::get('project/material','ProjectController@searchProjectMaterial');
Route::get('banks','SystemController@searchBank');
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

   //施工管理
   Route::post('create/contract','ConstructionController@addContract');
   Route::post('finish/add','PayController@addRequestPayment');
   Route::post('pay/apply','PayController@createFinishPayApply');
   //验收和收款管理
   Route::get('check/list','ProjectController@checkListsPage');
   Route::post('project/acceptance','ProjectController@acceptanceProject');
   Route::get('project/acceptance','ProjectController@acceptancePage');
   Route::get('check/detail','ProjectController@checkDetailPage');
   Route::get('check/tips','ProjectController@checkTipsPage');
   Route::get('create/tips','ProjectController@createTipsPage');
   Route::post('create/tips','ProjectController@createTips');
//   Route::get('check/tips','ProjectController@checkTipsPage');
//   //预算管理
   Route::get('budget/detail','ProjectController@detailBudgetsPage');
   //采购管理
    Route::get('purchases/list','ProjectController@listPurchasesPage');
    Route::get('project/purchases/list','ProjectController@listProjectPurchasesPage');
//    Route::get('purchase/pay/list','ProjectController@listProjectPurchasesPage');
    Route::get('purchase/pay/list','ProjectController@listPurchasesPayPage');
    Route::get('purchase/charge/list','ProjectController@listPurchasesChargePage');
    Route::get('purchase/collect/list','ProjectController@purchaseCollectPage');
    Route::get('purchase/parity/list','ProjectController@purchaseParityPage');
    Route::post('purchase/create','ProjectController@createPurchase');
    //库存管理
    Route::get('stock/list','StockController@listStockList');
    Route::get('stock/buy/list','StockController@listBuyList');
    Route::get('stock/return/list','StockController@listReturnList');
    Route::get('stock/get/list','StockController@listGetList');
    Route::get('stock/out/list','StockController@listOutList');
    //施工管理
    Route::get('build/list','BuildController@listBuildPage');
    Route::get('build/deal/list','BuildController@listDealPage');
    Route::get('build/deal/create','BuildController@addDealPage');
    Route::get('build/finish/list','BuildController@listFinishPage');
    Route::get('build/finish/create','BuildController@createFinishPage');
    Route::get('build/pay/list','BuildController@listPayPage');
    Route::get('build/get/list','BuildController@listGetPage');
    //报销与借款管理
    Route::get('loan/list','PayController@listLoanPage');
    Route::get('loan/detail/list','PayController@listDetailPage');
    Route::get('loan/loan/list','PayController@listLoanListPage');
    Route::get('loan/submit/list','PayController@listSubmitListPage');
    Route::post('loan/submit/other','PayController@createSubmitList');
    Route::post('loan/submit/project','PayController@createSubmitProject');
    //费用付款管理
    Route::get('pay/add','PayController@createPayApplyPage');
    Route::post('pay/add','PayController@createPayApply');
    Route::get('pay/list','PayController@listPayApply');
    Route::post('pay/pay','PayController@listPayApply');
});