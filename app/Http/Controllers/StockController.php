<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use App\Models\Purchase;
use App\Models\PurchaseList;
use App\Models\Stock;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class StockController extends Controller
{
    //
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
        return view('stock.buy_check',[
            'purchase'=>$purchase,
            'lists'=>$lists
        ]);
    }
    public function addBuyPage()
    {

        return view('stock.buy_add');
    }
//    public function check
}
