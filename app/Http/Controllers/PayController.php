<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Category;
use App\Models\Detail;
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
use App\Models\ProjectTeam;
use App\Models\RequestPayment;
use App\Models\RequestPaymentList;
use App\Models\Task;
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
        $apply->apply_date = $post->get('date');
        $apply->number = 'FK'.date('Ymd',time()).sprintf("%03d", $count+1);
        $apply->price = $post->get('amount');
        $apply->use = $post->get('usage');
        $project_id = $post->get('project_id');
        if ($project_id){
            $project = Project::find($post->get('project_id'));
            $apply->project_number = $project->number;
            $apply->project_content = $project->name;
            $apply->project_id = $project->id;
        }
        $apply->proposer = $post->get('apply_user');
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
            Task::where('type','=','pay_pass')->where('content','=',$id)->delete();
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
                $task = new Task();
                $task->user_id = $user;
                $task->content = $id;
                $task->type = 'pay_pass';
                $task->title = '付款审批';
                $task->number = PayApply::find($id)->number;
                $task->url = 'pay/single?id='.$id;
                $task->content = $id;
                $task->save();
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
            Task::where('type','=','pay_pass')->where('content','=',$id)->update(['state'=>0]);
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
        $loanPrice = LoanList::where('borrower','=',$apply->borrower)->sum('price');
        $submitPrice = LoanPay::where('applier','=',$apply->borrower)->sum('deduction');
        $price = LoanSubmit::where('loan_user','=',$apply->borrower)->where('state','!=',4)->sum('price');
        $apply->loanBalance = $loanPrice-$submitPrice;
        $apply->submitBalance = $price;
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
                'msg'=>'当前状态不允许审批！'
            ]);
        }else{
            $loan->state = 2;
            $loan->approver = Auth::user()->name;
            $loan->approver_id = Auth::id();
            $loan->save();
            Task::where('type','=','loan_loan_pass')->where('content','=',$id)->update(['state'=>0]);
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
                $task = new Task();
                $task->user_id = $user;
                $task->type = 'loan_loan_pass';
                $task->title = '借款审批';
                $task->number = LoanList::find($id)->number;
                $task->url = 'loan/loan/list';
                $task->content = $id;
                $task->save();
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
        $loan->pay_type = $post->get('pay_type');
        $loan->manager = $post->get('people');
//        $loan->manager_id = Auth::id();
        $loan->bank = $post->get('bank');
        $loan->account = $post->get('account');
        $loan->manager_id = Auth::id();
        $loan->state = 3;
        if ($loan->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function listLoanPage()
    {
        $role = getRole('loan_list');
        if ($role=='all'){
            $list = LoanList::select(['borrower as name','price'])->where('state','=',2)->groupBy('name')->get()->toArray();
            $list2 = LoanSubmit::select(['loan_user as name','price'])->where('state','=',3)->groupBy('name')->get()->toArray();
        }else{
            $list = LoanList::select(['borrower as name','price'])->where('borrower','=',Auth::user()->username)->where('state','=',2)->groupBy('name')->get()->toArray();
            $list2 = LoanSubmit::select(['loan_user as name','price'])->where('loan_user','=',Auth::user()->username)->where('state','=',3)->groupBy('name')->get()->toArray();
        }
//        dd($list2);
        $swap = array_merge(array_column($list,'name'),array_column($list2,'name'));
        $swap = array_unique($swap);
//        dd($swap);
        $result = [];
        for ($i=0;$i<count($swap);$i++){
            $result[$i]['name'] = $swap[$i];
            $result[$i]['loan_price'] = LoanList::where('borrower','=',$swap[$i])->where('state','=',3)->sum('price')-LoanPay::where('applier','=',$swap[$i])->sum('deduction');
            $result[$i]['submit_price'] = LoanSubmit::where('loan_user','=',$swap[$i])->where('state','=',3)->sum('price');
        }
//        dd($result);
//        $result=[];
        return view('loan.list',['lists'=>$result]);
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
        $bank = BankAccount::where('state','=',1)->get();
        return view('loan.loan_pay',['loan'=>$loan,'bank'=>$bank]);
    }
    public function listSubmitListPage()
    {
        $lists = LoanSubmit::orderBy('id','DESC')->paginate(10);
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
        $loanPrice = LoanList::where('borrower','=',$loan->loan_user)->sum('price');
        $submitPrice = LoanPay::where('applier','=',$loan->loan_user)->sum('deduction');
        $price = LoanSubmit::where('loan_user','=',$loan->loan_user)->where('state','!=',4)->sum('price');
        $loan->loanBalance = $loanPrice-$submitPrice;
        $loan->submitBalance = $price;
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
                if (isset($item['remark'])){
                    $list->remark = $item['remark'];
                }
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
            $loan->lists()->delete();
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
        $loanPrice = LoanList::where('borrower','=',$loan->loan_user)->sum('price');
        $submitPrice = LoanPay::where('applier','=',$loan->loan_user)->sum('deduction');
        $price = LoanSubmit::where('loan_user','=',$loan->loan_user)->where('state','!=',4)->sum('price');
        $loan->loanBalance = $loanPrice-$submitPrice;
        $loan->submitBalance = $price;
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
                if(isset($item['remark'])){
                    $list->remark = $item['remark'];
                }
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
        $lists = LoanPay::paginate(10);
        foreach ($lists as $list){
            $idArr = LoanPayList::where('pay_id','=',$list->id)->pluck('loan_id')->toArray();
            $list->BXNumber = LoanSubmit::whereIn('id',$idArr)->pluck('number')->toArray();
            $list->BXNumber = implode(',',$list->BXNumber);
        }
//        dd($lists);
        return view('loan.pay_list',['lists'=>$lists]);
    }
    public function loanSubmitSingle()
    {
        $id = Input::get('id');
        $loan = LoanSubmit::find($id);
        $loan->lists = $loan->lists()->get();
        if ($loan->type==1){
            $check = 'loan_submit_check';
            $pass = 'loan_submit_pass';
        }else{
            $check = 'loan_project_submit_check';
            $pass = 'loan_project_submit_pass';
        }
        return view('loan.single',['loan'=>$loan,'check'=>$check,'pass'=>$pass]);
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
        $pay->deduction = empty($post->get('daduction'))?0:$post->get('daduction');
        $pay->cash = empty($post->get('cash'))?0:$post->get('cash');
        $pay->transfer = empty($post->get('transfer'))?0:$post->get('transfer');
        $pay->price = $pay->cash+$pay->deduction+$pay->transfer;
        $bank = BankAccount::find($post->get('bank'));
        if ($bank){
            $pay->bank = $bank->name ;
            $pay->account = $post->get('account');
        }
        $pay->worker = Auth::id();

        $lists = $post->get('lists');
        if ($pay->save()){
            foreach ($lists as $item){
                $list = new LoanPayList();
                $list->loan_id = $item;
                $list->pay_id = $pay->id;
                $submit = LoanSubmit::find($item);
                $pay->applier = $submit->loan_user;
                $submit->state=4;
                $submit->FKNumber = $pay->number;
                $submit->save();
                $list->save();
            }


        }
        $loanPrice = LoanList::where('borrower','=',$pay->applier)->sum('price');
        $submitPrice = LoanPay::where('applier','=',$pay->applier)->sum('deduction');
        $price = LoanSubmit::where('loan_user','=',$pay->applier)->where('state','!=',4)->sum('price');
        $pay->loanBalance = $loanPrice-$submitPrice;
        $pay->submitBalance = $price;
        $pay->save();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
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
        $id = Input::get('id');
        $payment = RequestPayment::find($id);
        if ($payment->state !=1){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态不允许复核！'
            ]);
        }
        $payment->state=2;
        $payment->checker_id = Auth::id();
        $payment->checker = Auth::user()->username;
        $payment->save();
        Task::where('type','=','build_finish_check')->where('content','=',$id)->update(['state'=>0]);
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>[
                'id'=>$id
            ]
        ]);
    }
    public function passRequestPayment()
    {
        $id = Input::get('id');
        $payment = RequestPayment::find($id);
        if ($payment->state !=2){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态不允许审批！'
            ]);
        }
        $payment->state=3;
        $payment->passer_id = Auth::id();
        $payment->passer = Auth::user()->username;
        $payment->save();
        $team = ProjectTeam::find($payment->project_team);
        $team->price += $payment->price;
        $team->save();
        Task::where('type','=','build_finish_pass')->where('content','=',$id)->update(['state'=>0]);
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function selectChecker()
    {
        $id = Input::get('id');
        $users = Input::get('users');
        $payment = RequestPayment::find($id);
        foreach ($users as $user){
            $task = new Task();
            $task->user_id = $user;
            $task->type = 'build_finish_check';
            $task->title = '完工请款复核';
            $task->url = 'build/finish/single?id='.$id;
            $task->number = $payment->number;
            $task->content = $id;
            $task->save();
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function selectPasser()
    {
        $id = Input::get('id');
        $users = Input::get('users');
        $payment = RequestPayment::find($id);
        foreach ($users as $user){
            $task = new Task();
            $task->user_id = $user;
            $task->type = 'build_finish_pass';
            $task->title = '完工请款审批';
            $task->url = 'build/finish/single?id='.$id;
            $task->number = $payment->number;
            $task->content = $id;
            $task->save();
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function addRequestPayment(Request $post)
    {
        $project = Project::where('number','=',$post->get('project_id'))->first();
        $team = Team::find($post->get('team'));
        $projectTeam = ProjectTeam::where('team_id','=',$post->get('team'))->where('project_id','=',$project->id)->first();
        if (empty($projectTeam)){
            $projectTeam = new ProjectTeam();
            $projectTeam->project_id = $project->id;
            $projectTeam->project_number = $project->number;
            $projectTeam->project_content = $project->name;
            $projectTeam->project_manager = $project->pm;
            $projectTeam->team_id = $team->id;
            $projectTeam->team = $team->name;
            $projectTeam->manager = $team->manager;
//            $projectTeam->price = $post->get('price');
//            $projectTeam->need_price = $post->get('price');
            $projectTeam->save();
        }
        $lists = $post->get('lists');
        $payment = new RequestPayment();
        $payment->project_team = $projectTeam->id;
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
                if (isset($item['para'])){
                    $list->param = $item['para'];
                }
                if (isset($item['remark'])){
                    $list->remark = $item['remark'];
                }
                $list->number = $item['number'];
                $list->unit = $item['unit'];
                $list->price = $item['price'];
                $list->total = $item['total'];

                $list->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>[
                'id'=>$payment->id
            ]
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
        $id = Input::get('id');
        if ($id){
            $submit = LoanSubmit::find($id);
            $lists = $submit->lists()->get();
            foreach ($lists as $list){
                $list->type = Category::find($list->category_id)->title;
                $list->detailType = Detail::find($list->kind_id)->title;
            }
            return view('loan.submit_project',['submit'=>$submit,'lists'=>$lists]);
        }
        return view('loan.submit_project');
    }
    public function paySinglePage()
    {
        $id = Input::get('id');
        $apply = PayApply::find($id);
        return view('pay.single',['apply'=>$apply]);
    }
    public function printPay()
    {
        $id = Input::get('id');
        $apply = PayApply::find($id);
        return view('pay.print',['apply'=>$apply]);
    }
    public function deleteRequestPayment()
    {
        $id = Input::get('id');
        $payment = RequestPayment::find($id);
        if ($payment->state!=1){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态不允许删除!'
            ]);
        }
        $payment->lists()->delete();
        $payment->delete();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);

    }

}
