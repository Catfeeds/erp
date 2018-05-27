<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Material;
use App\Models\PruchaseCheck;
use App\Models\PruchasePass;
use App\Models\Purchase;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseList;
use App\Models\PurchasePayment;
use App\Models\PurchasePaymentCheck;
use App\Models\Stock;
use App\Models\StockRecord;
use App\Models\StockRecordList;
use App\Models\Task;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;

class PurchaseController extends Controller
{
    //
    public function checkPurchase()
    {
        $id = Input::get('id');
        $purchase = Purchase::find($id);
        if ($purchase->type==1){
            $check = 'buy_bugetary_check';
        }else{
            $check = 'buy_extrabugetary_check';
        }
        if ($purchase->state!=1){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态下不可复核！'
            ]);
        }else{
            $purchase->state = 2;
            $purchase->check = Auth::id();
            $purchase->save();
            Task::where('type','=',$check)->where('content','=',$id)->update(['state'=>0]);
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS',
                'data'=>[
                    'id'=>$purchase->id,
                    'type'=>$purchase->type
                ]
            ]);
        }
    }
    public function passPurchase()
    {
        $id = Input::get('id');
        $purchase = Purchase::find($id);
        if ($purchase->type==1){
            $pass = 'buy_bugetary_pass';
        }else{
            $pass = 'buy_extrabugetary_pass';
        }
        if ($purchase->state!=2){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态下不可审核！'
            ]);
        }else{
            $purchase->state = 3;
            $purchase->pass = Auth::id();
            $purchase->save();
            Task::where('type','=',$pass)->where('content','=',$id)->update(['state'=>0]);
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function selectCheck()
    {
        $id = Input::get('id');
        $users = Input::get('users');
        $purchase = Purchase::find($id);
        if ($purchase->type==1){
            $check = 'buy_bugetary_check';
        }else{
            $check = 'buy_extrabugetary_check';
        }
        if (!empty($users)){
            foreach ($users as $user){
                $task = new Task();
                $task->user_id = $user;
                $task->type = $check;
                $task->content = $id;
                $task->title = '采购立项复核';
                $task->number = $purchase->number;
                $task->url = 'stock/check/budgetary?id='.$id;
                $task->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function selectPass()
    {
        $id = Input::get('id');
        $users = Input::get('users');
        $purchase = Purchase::find($id);
        if ($purchase->type==1){
            $pass = 'buy_bugetary_pass';
        }else{
            $pass = 'buy_extrabugetary_pass';
        }
        if (!empty($users)){
            foreach ($users as $user){
                $task = new Task();
                $task->user_id = $user;
                $task->type = $pass;
                $task->content = $id;
                $task->title = '采购立项审批';
                $task->number = $purchase->number;
                $task->url = 'stock/check/budgetary?id='.$id;
                $task->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function listBuyPayment()
    {
        $id = Input::get('id');
        $purchase = Purchase::find($id);
        $lists = $purchase->payments()->get();
//        $price =
//        dd($lists);
        return view('buy.payment_list',['purchase'=>$purchase,'lists'=>$lists]);
    }
    public function editPaymentPage()
    {
        $id = Input::get('id');
        $payment = PurchasePayment::find($id);
        $purchase = Purchase::find($payment->purchase_id);
        return view('buy.payment_edit',['payment'=>$payment,'purchase'=>$purchase]);
    }
    public function createBuyPayment()
    {
        $purchase_id = Input::get('purchase_id');
        $purchase = Purchase::find($purchase_id);
        $id = Input::get('id',0);
        return view('buy.payment_create',['purchase'=>$purchase,
        'id'=>$id]);
    }
    public function createPayment()
    {
        $payment_id = Input::get('id');
        if ($payment_id){
            $payment = PurchasePayment::find($payment_id);
            $payment->date = Input::get('date');
            $payment->price = Input::get('price');
            $purchase = Purchase::find($payment->purchase_id);
            $count = $purchase->lists()->sum('price')-($purchase->payments()->where('id','!=',$payment_id)->sum('price')+$payment->price);
//            dd($count);
            if ($count<0){
                return response()->json([
                    'code'=>'400',
                    'msg'=>'付款申请金额不能超过采购金额！'
                ]);
            }
        }else{
            $id = Input::get('purchase_id');
            $payment = new PurchasePayment();
            $payment->purchase_id = $id;
            $payment->date = Input::get('date');
            $payment->price = Input::get('price');
            $payment->apply_id = Auth::id();
            $purchase = Purchase::find($payment->purchase_id);
            $count = $purchase->lists()->sum('price')-($purchase->payments()->sum('price')+$payment->price);
            if ($count<0){
                return response()->json([
                    'code'=>'400',
                    'msg'=>'付款申请金额不能超过采购金额！'
                ]);
            }
        }

        if ($payment->save()){
            Task::where('type','=','buy_pay_pass')->where('content','=',$payment->id)->delete();
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS',
                'data'=>[
                    'id'=>$payment->id
                ]
            ]);
        }
    }
    public function selectPaymentCheck()
    {
        $id = Input::get('id');
        $users = Input::get('users');
        $payment = PurchasePayment::find($id);
        $purchase = Purchase::find($payment->purchase_id);
        if (!empty($users)){
            foreach ($users as $user){
                $task = new Task();
                $task->user_id = $user;
                $task->content = $id;
                $task->type = 'buy_pay_pass';
                $task->title = '采购付款复核';
                $task->url = 'buy/payment/list?id='.$purchase->id;
                $task->number = $purchase->number;
                $task->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function checkPayment()
    {
        $id = Input::get('id');
        $payment = PurchasePayment::find($id);
        if ($payment->state!=1){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态下不可复核！'
            ]);
        }else{
            $payment->state = 2;
            $payment->check = Auth::id();
            $payment->save();
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function finishPaymentPage()
    {
        $id = Input::get('id');
        $payment = PurchasePayment::find($id);
        return view('buy.payment_finish',['payment'=>$payment]);
    }
    public function finishPayment(Request $post)
    {
        $id = $post->get('id');
        $payment = PurchasePayment::find($id);
        if ($payment->state!=2){
            return response()->json([
                'code'=>'400',
                'msg'=>'未经复核！'
            ]);
        }
        $payment->pay_price = $payment->price;
        $payment->pay_date = $post->get('pay_date');
        $payment->bank_id = $post->get('bank_id');
        $payment->worker = Auth::user()->name;
        $payment->worker_id = Auth::id();
        $payment->remark = $post->get('remark');
        if ($payment->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function createInvoices(Request $post)
    {
        $id = $post->get('purchase_id');
        $date = $post->get('date');
        $lists = Input::get('lists');
        if (!empty($lists)){
            foreach ($lists as $list){
                $invoice = new PurchaseInvoice();
                $invoice->purchase_id = $id;
                $invoice->date = $date;
                $invoice->invoice_date = $list['date'];
                $invoice->number = $list['number'];
                $invoice->type = $list['type'];
                $invoice->without_tax = $list['without_tax'];
                $invoice->tax = $list['tax'];
                $invoice->with_tax = $list['tax']+$list['without_tax'];
                $invoice->worker = Auth::id();
                $invoice->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function listInvoices()
    {
        $id = Input::get('id');
        $purchase = Purchase::find($id);
        $purchase->invoices = $purchase->invoices()->get();
        return view('buy.invoice_list',['purchase'=>$purchase]);
    }
    public function createInvoicePage()
    {
        $id = Input::get('purchase_id');
        $purchase = Purchase::find($id);
        $invoice = Invoice::select(['id','name'])->get();
        return view('buy.invoice_create',['purchase'=>$purchase,'invoice'=>$invoice]);
    }
    public function searchPurchase()
    {
        $id = Input::get('material_id');
        $start = Input::get('start');
        $end = Input::get('end');
        $lists = PurchaseList::where('material_id','=',$id)->whereDate('created_at','>',$start)
            ->whereDate('created_at','<',$end)->get();
        foreach ($lists as $list){
            $list->purchase = Purchase::find($list->purchase_id);
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$lists
        ]);
    }
    public function searchPurchaseWarehouse()
    {
        $name = Input::get('name');
        $id = Input::get('purchase_id');
        $idArr = StockRecord::where('purchase_id','=',$id)->where('type','=',1)->pluck('warehouse_id')->toArray();
        $db = Warehouse::whereIn('id',$idArr);
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
    public function searchPurchaseMaterial()
    {
        $name = Input::get('name');
        $purchase_id = Input::get('purchase_id');
        $warehouse_id = Input::get('warehouse_id');
        $list = StockRecord::where('purchase_id','=',$purchase_id)->where('warehouse_id','=',$warehouse_id)->pluck('id')->toArray();
        $db = StockRecordList::whereIn('record_id',$list);
        if ($name){
            $idArr = Material::where('name','like','%'.$name.'%')->where('state','=',1)->pluck('id')->toArray();
            $db = $db->whereIn('material_id',$idArr);
        }
        $data = $db->get();
        foreach ($data as $datum){
            $datum->material = $datum->material()->first();
            $datum->number = Stock::where('warehouse_id','=',$warehouse_id)->where('material_id','=',$datum->material_id)->pluck('number')->first();
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$data
        ]);
    }
    public function printBuyBudgetary()
    {
        $id = Input::get('id');
        $purchase = Purchase::find($id);
        $lists = $purchase->lists()->get();
        foreach ($lists as $list){
            $list->material = Material::find($list->material_id);
        }
//        $purchase->lists = $lists;
        return view('buy.budgetary_print',['purchase'=>$purchase,'lists'=>$lists]);
    }
    public function printBuyPayment()
    {
        $id = Input::get('id');
        $purchase = Purchase::find($id);
        $lists = $purchase->payments()->get();
//        dd($lists);
        return view('buy.payment_print',['purchase'=>$purchase,'lists'=>$lists]);
    }
    public function printBuyInvoice()
    {
        $id = Input::get('id');
        $purchase = Purchase::find($id);
        $invoices = $purchase->invoices()->get();
        return view('buy.invoice_print',['purchase'=>$purchase,'invoices'=>$invoices]);
    }


}
