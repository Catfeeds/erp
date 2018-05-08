<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\BuildInvoice;
use App\Models\BuildPayFinish;
use App\Models\ConstructionContract;
use App\Models\FinishPayApply;
use App\Models\Invoice;
use App\Models\ProjectTeam;
use App\Models\RequestPayment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class BuildController extends Controller
{
    //
    public function listBuildPage()
    {
        $id = RequestPayment::where('state','=',3)->pluck('project_team')->toArray();
        $lists = ProjectTeam::whereIn('id',$id)->get();
        if (!empty($lists)){
            foreach ($lists as $list){
                $list->invoice_price = $list->invoices()->sum('with_tax');
            }
        }
        return view('build.list',['lists'=>$lists]);
    }
    public function addDealPage()
    {
        return view('build.deal_add');
    }
    public function listDealPage()
    {
        $role = getRole('build_contract_list');
        $search = Input::get('search');
        if ($role=='any'){
            $idArr = getRoleProject('build_contract_list');
            $db = ConstructionContract::where('project_id',$idArr);
            if ($search){
                $db->where('team','like','%'.$search.'%')->orWhere('project_number','like','%'.$search.'%')->orWhere('project_content','like','%'.$search.'%')->orWhere('project_manager','like','%'.$search.'%')
                    ->orWhere('manager','like','%'.$search.'%');
            }
            $lists = $db->orderBy('id','DESC')->paginate(10);
        }else{
            if ($search){
                $lists = ConstructionContract::where('team','like','%'.$search.'%')->orWhere('project_number','like','%'.$search.'%')->orWhere('project_content','like','%'.$search.'%')->orWhere('project_manager','like','%'.$search.'%')
                    ->orWhere('manager','like','%'.$search.'%')->orderBy('id','DESC')->paginate(10);
            }else{
                $lists = ConstructionContract::orderBy('id','DESC')->paginate(10);
            }
        }
        return view('build.deal_list',['lists'=>$lists,'search'=>$search]);
    }
    public function createFinishPage()
    {
        $id = Input::get('id');
        if ($id){
            $payment = RequestPayment::find($id);
            $payment->date = $payment->request_date;
            unset($payment->request_date);
            $payment->build_name = $payment->team;
            $payment->build_manager = $payment->manager;
            $payment->team = $payment->team_id;
            unset($payment->team_id);
            unset($payment->manager);
            $payment->project_id = $payment->project_number;
            $payment->lists = $payment->lists()->get();
            return response()->json(
                $payment
            );
        }
        return view('build.finish_add');
    }
    public function listFinishPage()
    {
        $applies = RequestPayment::paginate(10);
        return view('build.finish_list',['applies'=>$applies]);
    }
    public function listPayPage()
    {
        $id = RequestPayment::where('state','=',3)->pluck('project_team')->toArray();
        $lists = ProjectTeam::whereIn('id',$id)->get();
        return view('build.pay_list',['lists'=>$lists]);
    }
    public function listGetPage()
    {
        $id = RequestPayment::where('state','=',3)->pluck('project_team')->toArray();
        $lists = ProjectTeam::whereIn('id',$id)->get();
        if (!empty($lists)){
            foreach ($lists as $list){
                $list->invoice_price = $list->invoices()->sum('with_tax');
            }
        }
        return view('build.get_list',['lists'=>$lists]);
    }
    public function finishSinglePage()
    {
        $id = Input::get('id');
        $apply = RequestPayment::find($id);
        $lists = $apply->lists()->get();
        return view('build.finish_single',['apply'=>$apply,'lists'=>$lists]);
    }
    public function printBuildFinish()
    {
        $id = Input::get('id');
        $apply = RequestPayment::find($id);
        $lists = $apply->lists()->get();
        return view('build.finish_print',['apply'=>$apply,'lists'=>$lists]);
    }
    public function paySinglePage()
    {
        $id = Input::get('id');
        $projectTeam = ProjectTeam::find($id);
        $lists = $projectTeam->payments()->where('state','=',3)->get();
        $applies = $projectTeam->applies()->get();
        return view('build.pay_single',['projectTeam'=>$projectTeam,'lists'=>$lists,'applies'=>$applies]);
    }
    public function finishBuildPayPage()
    {
        $id = Input::get('id');
        $project_id = Input::get('project_id');
        if ($id){
            $pay = BuildPayFinish::find($id);
            $projectTeam = ProjectTeam::find($pay->project_team);
        }else{
            $projectTeam = ProjectTeam::find($project_id);
            $pay = new BuildPayFinish();
        }
        return view('build.pay_apply',['projectTeam'=>$projectTeam,'pay'=>$pay]);
    }
    public function finishBuildPayApply(Request $post)
    {
        $id = Input::get('id');
        if ($id){
            $pay = BuildPayFinish::find($id);
        }else{
            $pay = new BuildPayFinish();
            $pay->project_team = $post->get('project_id');
            $count = BuildPayFinish::whereDate('created_at', date('Y-m-d',time()))->count();
            $pay->number = 'SGFK'.date('Ymd',time()).sprintf("%03d", $count+1);
            $projectTeam = ProjectTeam::find($pay->project_team);
            $projectTeam->pay_price += $post->get('price');
            $projectTeam->need_price = $projectTeam->price-$projectTeam->pay_price;
            $projectTeam->save();
        }
        $pay->apply_date = $post->get('date');
        $pay->apply_price = $post->get('price');
        $pay->payee = $post->get('payee');
        $pay->bank = $post->get('bank');
        $pay->account = $post->get('account');
        $pay->worker = Auth::user()->username;
        $pay->worker_id = Auth::id();
        if ($pay->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS',
                'data'=>[
                    'id'=>$pay->id
                ]
            ]);
        }
    }
    public function selectPayApplyChecker()
    {
        $id = Input::get('id');
        $pay = BuildPayFinish::find($id);
        $users = Input::get('users');
        if (!empty($users)){
            foreach ($users as $user){
                $task = new Task();
                $task->user_id = $user;
                $task->type = 'build_pay_check';
                $task->title = '付款申请复核';
                $task->url = 'build/pay/single?id='.$pay->project_team;
                $task->number = $pay->number;
                $task->content = $id;
                $task->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function selectPayApplyPasser()
    {
        $id = Input::get('id');
        $pay = BuildPayFinish::find($id);
        $users = Input::get('users');
        if (!empty($users)){
            foreach ($users as $user){
                $task = new Task();
                $task->user_id = $user;
                $task->type = 'build_pay_pass';
                $task->title = '付款申请审批';
                $task->url = 'build/pay/single?id='.$pay->project_team;
                $task->number = $pay->number;
                $task->content = $id;
                $task->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function checkBuildPayApply()
    {
        $id = Input::get('id');
        $pay = BuildPayFinish::find($id);
        if ($pay->state!=1){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态不允许复核！'
            ]);
        }
        $pay->state = 2;
        $pay->checker = Auth::user()->username;
        $pay->checker_id = Auth::id();
        $pay->save();
        Task::where('type','=','build_pay_check')->where('content','=',$id)->update(['state'=>0]);
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>[
                'id'=>$pay->id
            ]
        ]);
    }
    public function passBuildPayApply()
    {
        $id = Input::get('id');
        $pay = BuildPayFinish::find($id);
        if ($pay->state!=2){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态不允许复核！'
            ]);
        }
        $pay->state = 3;
        $pay->passer = Auth::user()->username;
        $pay->passer_id = Auth::id();
        $pay->save();
        Task::where('type','=','build_pay_pass')->where('content','=',$id)->update(['state'=>0]);
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function payAddPage()
    {
        $id = Input::get('id');
        $pay = BuildPayFinish::find($id);
        $projectTeam = ProjectTeam::find($pay->project_team);
        return view('build.pay_add',['pay'=>$pay,'projectTeam'=>$projectTeam]);
    }
    public function payAdd(Request $post)
    {
        $id = $post->get('apply_id');
        $pay = BuildPayFinish::find($id);
        $pay->pay_worker = $post->get('worker');
        $pay->pay_worker_id = Auth::id();
        $bank = BankAccount::find($post->get('bank_id'));
        $pay->pay_bank = $bank->name;
        $pay->pay_account = $bank->account;
        $pay->remark = $post->get('remark');
        $pay->pay_date = $post->get('date');
        $pay->pay_price = $pay->apply_price;
        $pay->state = 4;
        $pay->save();
        $projectTeam = ProjectTeam::find($pay->project_team);
        $projectTeam->pay_price +=$pay->pay_price;
        $projectTeam->need_price = $projectTeam->price-$projectTeam->pay_price;
        $projectTeam->save();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function getSinglePage()
    {
        $id = Input::get('id');
        $projectTeam = ProjectTeam::find($id);
        $invoices = $projectTeam->invoices()->get();
        return view('build.get_single',['projectTeam'=>$projectTeam,'invoices'=>$invoices]);
    }
    public function getAddPage()
    {
        $id = Input::get('id');
        $projectTeam = ProjectTeam::find($id);
        $invoices = Invoice::where('state','=',1)->get();
        return view('build.get_add',['projectTeam'=>$projectTeam,'invoices'=>$invoices]);
    }
    public function getAdd(Request $post)
    {
        $lists = $post->get('lists');
        if (!empty($lists)){
            foreach ($lists as $list){
                $type = Invoice::find($list['type']);
                $invoice = new BuildInvoice();
                $invoice->project_team = $post->get('pay_id');
                $invoice->date = $post->get('date');
                $invoice->worker = Auth::user()->name;
                $invoice->worker_id = Auth::id();
                $invoice->invoice_date = $list['date'];
                $invoice->number = $list['number'];
                $invoice->type = $type->name;
                $invoice->without_tax = $list['without_tax'];
                $invoice->with_tax = $list['with_tax'];
                $invoice->tax = $list['tax'];
                $invoice->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);


//        $table->unsignedInteger('project_team');
//        $table->string('date');
//        $table->string('worker');
//        $table->unsignedInteger('worker_id')->default(0);
//        $table->string('invoice_date');
//        $table->string('number');
//        $table->string('type');
//        $table->float('without_tax',18,2)->default(0);
//        $table->float('tax',18,2)->default(0);
//        $table->float('with_tax',18,2)->default(0);
    }
    public function printBuildPay()
    {
        return view('build.pay_print');
    }
    public function printBuildGet()
    {
        $id = Input::get('id');
        $projectTeam = ProjectTeam::find($id);
        $invoices = $projectTeam->invoices()->get();
        return view('build.get_print',['projectTeam'=>$projectTeam,'invoices'=>$invoices]);
    }
    public function editBuildGetPage()
    {

    }
    public function detailDealPage()
    {
        $id = Input::get('id');
        $contract = ConstructionContract::find($id);
        $pictures = $contract->lists()->get();
        return view('build.detail_single',['pictures'=>$pictures]);
    }

}
