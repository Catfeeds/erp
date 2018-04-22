<?php

namespace App\Http\Controllers;

use App\Models\LoanSubmit;
use App\Models\LoanSubmitCheck;
use App\Models\LoanSubmitPass;
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
        if (!empty($users)){
            foreach ($users as $user){
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
        if (!empty($users)){
            foreach ($users as $user){
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
        return view('loan.pay_add');
    }
}
