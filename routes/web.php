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
    $a=[['date'=>'2018-3-2','price'=>2],['date'=>'2018-3-5','price'=>2]];
    $c=[['date'=>'2018-3-4','count'=>2],['date'=>'2018-3-2','count'=>2]];
    $d = array_merge($a,$c);
    array_multisort(array_column($d,'date'),SORT_ASC,$d);
    dd($d);
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
Route::get('search/purchase/project','ProjectController@searchPurchaseProject');
Route::get('search/loaned/user','PayController@searchLoanUser');
Route::get('search/stock/get','StockController@searchStockGet');
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
Route::get('export/loan/detail','ExcelController@exportLoanDetailList');
Route::get('export/stock/list','ExcelController@exportStockList');
Route::get('export/project/detail','ExcelController@exportProjectDetail');
Route::get('export/project/list','ExcelController@exportProjectList');
Route::get('export/purchase/collect','ExcelController@exportPurchaseCollect');
Route::get('export/build/list','ExcelController@exportBuildList');
Route::get('export/build/finish/list','ExcelController@exportBuildFinishList');
Route::get('export/build/pay/list','ExcelController@exportBuildPayList');
Route::get('export/budget','ExcelController@exportBudget');
Route::get('export/budget/list','ExcelController@exportBudgetList');
Route::get('export/purchases/list','ExcelController@exportPurchaseList');
Route::get('export/purchases/pay/list','ExcelController@exportPurchasePayList');
Route::get('export/purchase/charge/list','ExcelController@exportPurchaseChargeList');
Route::get('export/purchase/parity/list','ExcelController@exportPurchaseParityList');
Route::get('export/stock/buy/list','ExcelController@exportStockBuyList');
Route::get('export/stock/return/list','ExcelController@exportStockReturnList');
Route::get('export/stock/get/list','ExcelController@exportStockGetList');
Route::get('export/stock/out/list','ExcelController@exportStockOutList');
Route::get('export/build/get/list','ExcelController@exportBuildGetList');
//Route::get('export/stock/out/list','ExcelController@exportStockOutList');
Route::post('import/budget','ExcelController@importBudget');
Route::post('import/payment','ExcelController@importPayment');
Route::group(['middleware'=>'auth'],function (){
   Route::get('project/list','ProjectController@listProject')->middleware('role:project_list');
   Route::get('index','UserController@index');
   Route::get('project/create','ProjectController@createProjectPage')->middleware('role:project_edit');
   Route::post('project/create','ProjectController@createProject')->middleware('role:project_edit');
   Route::get('project/detail','ProjectController@listProjectsDetail')->middleware('role:project_detail');
   Route::get('project/check','ProjectController@showProjectsDetail');
   Route::get('project/auth','ProjectController@showProjectsAuth');
   Route::get('project/auth_edit','ProjectController@createProjectAuthPage');
   Route::post('project/auth_edit','ProjectController@createProjectAuth');
   Route::get('project/auth/edit','ProjectController@showAuthPage');
   Route::get('confirm/project','ProjectController@confirmProject');
   Route::get('delete/project','ProjectController@deleteProject');
   //数据维护
   Route::get('supplier/list','SystemController@listSupplierPage')->middleware('role:data_supplier');
   Route::post('supplier/create','SystemController@createSupplier')->middleware('role:data_supplier');
   Route::get('supplier/create','SystemController@createSupplierPage')->middleware('role:data_supplier');
   Route::get('material/list','SystemController@listMaterialPage')->middleware('role:data_material');
   Route::get('material/create','SystemController@createMaterialPage')->middleware('role:data_material');
   Route::post('material/create','SystemController@createMaterial')->middleware('role:data_material');
   Route::get('warehouse/create','SystemController@createWarehousePage')->middleware('role:data_stock');
   Route::get('warehouse/list','SystemController@listWarehousesPage')->middleware('role:data_stock');
   Route::post('warehouse/create','SystemController@createWarehouse')->middleware('role:data_stock');
   Route::get('bank/create','SystemController@createBankAccountPage')->middleware('role:data_bank');
   Route::get('bank/list','SystemController@listBankAccountsPage')->middleware('role:data_bank');
   Route::post('bank/create','SystemController@createBankAccount')->middleware('role:data_bank');
   Route::get('invoice/create','SystemController@createInvoicePage')->middleware('role:data_invoice_type');
   Route::get('invoice/list','SystemController@listInvoicesPage')->middleware('role:data_invoice_type');
   Route::post('invoice/create','SystemController@createInvoice')->middleware('role:data_invoice_type');
   Route::post('team/create','SystemController@createTeam')->middleware('role:data_build_team');
   Route::get('team/list','SystemController@listTeamsPage')->middleware('role:data_build_team');
   Route::get('team/create','SystemController@createTeamPage')->middleware('role:data_build_team');
   Route::post('project/type/create','SystemController@createProjectType')->middleware('role:data_project_type');
   Route::get('project/type/create','SystemController@createProjectTypePage')->middleware('role:data_project_type');
   Route::get('project/types/list','SystemController@listProjectTypesPage')->middleware('role:data_project_type');
   Route::post('category/create','SystemController@addCategory')->middleware('role:data_payment');
   Route::get('category/create','SystemController@addCategoryPage')->middleware('role:data_payment');
   Route::get('category/edit','SystemController@editCategoryPage')->middleware('role:data_payment');
   Route::get('category/list','SystemController@listCategoryPage')->middleware('role:data_payment');
   Route::get('del/material','SystemController@delMaterial')->middleware('role:data_material');
   Route::get('del/user ','UserController@delUser');
   Route::get('del/project/type ','SystemController@delProjectType')->middleware('role:data_project_type');
   Route::get('del/supplier ','SystemController@delSupplier')->middleware('role:data_supplier');
   Route::get('del/warehouse ','SystemController@delWarehouse')->middleware('role:data_stock');
   Route::get('del/bank ','SystemController@delBank')->middleware('role:data_bank');
   Route::get('del/invoice','SystemController@delInvoiceType')->middleware('role:data_invoice_type');
   Route::get('del/team ','SystemController@delTeam')->middleware('role:data_build_team');
   Route::get('del/category ','SystemController@delCategory')->middleware('role:data_payment');
   Route::get('budget/list','ProjectController@listBudgetsPage')->middleware('role:budget_list');
//   Route::get('budget/detail','ProjectController@showBudgetPage');
   Route::post('create/user','UserController@register')->middleware('role:data_user');
   Route::get('user/list','UserController@listUsers')->middleware('role:data_user');
   Route::get('user/create','UserController@createUserPage')->middleware('role:data_user');
   Route::get('auth/check','UserController@listUserRole')->middleware('role:data_user');
   Route::get('auth/edit','UserController@editUserRoles')->middleware('role:data_user');
   Route::post('auth/edit','UserController@addUserRoles')->middleware('role:data_user');

   //施工管理


   Route::post('pay/apply','PayController@createFinishPayApply');
   //验收和收款管理
   Route::get('check/list','ProjectController@checkListsPage')->middleware('role:check_list');
   Route::post('project/acceptance','ProjectController@acceptanceProject');
   Route::get('project/acceptance','ProjectController@acceptancePage');
   Route::get('check/detail','ProjectController@checkDetailPage');
   Route::get('check/tips','ProjectController@checkTipsPage')->middleware('role:check_tip');
   Route::get('create/tips','ProjectController@createTipsPage');
   Route::post('project/invoice','ProjectController@createInvoice');
   Route::post('project/collect','ProjectController@createCollect');
   Route::get('check/invoice','ProjectController@checkInvoicePage');
   Route::get('check/collect','ProjectController@checkCollectPage');
   Route::post('create/tips','ProjectController@createTips');
   Route::get('check/project','ProjectController@checkProject');
   Route::get('pass/project','ProjectController@passProject');
   Route::post('select/project/checker','ProjectController@selectChecker');
   Route::post('select/project/passer','ProjectController@selectPasser');
   Route::get('check/invoice/print','ProjectController@checkPrintInvoice');
   Route::get('check/master/print','ProjectController@checkMasterInvoice');
   Route::get('check/sub/print','ProjectController@checkSubInvoice');
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
    Route::get('purchase/parity/list','ProjectController@purchaseParityPage')->middleware('role:buy_parity');
    Route::post('purchase/create','ProjectController@createPurchase');
    Route::get('tip','ProjectController@getTip');
    Route::post('tip','ProjectController@editTip');
    Route::get('collect','ProjectController@collect');
    Route::post('collect','ProjectController@editCollect');
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
    Route::get('buy/print/budgetary','PurchaseController@printBuyBudgetary');
    Route::get('buy/print/payment','PurchaseController@printBuyPayment');
    Route::get('buy/print/invoice','PurchaseController@printBuyInvoice');
    Route::get('buy/edit/invoice','PurchaseController@editBuyInvoicePage');
    Route::post('buy/edit/invoice','PurchaseController@editBuyInvoice');
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
    Route::get('stock/out/single','StockController@singleOutPage');
    Route::get('stock/print/buy','StockController@printBuy');

    //施工管理
    Route::get('build/list','BuildController@listBuildPage')->middleware('role:build_list');
    Route::get('build/deal/list','BuildController@listDealPage')->middleware('role:build_contract_list');
    Route::get('build/deal/create','BuildController@addDealPage')->middleware('role:build_contract_edit');
    Route::post('create/contract','ConstructionController@addContract');
    Route::post('finish/add','PayController@addRequestPayment');
    Route::get('build/finish/list','BuildController@listFinishPage')->middleware('role:build_finish_list');
    Route::get('build/finish/create','BuildController@createFinishPage')->middleware('role:build_finish_edit');
    Route::get('build/pay/list','BuildController@listPayPage');
    Route::get('build/get/list','BuildController@listGetPage');
    Route::get('build/finish/single','BuildController@finishSinglePage');
    Route::get('build/finish/print','BuildController@printBuildFinish');
    Route::get('build/pay/single','BuildController@paySinglePage');
    Route::get('build/finish/check','PayController@checkRequestPayment');
    Route::get('build/finish/pass','PayController@passRequestPayment');
    Route::get('build/finish/delete','PayController@deleteRequestPayment');
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
    Route::post('build/get/edit','BuildController@editBuildGet');
    Route::get('build/deal/detail','BuildController@detailDealPage');
    Route::get('build/finish/edit','BuildController@editFinishPage');
    //报销与借款管理
    Route::get('loan/list','PayController@listLoanPage');
//    Route::get('loan/detail/list','PayController@listDetailPage');
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
    Route::get('delete/submit','LoanController@deleteSubmit');
    Route::post('select/check/submit','LoanController@selectSubmitCheck');
    Route::post('select/pass/submit','LoanController@selectSubmitPass');
    Route::get('loan/pay','PayController@showLoanPay');
    Route::get('loan/pay/add','LoanController@showLoanPayAdd');
    Route::get('loan/pay/list','PayController@listLoanPayPage');
    Route::post('loan/submit/other/check','LoanController@selectSubmitCheck');
    Route::post('loan/submit/other/pass','LoanController@selectSubmitPass');
    Route::get('loan/print','LoanController@printLoan');
    Route::get('loan/submit/print','LoanController@printLoanSubmit');
    Route::get('loan/pay/single','LoanController@singlePayPage');
    Route::get('loan/detail/list','LoanController@listDetailPage');
    Route::get('loan/pay/print','LoanController@payPrint');
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