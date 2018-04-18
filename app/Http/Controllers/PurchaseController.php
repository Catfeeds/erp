<?php

namespace App\Http\Controllers;

use App\Models\PruchaseCheck;
use App\Models\PruchasePass;
use App\Models\Purchase;
use App\Models\PurchaseInvoice;
use App\Models\PurchasePayment;
use App\Models\PurchasePaymentCheck;
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
        if ($purchase->state!=1){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态下不可复核！'
            ]);
        }else{
            $purchase->state = 2;
            $purchase->check = Auth::id();
            $purchase->save();
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
        if ($purchase->state!=2){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态下不可审核！'
            ]);
        }else{
            $purchase->state = 3;
            $purchase->pass = Auth::id();
            $purchase->save();
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
        if (!empty($users)){
            foreach ($users as $user){
                $check = new PruchaseCheck();
                $check->purchase_id = $id;
                $check->user_id = $user;
                $check->save();
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
        if (!empty($users)){
            foreach ($users as $user){
                $pass = new PruchasePass();
                $pass->purchase_id = $id;
                $pass->user_id = $user;
                $pass->save();
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
        return view('buy.payment_list',['purchase'=>$purchase]);
    }
    public function createBuyPayment()
    {
        $id = Input::get('id');
        $purchase = Purchase::find($id);
        return view('buy.payment_create',['purchase'=>$purchase]);
    }
    public function createPayment()
    {
        $id = Input::get('purchase_id');
        $payment = new PurchasePayment();
        $payment->purchase_id = $id;
        $payment->date = Input::get('date');
        $payment->price = Input::get('price');
        if ($payment){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function selectPaymentCheck()
    {
        $id = Input::get('id');
        $users = Input::get('users');
        if (!empty($users)){
            foreach ($users as $user){
                $check = new PurchasePaymentCheck();
                $check->payment_id = $id;
                $check->user_id = $user;
                $check->save();
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
    public function finishPayment(Request $post)
    {
        $id = $post->get('id');
        $payment = PurchasePayment::find($id);
        $payment->pay_price = $post->get('pay_price');
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
                $invoice->with_tax = $list['with_tax'];
                $invoice->worker = Auth::id();
                $invoice->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
}
