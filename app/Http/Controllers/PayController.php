<?php

namespace App\Http\Controllers;

use App\Models\FinishPayApply;
use App\Models\LoanList;
use App\Models\PayApply;
use App\Models\RequestPayment;
use App\Models\RequestPaymentList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class PayController extends Controller
{
    //
    public function createPayApplyPage()
    {
        return view('00');
    }
    public function createPayApply(Request $post)
    {
        $count = PayApply::whereDate('created_at', date('Y-m-d',time()))->count();
        $apply = new PayApply();
        $apply->apply_date = $post->get('apply_date');
        $apply->number = 'FK'.date('Ymd',time()).sprintf("%03d", $count+1);
        $apply->price = $post->get('price');
        $apply->use = $post->get('use');
        $apply->project_number = $post->get('project_number');
        $apply->project_content = $post->get('project_content');
        $apply->proposer = $post->get('proposer');
        if ($apply->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function finishPayApply(Request $post)
    {
        $apply = PayApply::find($post->get('id'));
        $apply->pay_date = $post->get('pay_date');
        $apply->cash = $post->get('cash');
        $apply->transfer = $post->get('transfer');
        $apply->other = $post->get('other');
        $apply->bank = $post->get('bank');
        $apply->account = $post->get('account');
        $apply->manager = $post->get('manager');
        if($apply->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function listPayApply()
    {
        $number = Input::get('number');
        $project_number = Input::get('project_number');
        $project_content = Input::get('project_content');
        $proposer = Input::get('proposer');
        $approver = Input::get('approver');
        $DbObj = DB::table('pay_applies');
        if ($number){
            $DbObj->where('number','like','%'.$number.'%');
        }
        if ($project_number){
            $DbObj->where('project_number','like','%'.$project_number.'%');
        }
        if ($project_content){
            $DbObj->where('project_content','like','%'.$project_content.'%');
        }
        if ($proposer){
            $DbObj->where('proposer','like','%'.$proposer.'%');
        }
        if ($approver){
            $DbObj->where('approver','like','%'.$approver.'%');
        }
        if ($number){
            $DbObj->where('number','like','%'.$number.'%');
        }
        $data = $DbObj->paginate(10);
        return view('',['lists'=>$data]);
    }
    public function createLoanApply(Request $post)
    {
        $apply = new LoanList();
        $apply->borrower = $post->get('borrower');
        $apply->apply_date = $post->get('apply_date');
        $apply->price = $post->get('price');
        $apply->reason = $post->get('reason');
        if ($apply->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function finishLoan(Request $post)
    {
        $loan = LoanList::find($post->get('id'));
        $loan->pay_date = $post->get('pay_date');
        $loan->pay_type = $post->get('pay_type');
        $loan->manager = $post->get('manager');
        $loan->bank = $post->get('bank');
        $loan->account = $post->get('account');
        if ($loan->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function changeLoanApplyState()
    {
        $loan = LoanList::find(Input::get('id'));
        $loan->state = Input::get('state');
        if ($loan->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function addRequestPayment(Request $post)
    {
        $lists = $post->get('lists');
        $payment = new RequestPayment();
        $payment->team = $post->get('team');
        $payment->manager = $post->get('manager');
        $payment->project_number = $post->get('project_number');
        $payment->project_content = $post->get('project_content');
        $payment->project_manager = $post->get('project_manager');
        $payment->request_date = $post->get('request_date');
        $payment->price = $post->get('price');
        $payment->save();
        if (!empty($lists)){
            foreach ($lists as $item){
                $list = new RequestPaymentList();
                $list->payment_id = $payment->id;
                $list->name = $item['name'];
                $list->param = $item['param'];
                $list->number = $item['number'];
                $list->unit = $item['unit'];
                $list->price = $item['price'];
                $list->total = $item['total'];
                $list->remark = $item['remark'];
                $list->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function createFinishPayApply(Request $post)
    {
        $apply = new FinishPayApply();
        $apply->project_id = $post->get('project_id');
        $apply->pay_date = $post->get('pay_date');
        $apply->price = $post->get('price');
        $apply->payee = $post->get('payee');
        $apply->bank = $post->get('bank');
        $apply->bank_account = $post->get('bank_account');
        if ($apply->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
}
