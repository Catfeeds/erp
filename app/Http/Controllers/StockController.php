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
        $id_arr = StockRecord::where('type','=',2)->pluck('id')->toArray();
        $lists = StockRecordList::whereIn('record_id',$id_arr)->paginate(10);
        foreach ($lists as $list){
            $list->material = $list->material()->first();
            $list->record = $list->record()->first();
        }
//        dd($lists);
        return view('stock.return_list',['lists'=>$lists]);
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
        DB::beginTransaction();
        try {
            $worker = $post->get('worker');
            $record = new StockRecord();
            $record->type = 1;
            $count = StockRecord::whereDate('created_at', date('Y-m-d', time()))->where('type', '=', 1)->count();
            $record->number = 'SHRK' . date('Ymd', time()) . sprintf("%03d", $count + 1);
            $record->date = $post->get('date');
            $record->worker = $worker;
            $record->worker_id = Auth::id();
            $record->warehouse_id = $warehouse_id;
            $record->warehouse = Warehouse::find($warehouse_id)->name;
            $record->save();
            $price = 0;
            foreach ($lists as $list) {
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
                $Rlist->sum = $list['number'];
                $Rlist->cost = $purchase->price * $list['number'];
                $Rlist->price = $purchase->price;
                $price += $Rlist->cost;
                //            $table->float('stock_cost',18,2);
                //            $table->float('stock_price',18,2);
                //            $table->integer('stock_number');
                //            $record->material_id = $purchase->material_id;
                //            $record->price = $purchase->price;
                $record->cost = $purchase->price * $list['number'];
                //            $record->sum = $list['number'];
                $purchase->received += $list['number'];
                $purchase->need = $purchase->number - $purchase->received;
                $purchase->save();
                $stock = Stock::where('warehouse_id', '=', $warehouse_id)
                    ->where('material_id', '=', $purchase->material_id)->first();
                if (empty($stock)) {
                    $stock = new Stock();
                    $stock->warehouse_id = $warehouse_id;
                    $stock->material_id = $purchase->material_id;
                    $stock->number += $list['number'];
                    //                dd($list);
                    $stock->cost = $list['number'] * $purchase->price;
                    //                dd($stock);
                } else {
                    $stock->warehouse_id = $warehouse_id;
                    $stock->material_id = $purchase->material_id;
                    $stock->number += $list['number'];
                    $stock->cost += $list['number'] * $purchase->price;
                }
                //            dd($stock);
                $stock->save();
                //            dd($stock);
                $Rlist->stock_number = $stock->number;
                $Rlist->stock_cost = $stock->cost;
                $Rlist->stock_price = $stock->cost / $stock->number;
                $Rlist->need_sum = $purchase->need;
                $Rlist->need_cost = $purchase->price * $purchase->need;
                $Rlist->save();
                $record->save();

            }
            $record->cost = $price;
            $record->save();
            DB::commit();
            return response()->json([
                'code' => '200',
                'msg' => 'SUCCESS'
            ]);
        }catch (\Exception $exception){
            DB::rollback();
            dd($exception);
            return response()->json([
                'code'=>'400',
                'msg'=>'ERROR'
            ]);
        }

    }
    public function addReturn(Request $post)
    {
//        dd($post->all());
        $lists = $post->get('lists');
        $number = array_column($lists,'number');
        if (in_array(0,$number)){
            return response()->json([
                'code'=>'400',
                'msg'=>'收货数量不能为0！'
            ]);
        }
        DB::beginTransaction();
        try{
            $record = new StockRecord();
            $count = StockRecord::whereDate('created_at', date('Y-m-d', time()))->where('type', '=', 2)->count();
            $record->number = 'TL' . date('Ymd', time()) . sprintf("%03d", $count + 1);
            $record->warehouse_id = $post->warehouse_id;
            $record->warehouse = Warehouse::find($post->warehouse_id)->name;
            $project = Project::find($post->project_id);
            $record->project_id = $project->id;
            $record->project_number = $project->number;
            $record->project_content = $project->name;
            $record->project_manager = $project->pm;
            $record->worker = $post->worker;
            $record->worker_id = Auth::id();
            $record->returnee = $post->returnee;
            $record->type = 2;
            $record->save();
            $price = 0;
            foreach ($lists as $item){
                $stock = Stock::where('warehouse_id', '=', $post->warehouse_id)
                    ->where('material_id', '=', $item['id'])->first();
                if (empty($stock)) {
                    $stock = new Stock();
                    $stock->warehouse_id = $record->warehouse_id;
                    $stock->material_id = $item['id'];
                    $stock->number = $item['number'];
                    //                dd($list);
                    $stock->cost = $item['number'] * $item['price'];
                    //                dd($stock);
                } else {
                    $stock->warehouse_id = $record->warehouse_id;
                    $stock->material_id = $item['id'];
                    $stock->number += $item['number'];
                    $stock->cost += $item['number'] * $item['price'];
                }
                //            dd($stock);
                $stock->save();
                $list = new StockRecordList();
                $list->record_id = $record->id;
                $list->material_id = $item['id'];
                $list->sum = $item['number'];
                $list->price = $item['price'];
                $list->cost = $list->sum*$list->price;
                $list->stock_cost = $stock->cost;
                $list->stock_number = $stock->number;
                $list->stock_price = $stock->cost/$stock->number;
                $price += $list->cost;
                $list->save();
            }
            $record->cost = $price;
            $record->save();
            DB::commit();
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }catch (\Exception $exception) {
            DB::rollback();
            dd($exception);
            return response()->json([
                'code'=>'400',
                'msg'=>'ERROR'
            ]);
        }
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
        $lists = PurchaseList::where('purchase_id','=',$id)->orderBy('material_id','ASC')->get();
        foreach ($lists as $list){
            $list->material = Material::find($list->material_id);
        }
//        dd($lists);
        $list2 = StockRecord::where('purchase_id','=',$id)->where('type','=',1)->get();
        $c=[];
        foreach ($list2 as $item){
            $itemlist = $item->lists()->orderBy('material_id','ASC')->get()->toArray();
            $count =0;
//            dd($itemlist);
            for ($i=0;$i<count($lists);$i++){
                if (empty($itemlist[$i-$count])){
                    $count+=1;
                    $c[$i]=[];
                }else{
                    if($lists[$i]->material_id==$itemlist[$i-$count]['material_id']){
//                    dd($itemlist[$i-$count]);
                        $c[$i]=$itemlist[$i-$count];
                    }else{
                        $count+=1;
                        $c[$i]=[];
                    }
                }

            }
            $item->list = $c;
//            dd($c);
        }
//        dd($list2);
        return view('stock.buy_check',[
            'purchase'=>$purchase,
            'lists'=>$lists,
            'list2'=>$list2
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
    public function addGetPage()
    {
        return view('stock.get_add');
    }
}
