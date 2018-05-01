<?php

namespace App\Http\Controllers;

use App\Models\BuyStock;
use App\Models\BuyStockList;
use App\Models\Invoice;
use App\Models\Material;
use App\Models\Project;
use App\Models\Purchase;
use App\Models\PurchaseList;
use App\Models\Stock;
use App\Models\StockRecord;
use App\Models\StockRecordList;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function addBuy(Request $post)
    {
        $date = $post->get('date');
        $warehouse_id = $post->get('warehouse_id');
        $lists = $post->get('lists');
        $number = array_column($lists,'number');
        if (in_array(0,$number)){
            return response()->json([
                'code'=>'400',
                'msg'=>'收货数量不能为0！'
            ]);
        }
//        dd($number);
        $worker = $post->get('worker');
        $record = new StockRecord();
        $record->type = 1;
        $count = StockRecord::whereDate('created_at', date('Y-m-d',time()))->where('type','=',1)->count();
        $record->number = 'SHRK'.date('Ymd',time()).sprintf("%03d", $count+1);
        $record->date = $post->get('date');
        $record->worker = $worker;
        $record->worker_id = Auth::id();
        $record->warehouse_id = $warehouse_id;
        $record->warehouse = Warehouse::find($warehouse_id)->name;
        $record->save();
        $price = 0;
        foreach ($lists as $list){
//            dd($list);
            $purchase = PurchaseList::find($list['id']);
            $record->purchase_number = Purchase::find($purchase->purchase_id)->number;
            $record->purchase_id = $purchase->purchase_id;
            $info = Purchase::find($purchase->purchase_id);
            $record->supplier_id = $info->supplier_id;
            $record->supplier = Supplier::find($info->supplier_id)->name;
            $Rlist = new StockRecordList();
            $Rlist->record_id = $record->id;
            $Rlist->material_id = $purchase->material_id;
            $Rlist->sum =  $list['number'];
            $Rlist->cost = $purchase->price*$list['number'];
            $Rlist->price = $purchase->price;

            $price+=$Rlist->cost;
//            $table->float('stock_cost',18,2);
//            $table->float('stock_price',18,2);
//            $table->integer('stock_number');
//            $record->material_id = $purchase->material_id;
//            $record->price = $purchase->price;
            $record->cost = $purchase->price*$list['number'];
//            $record->sum = $list['number'];
            $purchase->received+=$list['number'];
            $purchase->need = $purchase->number-$purchase->received;
            $purchase->save();
            $stock = Stock::where('warehouse_id','=',$warehouse_id)
                ->where('material_id','=',$purchase->material_id)->first();
            if (empty($stock)){
                $stock = new Stock();
                $stock->warehouse_id = $warehouse_id;
                $stock->material_id = $purchase->material_id;
                $stock->number += $list['number'];
//                dd($list);
                $stock->cost = $list['number']*$purchase->price;
//                dd($stock);
            }else{
                $stock->warehouse_id = $warehouse_id;
                $stock->material_id = $purchase->material_id;
                $stock->number += $list['number'];
                $stock->cost += $list['number']*$purchase->price;
            }
//            dd($stock);
            $stock->save();
//            dd($stock);
            $Rlist->stock_number = $stock->number;
            $Rlist->stock_cost = $stock->cost;
            $Rlist->stock_price = $stock->cost/$stock->number;
            $Rlist->save();
            $record->save();

        }
        $record->cost = $price;
        $record->save();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);

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
        $lists = $purchase->lists()->get();
        foreach ($lists as $list){
            $list->material = Material::find($list->material_id);
        }
        return view('stock.buy_add',['purchase'=>$purchase,'lists'=>$lists]);
    }
    public function budgetaryCheckPage()
    {
        $id = Input::get('id');
        $purchase = Purchase::find($id);
        $lists = $purchase->lists()->get();
        foreach ($lists as $list){
            $list->material = Material::find($list->material_id);
        }
        $purchase->lists = $lists;
        return view('buy.budgetary_check',['purchase'=>$purchase]);
    }
    public function addReturnPage()
    {
        return view('stock.return_add');
    }
}
