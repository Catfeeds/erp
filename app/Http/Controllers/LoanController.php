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
use Illuminate\Validation\Rules\In;

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
    public function deleteSubmit()
    {
        $id = Input::get('id');
        $loan = LoanSubmit::find($id);
        if($loan->state !=1){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态不能删除！'
            ]);
        }
        $loan->delete();
        Task::where('type','=','loan_project_submit_check')->where('content','=',$id)->update(['state'=>0]);
        Task::where('type','=','loan_submit_check')->where('content','=',$id)->update(['state'=>0]);
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
            Task::where('type','=','loan_project_submit_check')->where('content','=',$id)->delete();
            Task::where('type','=','loan_submit_check')->where('content','=',$id)->delete();
            Task::where('type','=','loan_project_submit_pass')->where('content','=',$id)->delete();
            Task::where('type','=','loan_submit_pass')->where('content','=',$id)->delete();
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
            $loanPrice = LoanList::where('borrower','=',$loan->loan_user)->where('state','>=',3)->sum('price');
            $submitPrice = LoanPay::where('applier','=',$loan->loan_user)->sum('deduction');
            $price = LoanSubmit::where('loan_user','=',$loan->loan_user)->where('state','=',3)->sum('price');
            $loan->loanBalance = $loanPrice-$submitPrice;
            $loan->submitBalance = $price+$loan->price;
//            dd($loan);
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
        $loanPrice = LoanList::where('borrower','=',$user)->where('state','>=',3)->sum('price');
//            dd($loanPrice);
        $submitPrice = LoanPay::where('applier','=',$user)->sum('deduction');
//        $price = LoanSubmit::where('loan_user','=',$user)->where('state','=',3)->sum('price');
        $count = $loanPrice-$submitPrice;
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'count'=>$count,
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
        $loanPrice = LoanList::where('borrower','=',$loan->applier)->sum('price');
        $loanPrice -=$price;
        $submitPrice = LoanSubmit::where('loan_user','=',$loan->applier)->where('state','!=',4)->sum('price');
//        $loanBalance =
        return view('loan.loan_single',['loan'=>$loan,'lists'=>$lists,'price'=>$price,'loanPrice'=>$loanPrice,'submitPrice'=>$submitPrice]);
    }
    public function listDetailPage()
    {
        $name = Input::get('name');
        $s = Input::get('s');
        $e = Input::get('e');
        if (!$name||!$s){
            $lists = [];
            $start = 0;
            $loanStart = 0;
        }else{
            $list1 = LoanList::where('borrower','=',$name)->where('state','=',3)->whereBetween('created_at',[$s,$e])->select(['number','price','apply_date as date','loanBalance','submitBalance','created_at'])->get()->toArray();
            $list2 = LoanSubmit::where('loan_user','=',$name)->where('state','>=',3)->whereBetween('created_at',[$s,$e])->select(['number','price','date','loanBalance','submitBalance','created_at'])->get()->toArray();
            $list3 = LoanPay::where('applier','=',$name)->whereBetween('created_at',[$s,$e])->select(['number','price','date','loanBalance','submitBalance','cash','transfer','deduction','created_at'])->get()->toArray();
            $swap = array_merge($list1,$list2);
            $lists = array_merge($swap,$list3);
            $swap4 = [];
            $swap1 = LoanList::where('borrower','=',$name)->where('state','=',3)->where('created_at','<',$s)->select(['number','price','apply_date as date','loanBalance','submitBalance','created_at'])->orderBy('id','DESC')->get()->toArray();
            if (!empty($swap1)){
                array_push($swap4,$swap1[0]);
            }
            $swap2 = LoanSubmit::where('loan_user','=',$name)->where('state','>=',3)->where('created_at','<',$s)->select(['number','price','date','loanBalance','submitBalance','created_at'])->orderBy('id','DESC')->get()->toArray();
            if (!empty($swap2)){
                array_push($swap4,$swap2[0]);
            }
            $swap3 = LoanPay::where('applier','=',$name)->where('created_at','<',$s)->select(['number','price','date','loanBalance','submitBalance','cash','transfer','deduction','created_at'])->orderBy('id','DESC')->get()->toArray();
            if (!empty($swap3)){
                array_push($swap4,$swap3[0]);
            }
//            $swap4 = [$swap1,$swap2,$swap3];
//            dd($swap4);
            if (!empty($swap4)){
                array_multisort(array_column($swap4,'created_at'),SORT_DESC,$swap4);
            }
//            dd($swap4);
            $start = !empty($swap4)?$swap4[0]['loanBalance']:0;
            $loanStart = !empty($swap4)?$swap4[0]['submitBalance']:0;
            array_multisort(array_column($lists,'created_at'),SORT_ASC,$lists);
        }
        return view('loan.detail_list',['lists'=>$lists,'name'=>$name,'s'=>$s,'e'=>$e,'start'=>$start,'loanStart'=>$loanStart]);
    }
    public function payPrint()
    {
        $id = Input::get('id');
        $loan = LoanPay::find($id);
        $idArr = LoanPayList::where('pay_id','=',$id)->pluck('loan_id')->toArray();
        $lists = LoanSubmit::whereIn('id',$idArr)->get();
        $price = LoanSubmit::whereIn('id',$idArr)->sum('price');
//        $loan_price = Loan
        $loanPrice = LoanList::where('borrower','=',$loan->applier)->sum('price');
        $loanPrice -=$price;
        $submitPrice = LoanSubmit::where('loan_user','=',$loan->applier)->where('state','!=',4)->sum('price');
//        $loanBalance =
        return view('loan.pay_print',['loan'=>$loan,'lists'=>$lists,'price'=>$price,'loanPrice'=>$loanPrice,'submitPrice'=>$submitPrice]);
    }
}
