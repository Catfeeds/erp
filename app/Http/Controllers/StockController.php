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
use PhpParser\Node\Expr\Cast\Object_;

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
        $seartch_type = Input::get('seartch-type');
        $search = Input::get('value');
        if ($seartch_type){
            if ($seartch_type==1){
                $idArr = Material::where('name','like','%'.$search.'%')->pluck('id')->toArray();
                $stocks = Stock::whereIn('material_id',$idArr)->orderBy('cost','DESC')->paginate(10);
            }else{
                $idArr = Warehouse::where('name','like','%'.$search.'%')->pluck('id')->toArray();
                $stocks = Stock::whereIn('warehouse_id',$idArr)->orderBy('cost','DESC')->paginate(10);
            }
        }else{
            $stocks = Stock::orderBy('cost','DESC')->paginate(10);
        }

        return view('stock.list',['stocks'=>$stocks]);
    }
    public function listBuyList()
    {
        $role = getRole('stock_buy_list');
        $db = Purchase::where('state','=',3);
        if ($role=='any'){
            $idArr = getRoleProject('stock_buy_list');
            $lists = $db->whereIn('project_id',$idArr)->orderBy('id','DESC')->paginate(10);
        }else{
            $lists = $db->orderBy('id','DESC')->paginate(10);
        }
        if (!empty($lists)){
            foreach ($lists as $list){
                $received = 0;
                $need = 0;
                $swap = $list->lists()->get();
                for ($i=0;$i<count($swap);$i++){
                    $received += $swap[$i]->price * $swap[$i]->received;
                    $need += $swap[$i]->price * $swap[$i]->need;
                }
                $list->received = $received;
                $list->need = $need;
            }
        }
        return view('stock.buy_list',['lists'=>$lists]);
    }
    public function listReturnList()
    {
        $role = getRole('stock_return_list');
        if ($role=='all'){
            $id_arr = StockRecord::where('type','=',2)->pluck('id')->toArray();
            $lists = StockRecordList::whereIn('record_id',$id_arr)->orderBy('id','DESC')->paginate(10);
        }else{
            $idArr = getRoleProject('stock_return_list');
            $id_arr = StockRecord::where('type','=',2)->pluck('id')->toArray();
            $lists = StockRecordList::whereIn('record_id',$id_arr)->whereIn('project_id',$idArr)->orderBy('id','DESC')->paginate(10);
        }

        if (empty($lists)){
            foreach ($lists as $list){
                $list->material = $list->material()->first();
                $list->record = $list->record()->first();
            }
        }
//        dd($lists);
        return view('stock.return_list',['lists'=>$lists]);
    }
    public function listGetList()
    {
        $role = getRole('stock_get_list');
        if ($role =='all'){
            $id_arr = StockRecord::where('type','=',3)->pluck('id')->toArray();
            $lists = StockRecordList::whereIn('record_id',$id_arr)->orderBy('id','DESC')->paginate(10);
        }else{
            $idArr = getRoleProject('stock_get_list');
            $id_arr = StockRecord::where('type','=',3)->whereIn('project_id',$idArr)->pluck('id')->toArray();
            $lists = StockRecordList::whereIn('record_id',$id_arr)->orderBy('id','DESC')->paginate(10);
        }
        if (!empty($lists)){
            foreach ($lists as $list){
                $list->material = $list->material()->first();
                $list->record = $list->record()->first();
            }
        }
        return view('stock.get_list',['lists'=>$lists]);
    }
    public function listOutList()
    {
        $role = getRole('stock_out_list');
        if ($role =='all'){
            $id_arr = StockRecord::where('type','=',4)->pluck('id')->toArray();
            $lists = StockRecordList::whereIn('record_id',$id_arr)->orderBy('id','DESC')->paginate(10);
        }else{
            $idArr = getRoleProject('stock_get_list');
            $id_arr = StockRecord::where('type','=',4)->whereIn('project_id',$idArr)->pluck('id')->toArray();
            $lists = StockRecordList::whereIn('record_id',$id_arr)->orderBy('id','DESC')->paginate(10);
        }
        if (!empty($lists)){
            foreach ($lists as $list){
                $list->material = $list->material()->first();
                $list->record = $list->record()->first();
            }
        }


        return view('stock.out_list',['lists'=>$lists]);
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
                if($purchase->need<$list['number']){
                    throw new \Exception('收货数量不能超过剩余收货数量！');
                }
                $record->purchase_number = Purchase::find($purchase->purchase_id)->number;
                $record->purchase_id = $purchase->purchase_id;
                $info = Purchase::find($purchase->purchase_id);
                $record->supplier_id = $info->supplier_id;
                $record->supplier = Supplier::find($info->supplier_id)->name;
                $project = Project::find($info->project_id);
                $record->project_number = empty($project)?'':$project->number;
                $record->project_content = empty($project)?'':$project->name;
                $record->project_manager = empty($project)?'':$project->pm;
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
//            dd($exception);
            return response()->json([
                'code'=>'400',
                'msg'=>$exception->getMessage()
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
                'msg'=>'退料数量不能为0！'
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
            $record->date = date('Y-m-d');
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
    public function addGet(Request $post)
    {
        $lists = $post->get('lists');
        if (empty($lists)){
            return response()->json([
                'code'=>'400',
                'msg'=>'出库数据不能为空！'
            ]);
        }
        $warehouse_id = $post->warehouse_id;
        $project_id = $post->project_id;
        $number = array_column($lists,'number');
        if (in_array(0,$number)){
            return response()->json([
                'code'=>'400',
                'msg'=>'出库数量不能为0！'
            ]);
        }
        DB::beginTransaction();
        try{
            $record = new StockRecord();
            $count = StockRecord::whereDate('created_at', date('Y-m-d', time()))->where('type', '=',3)->count();
            $record->number = 'LL' . date('Ymd', time()) . sprintf("%03d", $count + 1);
            $record->warehouse_id = $warehouse_id;
            if ($project_id){
                $project = Project::find($post->project_id);
                $record->project_number = $project->number;
                $record->project_manager = $project->pm;
                $record->project_content = $project->name;
                $record->project_id = $project->id;
            }
            $record->warehouse = Warehouse::find($warehouse_id)->name;
            $record->worker = $post->worker;
            $record->worker_id = Auth::id();
            $record->date = date('Y-m-d');
            $record->type = 3;
            $record->save();
            $recordPrice = 0;
            foreach ($lists as $list){
                $swap = Stock::find($list['id']);
//                dd($swap);
//                $materail_id = $swap->material_id;

                $price = $swap->cost/$swap->number;
                if ($list['number']>$swap->number){
                    throw new \Exception('数量不足！');
                }
                $swap->number -= $list['number'];
                $swap->cost -= $price*$list['number'];
                $swap->save();
                $Rlist = new StockRecordList();
                $Rlist->record_id = $record->id;
                $Rlist->material_id = $swap->material_id;
                $Rlist->sum = $list['number'];
                $Rlist->price = $price;
                $Rlist->cost = $Rlist->sum*$Rlist->price;
                $Rlist->stock_cost = $swap->cost;
                $Rlist->stock_number = $swap->number;
                $count = $swap->number;
                $count = $count==0?1:$count;
                $Rlist->stock_price = $swap->cost/$count;
//                $price += $list->cost;
                $Rlist->save();
                $recordPrice += $Rlist->cost;
            }
            $record->cost = $recordPrice;
            $record->save();
            DB::commit();
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }catch (\Exception $exception){
            DB::rollback();
            return response()->json([
                'code'=>'400',
                'msg'=>$exception->getMessage()
            ]);
        }
    }
    public function addOut(Request $post)
    {
        $lists = $post->get('lists');
        if (empty($lists)){
            return response()->json([
                'code'=>'400',
                'msg'=>'退货数据不能为空！'
            ]);
        }
        $warehouse_id = $post->warehouse_id;
//        $project_id = $post->project_id;
        $number = array_column($lists,'number');
        if (in_array(0,$number)){
            return response()->json([
                'code'=>'400',
                'msg'=>'退货数量不能为0！'
            ]);
        }
        DB::beginTransaction();
        try{
            $record = new StockRecord();
            $count = StockRecord::whereDate('created_at', date('Y-m-d', time()))->where('type', '=',4)->count();
            $record->number = 'THCK' . date('Ymd', time()) . sprintf("%03d", $count + 1);
            $record->purchase_id = $post->purchase_id;
            $purchase = Purchase::find($post->purchase_id);
            $project = Project::find($purchase->project_id);
            $record->project_number = $project->number;
            $record->project_manager = $project->pm;
            $record->project_content = $project->name;
            $record->project_id = $project->id;
            $record->supplier = $purchase->supplier;
            $record->supplier_id = $purchase->supplier_id;
            $record->reason = $post->reason;
            $record->date = $post->date;
            $record->warehouse = Warehouse::find($post->warehouse_id)->name;
            $record->warehouse_id = $post->warehouse_id;
            $record->worker = Auth::user()->username;
            $record->worker_id = Auth::id();
            $record->purchase_number =$purchase->number;
            $record->purchase_id =$purchase->id;
            $record->type = 4;
            $record->save();
            $recordPrice = 0;
            foreach ($lists as $list){
//                $swap = StockRecordList::find($list['id']);
//                dd($swap);
//                if ($swap->sum<$list['number']){
//                    throw new \Exception('超出收货数量！');
//                }
                $stock = Stock::find($list['id']);
                if ($list['number']>$stock->number){
                    throw new \Exception('数量不足！');
                }
                $price = $stock->cost/$stock->number;
                $stock->number -= $list['number'];
                $stock->cost -= $price*$list['number'];
                $stock->save();
                $Rlist = new StockRecordList();
                $Rlist->record_id = $record->id;
                $Rlist->material_id = $stock->material_id;
                $Rlist->sum = $list['number'];
                $Rlist->price = $price;
                $Rlist->cost = $Rlist->sum*$Rlist->price;
                $Rlist->stock_cost = $stock->cost;
                $Rlist->stock_number = $stock->number;
                $count = $stock->number;
                $count = $count==0?1:$count;
                $Rlist->stock_price = $stock->cost/$count;
//                $price += $list->cost;
                $Rlist->save();
                $recordPrice += $Rlist->cost;
            }
            $record->cost = $recordPrice;
            $record->save();
            DB::commit();
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }catch (\Exception $exception){
            DB::rollback();
            return response()->json([
                'code'=>'400',
                'msg'=>$exception->getMessage()
            ]);
        }
    }
    public function buyBudgetary(Request $post)
    {
        $buy_id = $post->get('buy_id');
        $id = $post->get('id');
        if ($buy_id){
            $purchase = Purchase::find($buy_id);
            $contracts = $purchase->contracts()->get();
            $lists = $purchase->lists()->get();
            if (!empty($lists)){
                foreach ($lists as $list){
                    $materail = Material::find($list->material_id);
                    $list->material = $materail;
                    $list->material_id = $list->budget_id;
                    $list->material->number = $list->number;
//                    $list->material->material = $materail;
                    $list->material->price = $list->price;
                    $list->material->buy_number = $list->received;
                    $list->material->need_buy = $list->need;
                    $list->own_id = $list->id;
                    $list->need_number = $list->need;
                    $list->buy_number = $list->received;
                    $list->material->edit = true;
                    $list->edit = true;
                }
            }
//            dd($lists);
            $purchase->supplier_name = $purchase->supplier;
//            $purchase->content = $purchase->content_id;
            $project = $purchase->project_id==0?null:Project::find($purchase->project_id);
//            $content =
            $data = [];
            $data['info'] = $purchase;
            $data['contracts'] = $contracts;
            $data['lists'] = $lists;
            $data['project_id'] = empty($project)?0:$project->id;
            $data['amount'] = $purchase->lists()->sum('cost');
//            $data['project_number'] = empty($project)?'':$project->number;
//            $data['project_content'] = empty($project)?'':$project->name;
//            return response()->json($data);
            $invoice = Invoice::where('state','=',1)->get();
            $budgets = $project->budget()->where('type','=',1)->get();
            foreach ($budgets as $budget){
                $materail = Material::find($budget->material_id);
                $budget->name = $materail->name;
                $budget->model = $materail->model;
                $budget->material = $materail;
                $budget->material->edit = true;
                $budget->index = $budget->id;
                $budget->need_number = $budget->need_buy;
            }
//            dd($budgets);
            return view('buy.budgetary_buy',[
                'project'=>$project,
                'invoices'=>$invoice,
                'budgets'=>$budgets,
                'editData'=>$data
            ]);
        }else{
            $project = Project::find($id);
            $invoice = Invoice::where('state','=',1)->get();
            $budgets = $project->budget()->where('type','=',1)->get();
            foreach ($budgets as $budget){
                $materail = Material::find($budget->material_id);
                $budget->name = $materail->name;
                $budget->model = $materail->model;
                $budget->material = $materail;
                $budget->material->edit = true;
                $budget->index = $budget->id;
                $budget->need_number = $budget->need_buy;
            }
//        dd($budgets);
            return view('buy.budgetary_buy',[
                'project'=>$project,
                'invoices'=>$invoice,
                'budgets'=>$budgets
            ]);
        }

//        dd($id);

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
        if (!empty($lists)){
            foreach ($lists as $list){
                $list->material = Material::find($list->material_id);
            }
        }

        $purchase->lists = $lists;
        if ($purchase->type==1){
            $checkRole = 'buy_bugetary_check';
            $passRole = 'buy_bugetary_pass';
        }else{
            $checkRole = 'buy_extrabugetary_check';
            $passRole = 'buy_extrabugetary_pass';
        }
        return view('buy.budgetary_check',['purchase'=>$purchase,'check'=>$checkRole,'pass'=>$passRole]);
    }
    public function addReturnPage()
    {
        return view('stock.return_add');
    }
    public function addGetPage()
    {
        return view('stock.get_add');
    }
    public function printGet()
    {
        $id = Input::get('id');
        $record = StockRecord::find($id);
        $lists = $record->lists()->get();
        foreach ($lists as $list){
            $list->material = $list->material()->first();
        }
        return view('stock.get_print',['record'=>$record,'lists'=>$lists]);
    }
    public function printReturn()
    {
        $id = Input::get('id');
        $record = StockRecord::find($id);
        $lists = $record->lists()->get();
        foreach ($lists as $list){
            $list->material = $list->material()->first();
        }
        return view('stock.return_print',['record'=>$record,'lists'=>$lists]);
    }
    public function addOutPage()
    {
        $db = Purchase::where('state','=',3);
        $search = Input::get('search');
        if ($search){
            $idArray = Project::where('number','like','%'.$search.'%')->orWhere('name','like','%'.$search.'%')->pluck('id')->toArray();
//            dd($idArray);
            if (!empty($idArray)){
                $db->whereIn('project_id',$idArray)->orWhere('number','like','%'.$search.'%')->orWhere('supplier','like','%'.$search.'%');;
            }else{
                $db->where('number','like','%'.$search.'%')->orWhere('supplier','like','%'.$search.'%');
            }
        }
        $lists = $db->orderBy('id','DESC')->paginate(10);
        foreach ($lists as $list){
            $list->lists = $list->lists()->get();
            $receivedPrice = 0;
            $needPrice = 0;
            foreach ($list->lists as $item){
                $needPrice+=$item->price*$item->need;
                $receivedPrice+=$item->price*$item->received;
            }
            $list->needPrice = $needPrice;
            $list->receivedPrice = $receivedPrice;
        }
        return view('stock.out_add',['lists'=>$lists]);
    }
    public function getPurchaseData()
    {
        $id = \Illuminate\Support\Facades\Input::get('id');
        $purchase = Purchase::find($id);
        $purchase->project = Project::find($purchase->project_id);
        $purchase->price = $purchase->lists()->sum('cost');
        $lists = PurchaseList::where('purchase_id','=',$id)->orderBy('material_id','ASC')->get();
        foreach ($lists as $list){
            $list->material = Material::find($list->material_id);
        }
//        dd($lists);
        $list2 = StockRecord::where('purchase_id','=',$id)->where('type','=',1)->get();
        $c=[];
        foreach ($list2 as $item){
            $item->get_cost = $item->lists()->sum('cost');
            $item->need_cost = $item->lists()->sum('need_cost');
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
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>[
                'purchase'=>$purchase,
                'purchaseList'=>$lists,
                'record'=>$list2
            ]
        ]);
    }
    public function checkStock()
    {
        $id = Input::get('id');
        $stock = Stock::find($id);
        $stock->material = $stock->material();
        $stock->warehouse = $stock->warehouse();
        $start = '';
        $end = '';
        $s = Input::get('s');
        $e = Input::get('e');

        if($s){
            $start = $s;
            $end = $e;
//            $start =
            $startData = StockRecord::where('date','<',$start)->where('warehouse_id','=',$stock->warehouse_id)->orderBy('id','DESC')->first();
            if (!empty($startData)){
//                dd($startData);
                $startData = StockRecordList::where('record_id','=',$startData->id)->where('material_id','=',$stock->material_id)->orderBy('id','DESC')->first();
                $startData = empty($startData)?new StockRecordList():$startData->toArray();
//                dd($startData);
                //                ->toArray();
            }else{
                $startData = new StockRecordList();
            }

//            dd($startData);
            $idArr = StockRecord::whereBetween('date',[$s,$e])
                ->where('warehouse_id','=',$stock->warehouse_id)->pluck('id')->toArray();
            $lists = StockRecordList::whereIn('record_id',$idArr)->where('material_id','=',$stock->material_id)->get();
            if (!empty($lists)){
                foreach ($lists as $list){
                    $list->record = $list->record()->first();
                }
            }
        }else{
            $idArr = StockRecord::where('warehouse_id','=',$stock->warehouse_id)->pluck('id')->toArray();
//            dd($idArr);
            $lists = StockRecordList::whereIn('record_id',$idArr)->where('material_id','=',$stock->material_id)->get();
//            dd($lists);
            $startData = [];
            $startData['stock_number'] = 0;
            $startData['stock_price'] = 0;
            $startData['stock_cost'] = 0;
            if (!empty($lists)){
                foreach ($lists as $list){
                    $list->record = $list->record()->first();
                }
            }
        }
//        foreach ($lists as $list){
//
//        }
////        dd($lists);
        return view('stock.check',['stock'=>$stock,'lists'=>$lists,'start'=>$start,'end'=>$end,'startData'=>$startData,'id'=>$id]);
    }
    public function addOutAddPage()
    {
        $id = Input::get('id');
        $purchase = Purchase::find($id);
        return view('stock.out_add_add',['purchase'=>$purchase]);
    }
    public function singleOutPage()
    {
        $id = Input::get('id');
        $record = StockRecord::find($id);
        $list = $record->lists()->get();
        $purchase = Purchase::find($record->purchase_id);
//        dd($list);
        $purchase_need = 0;
        $purchase_need_cost=0;

        if (!empty($list)){
            foreach ($list as $item){
                $item->material = $item->material()->first();
                $item->purchase_price = PurchaseList::where('material_id','=',$item->material_id)->where('purchase_id','=',$record->purchase_id)->pluck('price')->first();
                $item->purchase_sum = PurchaseList::where('material_id','=',$item->material_id)->where('purchase_id','=',$record->purchase_id)->sum('number');
                $item->purchase_cost = PurchaseList::where('material_id','=',$item->material_id)->where('purchase_id','=',$record->purchase_id)->sum('cost');
                $item->purchase_need = PurchaseList::where('material_id','=',$item->material_id)->where('purchase_id','=',$record->purchase_id)->sum('received');
                $item->purchase_need_cost = $item->purchase_price*$item->purchase_need;
                $purchase_need+=$item->purchase_need;
                $purchase_need_cost+=$item->purchase_need_cost;
            }
        }
//        dd($list);
        return view('stock.out_single',['record'=>$record,'list'=>$list,'purchase'=>$purchase,'purchase_need'=>$purchase_need,'purchase_need_cost'=>$purchase_need_cost]);
    }
    public function printBuy()
    {
        $id = Input::get('id');
        $record = StockRecord::find($id);
        $purchase = Purchase::find($record->purchase_id);
        $lists = $record->lists()->get();
        $buy_num = 0;
        $buy_cost = 0;
        $get_num = 0;
        $get_count = 0;
        $need_num = 0;
        $need_count = 0;
        if (!empty($lists)){
            foreach ($lists as $list){
                $records = StockRecord::where('type','=',1)->where('purchase_id','=',$purchase->id)->pluck('id')->toArray();
                $list->old_sum = StockRecordList::whereIn('record_id',$records)->where('material_id','=',$list->material_id)->sum('sum')-$list->sum;
                $list->old_cost = StockRecordList::whereIn('record_id',$records)->where('material_id','=',$list->material_id)->sum('cost')-$list->cost;
                $buy_num+=$list->old_sum;
                $buy_cost+=$list->old_cost;
                $get_num += $list->sum;
                $get_count += $list->cost;
                $need_num +=$list->need_sum;
                $need_count +=$list->need_cost;
            }
        }


        return view('stock.buy_print',['record'=>$record,'lists'=>$lists,'purchase'=>$purchase,'buy_num'=>$buy_num,'buy_cost'=>$buy_cost,'get_num'=>$get_num
        ,'get_count'=>$get_count,'need_num'=>$need_num,'need_count'=>$need_count]);
    }
    public function searchStockGet()
    {
        $id = Input::get('material_id');
        $idArr = StockRecord::where('type','=',3)->pluck('id')->toArray();
        $list = StockRecordList::where('material_id','=',$id)->whereIn('record_id',$idArr)->orderBy('id','DESC')->get();
//        $list = StockRecord::whereIn('id',$idArr)->where('type','=',3)->get();
        if (!empty($list)){
            for ($i=0;$i<count($list);$i++){
                $swap = StockRecord::find($list[$i]->record_id);
                $list[$i]->number_id = (string)$swap->number;
                $list[$i]->warehouse = $swap->warehouse;
                $list[$i]->number = $list[$i]->sum;
                $list[$i]->material = Material::find($id);
                $list[$i]->worker = $swap->worker;
                $list[$i]->project_number = $swap->project_number;
                $list[$i]->project_content = $swap->project_content;
                $list[$i]->project_manager = $swap->project_manager;
//                dd($list[$i]);
            }
        }
//        dd($list);
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>&$list
        ]);
    }
}
