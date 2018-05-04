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
Route::get('test',function (){
    $a=[1,3,5,7];
    $b = [1,7];
    $c=[];
    $count =0;
    for ($i=0;$i<count($a);$i++){
        if($a[$i]==$b[$i-$count]){
            $c[$i]=$b[$i-$count];
        }else{
            $count+=1;
            $c[$i]=0;
        }
    }
    dd($c);
});
Route::get('/','UserController@index');
Route::post('login','UserController@login');
Route::any('upload','SystemController@upload');
Route::get('login','UserController@loginPage')->name('login');
Route::get('logout','UserController@logout');
//Route::post('project/create','ProjectController@createProject');
Route::get('projects','ProjectController@searchProject');
Route::get('project/unit','ProjectController@searchProjectUnit');
Route::get('teams','SystemController@getTeams');
Route::get('suppliers','SystemController@searchSupplier');
Route::get('search/category','SystemController@searchCategory');
Route::get('project/material','ProjectController@searchProjectMaterial');
Route::get('search/budget','ProjectController@searchBudget');
Route::get('search/material','SystemController@searchMaterial');
Route::get('search/stock/material','SystemController@searchStockMaterial');
Route::get('search/loan/user','LoanController@searchLoanUser');
Route::get('search/purchase','PurchaseController@searchPurchase');
Route::get('search/warehouse','StockController@searchWarehouse');
Route::get('search/purchase/warehouse','PurchaseController@searchPurchaseWarehouse');
Route::get('search/purchase/material','PurchaseController@searchPurchaseMaterial');
Route::get('banks','SystemController@searchBank');
Route::get('users','UserController@getUsers');
//export
Route::get('export/user','ExcelController@exportUser');
Route::get('export/supplier','ExcelController@exportSupplier');
Route::get('export/material','ExcelController@exportMaterial');
Route::get('export/warehouse','ExcelController@exportWarehouse');
Route::get('export/bank','ExcelController@exportBank');
Route::get('export/team','ExcelController@exportTeam');
Route::get('export/pay/apply','ExcelController@exportPayApplies');
Route::get('export/loan/pay/list','ExcelController@exportLoanPayList');
Route::get('export/loan/submit','ExcelController@exportLoanSubmit');
Route::group(['middleware'=>'auth'],function (){
   Route::get('project/list','ProjectController@listProject');
   Route::get('index','UserController@index');
   Route::get('project/create','ProjectController@createProjectPage');
   Route::post('project/create','ProjectController@createProject');
   Route::get('project/detail','ProjectController@listProjectsDetail');
   Route::get('project/check','ProjectController@showProjectsDetail');
   Route::get('project/auth','ProjectController@showProjectsAuth');
   Route::get('project/auth_edit','ProjectController@createProjectAuthPage');
   Route::post('project/auth_edit','ProjectController@createProjectAuth');
   Route::get('project/auth/edit','ProjectController@showAuthPage');
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
   Route::get('invoice/create','SystemController@createInvoicePage');
   Route::get('invoice/list','SystemController@listInvoicesPage');
   Route::post('invoice/create','SystemController@createInvoice');
   Route::post('team/create','SystemController@createTeam');
   Route::get('team/list','SystemController@listTeamsPage');
   Route::get('team/create','SystemController@createTeamPage');
   Route::post('project/type/create','SystemController@createProjectType');
   Route::get('project/type/create','SystemController@createProjectTypePage');
   Route::get('project/types/list','SystemController@listProjectTypesPage');
   Route::post('category/create','SystemController@addCategory');
   Route::get('category/create','SystemController@addCategoryPage');
   Route::get('category/list','SystemController@listCategoryPage');
   Route::get('del/material','SystemController@delMaterial');
   Route::get('del/user ','UserController@delUser');
   Route::get('del/project/type ','SystemController@delProjectType');
   Route::get('del/supplier ','SystemController@delSupplier');
   Route::get('del/warehouse ','SystemController@delWarehouse');
   Route::get('del/bank ','SystemController@delBank');
   Route::get('del/invoice','SystemController@delInvoiceType');
   Route::get('del/team ','SystemController@delTeam');
   Route::get('del/category ','SystemController@delCategory');
   Route::get('budget/list','ProjectController@listBudgetsPage');
//   Route::get('budget/detail','ProjectController@showBudgetPage');
   Route::post('create/user','UserController@register');
   Route::get('user/list','UserController@listUsers');
   Route::get('user/create','UserController@createUserPage');
   Route::get('auth/check','UserController@listUserRole');
   Route::get('auth/edit','UserController@editUserRoles');
   Route::post('auth/edit','UserController@addUserRoles');

   //施工管理


   Route::post('pay/apply','PayController@createFinishPayApply');
   //验收和收款管理
   Route::get('check/list','ProjectController@checkListsPage');
   Route::post('project/acceptance','ProjectController@acceptanceProject');
   Route::get('project/acceptance','ProjectController@acceptancePage');
   Route::get('check/detail','ProjectController@checkDetailPage');
   Route::get('check/tips','ProjectController@checkTipsPage');
   Route::get('create/tips','ProjectController@createTipsPage');
   Route::post('project/invoice','ProjectController@createInvoice');
   Route::post('project/collect','ProjectController@createCollect');
   Route::get('check/invoice','ProjectController@checkInvoicePage');
   Route::get('check/collect','ProjectController@checkCollectPage');
   Route::post('create/tips','ProjectController@createTips');
//   Route::get('check/tips','ProjectController@checkTipsPage');
//   //预算管理
   Route::get('budget/detail','ProjectController@detailBudgetsPage');
    Route::post('create/budget','ProjectController@addBudget');
    Route::get('create/budget','ProjectController@addBudgetPage');
    Route::get('budget/print','ProjectController@printBudget');
   //采购管理
    Route::get('purchases/list','ProjectController@listPurchasesPage');
    Route::get('project/purchases/list','ProjectController@listProjectPurchasesPage');
//    Route::get('purchase/pay/list','ProjectController@listProjectPurchasesPage');
    Route::get('purchase/pay/list','ProjectController@listPurchasesPayPage');
    Route::get('purchase/charge/list','ProjectController@listPurchasesChargePage');
    Route::get('purchase/collect/list','ProjectController@purchaseCollectPage');
    Route::get('purchase/parity/list','ProjectController@purchaseParityPage');
    Route::post('purchase/create','ProjectController@createPurchase');
    Route::get('purchase/check','PurchaseController@checkPurchase');
    Route::get('purchase/pass','PurchaseController@passPurchase');
    Route::post('purchase/select/pass','PurchaseController@selectPass');
    Route::post('purchase/select/check','PurchaseController@selectCheck');
    Route::post('purchase/payment/create','PurchaseController@createPayment');
    Route::get('buy/edit/payment','PurchaseController@editPaymentPage');
    Route::get('purchase/payment/check','PurchaseController@checkPayment');
    Route::get('buy/list/invoice','PurchaseController@listInvoices');
    Route::get('buy/create／invoice','PurchaseController@createInvoicePage');
    Route::post('purchase/payment/select/check','PurchaseController@selectPaymentCheck');
    Route::post('purchase/payment/finish','PurchaseController@finishPayment');
    Route::get('purchase/payment/finish','PurchaseController@finishPaymentPage');
    Route::post('purchase/invoice/create','PurchaseController@createInvoices');
    Route::get('buy/budgetary','ProjectController@createBudgetaryPage');
    Route::get('buy/extrabudgetary','ProjectController@createExtraBudgetaryPage');
    Route::get('buy/budgetary_buy','StockController@buyBudgetary');
    Route::get('buy/payment/list','PurchaseController@listBuyPayment');
    Route::get('buy/payment/create','PurchaseController@createBuyPayment');
    Route::get('stock/check/budgetary','StockController@budgetaryCheckPage');
    Route::get('buy/create/invoice','PurchaseController@createInvoicePage');
    //库存管理
    Route::get('stock/list','StockController@listStockList');
    Route::get('stock/buy/list','StockController@listBuyList');
    Route::get('stock/return/list','StockController@listReturnList');
    Route::get('stock/get/list','StockController@listGetList');
    Route::get('stock/out/list','StockController@listOutList');
    Route::get('stock/add/buy','StockController@addBuyPage');
    Route::post('stock/buy/add','StockController@addBuy');
    Route::get('store/buy_check','StockController@buyCheckPage');
    Route::get('stock/return/add','StockController@addReturnPage');
    Route::post('stock/return/add','StockController@addReturn');
    Route::get('stock/get/add','StockController@addGetPage');
    Route::post('stock/get/add','StockController@addGet');
    Route::get('stock/get/print','StockController@printGet');
    Route::get('stock/return/print','StockController@printReturn');
    Route::get('stock/out/add','StockController@addOutPage');
    Route::post('stock/out/add','StockController@addOut');
    Route::get('stock/stock/out_add_add','StockController@addOutAddPage');
    Route::get('stock/purchase','StockController@getPurchaseData');
    Route::get('stock/check','StockController@checkStock');

    //施工管理
    Route::get('build/list','BuildController@listBuildPage');
    Route::get('build/deal/list','BuildController@listDealPage');
    Route::get('build/deal/create','BuildController@addDealPage');
    Route::post('create/contract','ConstructionController@addContract');
    Route::post('finish/add','PayController@addRequestPayment');
    Route::get('build/finish/list','BuildController@listFinishPage');
    Route::get('build/finish/create','BuildController@createFinishPage');
    Route::get('build/pay/list','BuildController@listPayPage');
    Route::get('build/get/list','BuildController@listGetPage');
    Route::get('build/finish/single','BuildController@finishSinglePage');
    Route::get('build/finish/print','BuildController@printBuildFinish');
    Route::get('build/pay/single','BuildController@paySinglePage');
    Route::get('build/finish/check','PayController@checkRequestPayment');
    Route::get('build/finish/pass','PayController@passRequestPayment');
    Route::post('build/finish/select/checker','PayController@selectChecker');
    Route::post('build/finish/select/passer','PayController@selectPasser');
    Route::get('build/pay/finish','BuildController@finishBuildPayPage');
    Route::post('build/pay/apply','BuildController@finishBuildPayApply');
    Route::get('build/pay/check','BuildController@checkBuildPayApply');
    Route::get('build/pay/pass','BuildController@passBuildPayApply');
    Route::post('build/pay/select/checker','BuildController@selectPayApplyChecker');
    Route::post('build/pay/select/passer','BuildController@selectPayApplyPasser');
    Route::get('build/pay/add','BuildController@payAddPage');
    Route::post('build/pay/add','BuildController@payAdd');
    Route::get('build/get/single','BuildController@getSinglePage');
    Route::get('build/get/add','BuildController@getAddPage');
    Route::post('build/get/add','BuildController@getAdd');
    Route::get('build/pay/print','BuildController@printBuildPay');
    Route::get('build/get/print','BuildController@printBuildGet');
    Route::get('build/get/edit','BuildController@editBuildGetPage');
    //报销与借款管理
    Route::get('loan/list','PayController@listLoanPage');
    Route::get('loan/detail/list','PayController@listDetailPage');
    Route::get('loan/loan/list','PayController@listLoanListPage');
    Route::get('loan/loan/add','PayController@addLoanPage');
    Route::post('loan/add','PayController@createLoanApply');
    Route::get('loan/cancel','PayController@cancelLoan');
    Route::get('loan/confirm','PayController@confirmLoan');
    Route::get('loan/select','PayController@selectLoanApprover');
    Route::get('loan/submit/list','PayController@listSubmitListPage');
    Route::post('loan/submit/other','PayController@createSubmitList');
    Route::get('loan/submit/other','PayController@createSubmitOtherPage');
    Route::post('loan/submit/project','PayController@createSubmitProject');
    Route::get('loan/submit/project','PayController@createSubmitProjectPage');
    Route::get('loan/submit/single','PayController@loanSubmitSingle');
    Route::post('loan/pay/add','PayController@createLoanPay');
    Route::post('loan/pay/finish','PayController@finishLoan');
    Route::get('search/loan/user','LoanController@searchLoanUser');
    Route::get('search/loan/submit','LoanController@searchLoanSubmit');
    Route::get('check/submit','LoanController@checkSubmit');
    Route::get('pass/submit','LoanController@passSubmit');
    Route::post('select/check/submit','LoanController@selectSubmitCheck');
    Route::post('select/pass/submit','LoanController@selectSubmitPass');
    Route::get('loan/pay','PayController@showLoanPay');
    Route::get('loan/pay/add','LoanController@showLoanPayAdd');
    Route::get('loan/pay/list','PayController@listLoanPayPage');
    Route::post('loan/submit/other/check','LoanController@selectSubmitCheck');
    Route::post('loan/submit/other/pass','LoanController@selectSubmitPass');
    Route::get('loan/print','LoanController@printLoan');
    Route::get('loan/submit/print','LoanController@printLoanSubmit');
    //费用付款管理
    Route::get('pay/add','PayController@createPayApplyPage');
    Route::post('pay/add','PayController@createPayApply');
    Route::get('pay/list','PayController@listPayApply');
    Route::post('pay/pay','PayController@finishPayApply');
    Route::get('pay/pay','PayController@payPage');
    Route::get('pay/single','PayController@paySinglePage');
    Route::get('pay/cancel','PayController@cancelApply');
    Route::get('pay/print','PayController@printPay');
    Route::get('pay/confirm','PayController@confirmApply');
    Route::post('pay/select','PayController@selectApprover');
    Route::get('pay/print','PayController@printPay');

});