<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\LoanList;
use App\Models\LoanPay;
use App\Models\LoanPayList;
use App\Models\LoanSubmit;
use App\Models\LoanSubmitCheck;
use App\Models\LoanSubmitPass;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class LoanController extends Controller
{
    //
    public function selectSubmitCheck()
    {
        $id = Input::get('id');
        $users = Input::get('users');
        $submit = LoanSubmit::find($id);
        if (!empty($users)){
            foreach ($users as $user){
                $task = new Task();
                $task->user_id = $user;

                if ($submit->type==2){
                    $task->type = 'loan_project_submit_check';
                    $task->title = '项目成本报销复核';
                    $task->url = 'loan/submit/single?id='.$id;
                }else{
                    $task->type = 'loan_submit_check';
                    $task->title = '期间费用报销复核';
                    $task->url = 'loan/submit/single?id='.$id;
                }
                $task->number = $submit->number;
                $task->content = $id;
                $task->save();
                $check = new LoanSubmitCheck();
                $check->submit_id = $id;
                $check->user_id = $user;
                $check->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function selectSubmitPass()
    {
        $id = Input::get('id');
        $users = Input::get('users');
        $submit = LoanSubmit::find($id);
        if (!empty($users)){
            foreach ($users as $user){
                $task = new Task();
                $task->user_id = $user;

                if ($submit->type==2){
                    $task->type = 'loan_project_submit_pass';
                    $task->title = '项目成本报销审批';
                    $task->url = 'loan/submit/single?id='.$id;
                }else{
                    $task->type = 'loan_submit_pass';
                    $task->title = '期间费用报销审批';
                    $task->url = 'loan/submit/single?id='.$id;
                }
                $task->number = $submit->number;
                $task->content = $id;
                $task->save();
                $check = new LoanSubmitPass();
                $check->submit_id = $id;
                $check->user_id = $user;
                $check->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function checkSubmit()
    {
        $id = Input::get('id');
        $loan = LoanSubmit::find($id);
        if ($loan->state!=1){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态不能复核！'
            ]);
        }else{
            $loan->state = 2;
            $loan->checker_id = Auth::id();
            $loan->checker = Auth::user()->name;
            $loan->save();
            Task::where('type','=','loan_project_submit_check')->where('content','=',$id)->update(['state'=>0]);
            Task::where('type','=','loan_submit_check')->where('content','=',$id)->update(['state'=>0]);
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS',
                'data'=>['id'=>$loan->id]
            ]);
        }
    }
    public function passSubmit()
    {
        $id = Input::get('id');
        $loan = LoanSubmit::find($id);
        if ($loan->state!=2){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态不能审批！'
            ]);
        }else{
            $loan->state = 3;
            $loan->passer_id = Auth::id();
            $loan->passer = Auth::user()->name;
            $loan->save();
            Task::where('type','=','loan_project_submit_pass')->where('content','=',$id)->update(['state'=>0]);
            Task::where('type','=','loan_submit_pass')->where('content','=',$id)->update(['state'=>0]);
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS',
                'data'=>['id'=>$loan->id]
            ]);
        }
    }
    public function searchLoanUser()
    {
        $name = Input::get('name');
        $db = LoanSubmit::where('state','=',3);
        if ($name){
            $db->where('loan_user','like','%'.$name.'%');
        }
        $data= $db->groupBy('loan_user')->select('loan_user as name')->get();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$data
        ]);
    }
    public function searchLoanSubmit()
    {
        $user = Input::get('name');
        $lists = LoanSubmit::where('state','=',3)->where('loan_user','=',$user)->get();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$lists
        ]);
    }
    public function showLoanPayAdd()
    {
        $bank = BankAccount::where('state','=',1)->get();
        return view('loan.pay_add',['bank'=>$bank]);
    }
    public function printLoan()
    {
        $id = Input::get('id');
        $loan = LoanList::find($id);
        return view('loan.print',['loan'=>$loan]);
    }
    public function printLoanSubmit()
    {
        $id = Input::get('id');
        $submit = LoanSubmit::find($id);
        $lists = $submit->lists()->get();
        return view('loan.submit_print',['submit'=>$submit,'lists'=>$lists]);
    }
    public function singlePayPage()
    {
        $id = Input::get('id');
        $loan = LoanPay::find($id);
        $idArr = LoanPayList::where('pay_id','=',$id)->pluck('loan_id')->toArray();
        $lists = LoanSubmit::whereIn('id',$idArr)->get();
        $price = LoanSubmit::whereIn('id',$idArr)->sum('price');
//        $loan_price = Loan
        $submitPrice = LoanSubmit::where('loan_user','=',$loan->applier)->sum('price');
//        $loanBalance =
        return view('loan.loan_single',['loan'=>$loan,'lists'=>$lists,'price'=>$price]);
    }
}
