<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Material;
use App\Models\Project;
use App\Models\Purchase;
use App\Models\PurchaseList;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class StockController extends Controller
{
    //
    public function searchWarehouse()
    {
        $name = Input::get('name');
        $db = DB::table('warehouses');
        if ($name){
            $db->where('name','like','%'.$name.'%');
        }
        $data = $db->get();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$data
        ]);
    }
    public function listStockList()
    {
        $stocks = Stock::paginate(10);
        return view('stock.list',['stocks'=>$stocks]);
    }
    public function listBuyList()
    {
        $lists = Purchase::paginate(10);
        return view('stock.buy_list',['lists'=>$lists]);
    }
    public function listReturnList()
    {
        return view('stock.return_list');
    }
    public function listGetList()
    {
        return view('stock.get_list');
    }
    public function listOutList()
    {
        return view('stock.out_list');
    }
    public function checkBuy()
    {

    }
    public function addBuy()
    {

    }
    public function addReturn()
    {

    }
    public function addGet()
    {

    }
    public function addOut()
    {

    }
    public function buyBudgetary(Request $post)
    {
        $id = $post->get('id');
//        dd($id);
        $project = Project::find($id);
        $invoice = Invoice::all();
        $budgets = $project->budget()->get();
        foreach ($budgets as $budget){
            $budget->material = Material::find($budget->material_id);
        }
//        dd($budgets);
        return view('buy.budgetary_buy',[
            'project'=>$project,
            'invoices'=>$invoice,
            'budgets'=>$budgets
        ]);
    }
    public function buyCheckPage()
    {
        $id = \Illuminate\Support\Facades\Input::get('id');
        $purchase = Purchase::find($id);
        $lists = PurchaseList::where('purchase_id','=',$id)->get();
        foreach ($lists as $list){
            $list->material = Material::find($list->material_id);
        }
        return view('stock.buy_check',[
            'purchase'=>$purchase,
            'lists'=>$lists
        ]);
    }
    public function addBuyPage()
    {
        $id = Input::get('id');
        $purchase = Purchase::find($id);
        return view('stock.buy_add',['purchase'=>$purchase]);
    }
    public function budgetaryCheckPage()
    {
        $id = Input::get('id');
        $purchase = Purchase::find($id);
        $purchase->lists = $purchase->lists()->get();
        return view('buy.budgetary_check',['purchase'=>$purchase]);
    }
//    public function check
}
