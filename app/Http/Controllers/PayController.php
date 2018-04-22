<?php

namespace App\Http\Controllers;

use App\Models\FinishPayApply;
use App\Models\LoanList;
use App\Models\LoanListAllow;
use App\Models\LoanPay;
use App\Models\LoanPayList;
use App\Models\LoanSubmit;
use App\Models\LoanSubmitList;
use App\Models\PayApply;
use App\Models\PayApplyAllow;
use App\Models\Project;
use App\Models\RequestPayment;
use App\Models\RequestPaymentList;
use App\Models\Team;
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
        $apply->price = $post->get('amount');
        $apply->use = $post->get('usage');
        $apply->project_number = $project->number;
        $apply->project_content = $project->name;
        $apply->project_id = $project->id;
        $apply->proposer = $post->get('people');
        $apply->proposer_id = Auth::id();
        if ($apply->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS',
                'data'=>[
                    'id'=>$apply->id
                ]
            ]);
        }
    }
    public function payPage()
    {
        $id = Input::get('id');
        $apply = PayApply::find($id);
        return view('pay.pay',['apply'=>$apply]);
    }
    public function finishPayApply(Request $post)
    {
        $apply = PayApply::find($post->get('id'));
        if ($apply->state!=2){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态不能付款！'
            ]);
        }
        $apply->pay_date = $post->get('pay_date');
        $apply->cash = $post->get('cash');
        $apply->transfer = $post->get('transfer');
        $apply->other = $post->get('other');
        $apply->bank = $post->get('bank');
        $apply->account = $post->get('account');
        $apply->manager = $post->get('manager');
        $apply->state = 3;
        $apply->manager_id = Auth::id();
        if($apply->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function cancelApply()
    {
        $id = Input::get('id');
        $apply = PayApply::find($id);
        if ($apply->state ==1){
//            $apply->state =0;
            $apply->delete();
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }else{
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态不允许撤销！'
            ]);
        }
    }
    public function selectApprover()
    {
        $id = Input::get('id');
        $users = Input::get('users');
        if (!empty($users)){
            foreach ($users as $user){
                $allow = new PayApplyAllow();
                $allow->apply_id = $id;
                $allow->user_id = $user;
                $allow->save();
            }
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function confirmApply()
    {
        $id = Input::get('id');
        $apply = PayApply::find($id);
        if ($apply->state !=1){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态不允许审核！'
            ]);
        }else{
            $apply->state = 2;
            $apply->approver_id = Auth::id();
            $apply->approver = Auth::user()->name;
            $apply->save();
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
    //借款
    public function createLoanApply(Request $post)
    {
        $apply = new LoanList();
        $apply->borrower = $post->get('loan_user');
        $apply->borrower_id = Auth::id();
        $count = LoanList::whereDate('created_at', date('Y-m-d',time()))->count();
        $apply->number = 'JK'.date('Ymd',time()).sprintf("%03d", $count+1);
        $apply->apply_date = $post->get('date');
        $apply->price = $post->get('preice');
        $apply->reason = $post->get('reason');
        if ($apply->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function cancelLoan()
    {
        $id = Input::get('id');
        $loan = LoanList::find($id);
        if ($loan->state!=1){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态不允许撤销！'
            ]);
        }else{
            $loan->delete();
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function confirmLoan()
    {
        $id = Input::get('id');
        $loan = LoanList::find($id);
        if ($loan->state!=1){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态不允许撤销！'
            ]);
        }else{
            $loan->state = 2;
            $loan->approver = Auth::user()->name;
            $loan->approver_id = Auth::id();
            $loan->save();
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function selectLoanApprover()
    {
        $id = Input::get('id');
        $users = Input::get('users');
        if (!empty($users)){
            foreach ($users as $user){
                $allow = new LoanListAllow();
                $allow->loan_id = $id;
                $allow->user_id = $user;
                $allow->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function finishLoan(Request $post)
    {
        $loan = LoanList::find($post->get('id'));
        $loan->pay_date = $post->get('date');
        $loan->pay_type = $post->get('type');
        $loan->manager = $post->get('people');
//        $loan->manager_id = Auth::id();
        $loan->bank = $post->get('bank');
        $loan->account = $post->get('account');
        $loan->manager_id = Auth::id();
        if ($loan->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function listLoanPage()
    {
        $lists = User::paginate(10);
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
    public function showLoanPay()
    {
        $id = Input::get('id');
        $loan = LoanList::find($id);
        return view('loan.loan_pay',['loan'=>$loan]);
    }
    public function listSubmitListPage()
    {
        $lists = LoanSubmit::paginate(10);
        return view('loan.submit_list',['lists'=>$lists]);
    }
    public function createSubmitList(Request $post)
    {
//        dd($post->all());
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
        $loan->loan_user = $post->get('loan_user');
        if ($loan->save()){
            foreach ($lists as $item){
                $list = new LoanSubmitList();
                $list->loan_id = $loan->id;
                if (!empty($item['kind_id'])){
                    $list->kind_id = $item['kind_id'];
                }
                $list->category_id = $item['category_id'];
                $list->number = $item['number'];
                $list->price = $item['price'];
                $list->remark = $item['remark'];
                $list->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>[
                'id'=>$loan->id
            ]
        ]);
    }
    //新增报销
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
        $loan->loan_user = $post->get('loan_user');
        if ($loan->save()){
            foreach ($lists as $item){
                $list = new LoanSubmitList();
                $list->loan_id = $loan->id;
                if (!empty($item['kind_id'])){
                    $list->kind_id = $item['kind_id'];
                }
                $list->category_id = $item['category_id'];
                $list->number = $item['number'];
                $list->price = $item['price'];
                $list->remark = $item['remark'];
                $list->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>[
                'id'=>$loan->id
            ]
        ]);
    }
    public function listLoanPayPage()
    {
        return view('loan.pay_list');
    }
    public function loanSubmitSingle()
    {
        $id = Input::get('id');
        $loan = LoanSubmit::find($id);
        $loan->lists = $loan->lists()->get();
        return view('loan.single',['loan'=>$loan]);
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
//        $pay->user_id = $post->get('user_id');
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
                $submit = LoanSubmit::find($item);
                $submit->state=4;
                $submit->save();
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
    public function checkRequestPayment()
    {

    }
    public function passRequestPayment()
    {

    }
    public function addRequestPayment(Request $post)
    {
        $lists = $post->get('list');
        $payment = new RequestPayment();
        $team = Team::find($post->get('team'));
        $count = RequestPayment::whereDate('created_at', date('Y-m-d',time()))->count();
        $payment->number = 'QK'.date('Ymd',time()).sprintf("%03d", $count+1);
        $payment->team = $team->name;
        $payment->manager = $team->manager;
//        $project = Project::where('number','=',$post->get('project_id'))->first();
        $payment->project_number = $post->get('project_id');
        $payment->project_content = $post->get('project_content');
        $payment->project_manager = $post->get('project_manager');
        $payment->request_date = $post->get('date');
        $payment->price = $post->get('price');
        $payment->applier = Auth::user()->name;
        $payment->applier_id = Auth::id();
        $payment->save();
        if (!empty($lists)){
            foreach ($lists as $item){
                $list = new RequestPaymentList();
                $list->payment_id = $payment->id;
                $list->name = $item['name'];
                $list->param = $item['para'];
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
    public function addLoanPage()
    {
        return view('loan.loan_add');
    }
    public function createSubmitOtherPage()
    {
        return view('loan.submit_other');
    }
    public function createSubmitProjectPage()
    {
        return view('loan.submit_project');
    }
    public function paySinglePage()
    {
        $id = Input::get('id');
        $apply = PayApply::find($id);
        return view('pay.single',['apply'=>$apply]);
    }

}
