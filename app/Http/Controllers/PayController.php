<?php

namespace App\Http\Controllers;

use App\Models\FinishPayApply;
use App\Models\LoanList;
use App\Models\LoanPay;
use App\Models\LoanPayList;
use App\Models\LoanSubmit;
use App\Models\LoanSubmitList;
use App\Models\PayApply;
use App\Models\Project;
use App\Models\RequestPayment;
use App\Models\RequestPaymentList;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class PayController extends Controller
{
    //
    public function createPayApplyPage()
    {
        return view('pay.add');
    }
    public function createPayApply(Request $post)
    {
        $count = PayApply::whereDate('created_at', date('Y-m-d',time()))->count();
        $apply = new PayApply();
        $project = Project::find($post->get('project_id'));
        $apply->apply_date = $post->get('date');
        $apply->number = 'FK'.date('Ymd',time()).sprintf("%03d", $count+1);
        $apply->price = $post->get('price');
        $apply->use = $post->get('application');
        $apply->project_number = $project->number;
        $apply->project_content = $project->name;
//        $apply->proposer = $post->get('proposer');
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
        return view('pay.list',['lists'=>$data]);
    }
    public function createLoanApply(Request $post)
    {
        $apply = new LoanList();
        $apply->borrower = Auth::user()->name;
        $apply->borrower_id = Auth::id();
        $apply->apply_date = $post->get('date');
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
    public function listLoanPage()
    {
        $lists = LoanList::paginate(10);
        return view('loan.list',['lists'=>$lists]);
    }
    public function listDetailPage()
    {
        $username = Input::get('username');
        $uid = User::where('username','=',$username)->pluck('id')->first();
        return view('loan.detail_list');
    }
    public function listLoanListPage()
    {
        $lists = LoanList::paginate(10);
        return view('loan.loan_list',['lists'=>$lists]);
    }
    public function listSubmitListPage()
    {
        $lists = LoanSubmit::paginate(10);
        return view('loan.submit_list',['lists'=>$lists]);
    }
    public function createSubmitList(Request $post)
    {
        $id = $post->get('id');
        $lists = $post->get('lists');
        if ($id){
            $loan = LoanSubmit::find($id);
        }else{
            $loan = new LoanSubmit();
            $count = LoanSubmit::whereDate('created_at', date('Y-m-d',time()))->count();
            $loan->number = 'BX'.date('Ymd',time()).sprintf("%03d", $count+1);
        }
        $loan->user_id = Auth::id();
        $loan->type = 1;
        $loan->date = $post->get('date');
        $loan->price = $post->get('price');
        if ($loan->save()){
            foreach ($lists as $item){
                $list = new LoanSubmitList();
                $list->loan_id = $loan->id;
                $list->kind_id = $item['kind_id'];
                $list->number = $item['number'];
                $list->price = $item['price'];
                $list->remark = $item['remark'];
                $list->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function createSubmitProject(Request $post)
    {
        $id = $post->get('id');
        $lists = $post->get('lists');
        if ($id){
            $loan = LoanSubmit::find($id);
        }else{
            $loan = new LoanSubmit();
            $count = LoanSubmit::whereDate('created_at', date('Y-m-d',time()))->count();
            $loan->number = 'BX'.date('Ymd',time()).sprintf("%03d", $count+1);
        }
        $loan->user_id = Auth::id();
        $loan->type = 2;
        $loan->date = $post->get('date');
        $loan->price = $post->get('price');
        $loan->project_id = $post->get('project_id');
        if ($loan->save()){
            foreach ($lists as $item){
                $list = new LoanSubmitList();
                $list->loan_id = $loan->id;
                $list->kind_id = $item['kind_id'];
                $list->number = $item['number'];
                $list->price = $item['price'];
                $list->remark = $item['remark'];
                $list->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function listLoanPayPage()
    {
        return view('loan.pay_list');
    }
    public function createLoanPay(Request $post)
    {
        $id = $post->get('id');
        if ($id){
            $pay = LoanPay::find($id);
        }else{
            $pay = new LoanPay();
            $count = LoanPay::whereDate('created_at', date('Y-m-d',time()))->count();
            $pay->number = 'BXFK'.date('Ymd',time()).sprintf("%03d", $count+1);
        }
        $pay->user_id = $post->get('user_id');
        $pay->date = $post->get('date');
        $pay->daduction = $post->get('daduction');
        $pay->cash = $post->get('cash');
        $pay->transfer = $post->get('transfer');
        $pay->bank = $post->get('bank');
        $pay->account = $post->get('account');
        $pay->worker = Auth::id();
        $lists = $post->get('lists');
        if ($pay->save()){
            foreach ($lists as $item){
                $list = new LoanPayList();
                $list->loan_id = $item;
                $list->pay_id = $pay->id;
                $list->save();
            }
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
