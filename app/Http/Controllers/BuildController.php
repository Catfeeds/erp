<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\BuildInvoice;
use App\Models\BuildPayFinish;
use App\Models\ConstructionContract;
use App\Models\FinishPayApply;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\ProjectTeam;
use App\Models\RequestPayment;
use App\Models\Task;
use App\Models\Team;
use App\RequestPaymentPicture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class BuildController extends Controller
{
    //
    public function listBuildPage()
    {
        $role = getRole('build_list');
        $key = Input::get('searchType');
        $search = Input::get('search');
        if ($role=='all'){
//            dd($key);
            $db = RequestPayment::where('state','=',3);
            if ($key){
                switch ($key){
                    case 1:
//                        $team_id = Team::where('state','=',1)->orWhere('name','like','%'.$search.'%')->pluck('id')->toArray();
                        $db->where('team','like','%'.$search.'%');
                        break;
                    case 2:
                        $db->where('project_number','like','%'.$search.'%');
                        break;
                    case 3:
                        $db->where('project_content','like','%'.$search.'%');
                        break;
                    case 4:
                        $db->where('project_manager','like','%'.$search.'%');
                        break;
                }
            }
            $id = $db->pluck('project_team')->toArray();
            $lists = ProjectTeam::whereIn('id',$id)->paginate(10);
        }else{
            $idArr = getRoleProject('build_list');
            $numberArr = Project::whereIn('id',$idArr)->pluck('number')->toArray();
            $db = RequestPayment::where('state','=',3);
            if ($key){
                switch ($key){
                    case 1:
//                        $team_id = Team::where('state','=',1)->orWhere('name','like','%'.$search.'%')->pluck('id')->toArray();
                        $db->where('team','like','%'.$search.'%');
                        break;
                    case 2:
                        $db->where('project_number','like','%'.$search.'%');
                        break;
                    case 3:
                        $db->where('project_content','like','%'.$search.'%');
                        break;
                    case 4:
                        $db->where('project_manager','like','%'.$search.'%');
                        break;
                }
            }
            $id = $db->whereIn('project_number',$numberArr)->pluck('project_team')->toArray();
            $lists = ProjectTeam::whereIn('id',$id)->paginate(10);
        }
        if (!empty($lists)){
            foreach ($lists as $list){
                $list->invoice_price = $list->invoices()->sum('with_tax');
                $list->project = Project::where('number','=',$list->project_number)->first();
            }
        }
        return view('build.list',['lists'=>$lists,'searchType'=>$key,'search'=>$search]);
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
        if (!empty($lists)){
            foreach ($lists as $list){
                $list->project = Project::where('number','=',$list->project_number)->first();
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
        $role = getRole('build_finish_list');
        $key = Input::get('searchType');
        $search = Input::get('search');
        $db = DB::table('request_payments');
        if ($role=='all') {
            if ($key){
                switch ($key){
                    case 1:
//                        $team_id = Team::where('state','=',1)->orWhere('name','like','%'.$search.'%')->pluck('id')->toArray();
                        $db->where('team','like','%'.$search.'%');
                        break;
                    case 2:
                        $db->where('manager','like','%'.$search.'%');
                        break;
                    case 3:
                        $db->where('project_number','like','%'.$search.'%');
                        break;
                    case 4:
                        $db->where('project_content','like','%'.$search.'%');
                        break;
                    case 5:
                        $db->where('project_manager','like','%'.$search.'%');
                        break;
                }
            }
            $applies = $db->orderBy('id','DESC')->paginate(10);
        }else{
            $idArr = getRoleProject('build_finish_list');
            $numberArr = Project::whereIn('id',$idArr)->pluck('number')->toArray();
            if ($key){
                switch ($key){
                    case 1:
//                        $team_id = Team::where('state','=',1)->orWhere('name','like','%'.$search.'%')->pluck('id')->toArray();
                        $db->where('team','like','%'.$search.'%');
                        break;
                    case 2:
                        $db->where('manager','like','%'.$search.'%');
                        break;
                    case 3:
                        $db->where('project_number','like','%'.$search.'%');
                        break;
                    case 4:
                        $db->where('project_content','like','%'.$search.'%');
                        break;
                    case 5:
                        $db->where('project_manager','like','%'.$search.'%');
                        break;
                }
            }
            $applies = $db->whereIn('project_number',$numberArr)->orderBy('id','DESC')->paginate(10);
        }
        if (!empty($applies)){
            foreach ($applies as $apply){
                $apply->project = Project::where('number','=',$apply->project_number)->first();
            }
        }
        return view('build.finish_list',['applies'=>$applies,'searchType'=>$key,'search'=>$search]);
    }
    public function listPayPage()
    {
        $role = getRole('build_pay_list');
        $key = Input::get('searchType');
        $search = Input::get('search');
//        dd($search);
        if ($role=='all'){
            $db = RequestPayment::where('state','=',3);
            if ($key){
                switch ($key){
                    case 1:
//                        $team_id = Team::where('state','=',1)->orWhere('name','like','%'.$search.'%')->pluck('id')->toArray();
                        $db->where('team','like','%'.$search.'%');
                        break;
                    case 2:
                        $db->where('project_number','like','%'.$search.'%');
                        break;
                    case 3:
                        $db->where('project_content','like','%'.$search.'%');
                        break;
                    case 4:
                        $db->where('project_manager','like','%'.$search.'%');
                        break;
                }
            }
            $id = $db->pluck('project_team')->toArray();
//            dd($id);
            $lists = ProjectTeam::whereIn('id',$id)->orderBy('id','DESC')->paginate(10);
        }else{
            $idArr = getRoleProject('build_pay_list');
            $db = RequestPayment::where('state','=',3);
//            $DB =
            if ($key){
                switch ($key){
                    case 1:
                        $db->where('team','like','%'.$search.'%');
                        break;
                    case 2:
                        $db->where('project_number','like','%'.$search.'%');
                        break;
                    case 3:
                        $db->where('project_content','like','%'.$search.'%');
                        break;
                    case 4:
                        $db->where('project_manager','like','%'.$search.'%');
                        break;
                }
            }
            $id = $db->pluck('project_team')->toArray();
            $lists = ProjectTeam::whereIn('id',$id)->whereIn('project_id',$idArr)->orderBy('id','DESC')->paginate(10);
        }
        if (!empty($lists)){
            foreach ($lists as $list){
                $list->project = Project::where('number','=',$list->project_number)->first();
            }
        }
        return view('build.pay_list',['lists'=>$lists,'searchType'=>$key,'search'=>$search]);
    }
    public function listGetPage()
    {
        $role = getRole('build_invoice_list');
        $key = Input::get('searchType');
        $search = Input::get('search');
        $finish = Input::get('finish');
        if ($role == 'all'){
            $db = RequestPayment::where('state','=',3);
//            $DB =
            if ($key){
                switch ($key){
                    case 1:
//                        $team_id = Team::where('state','=',1)->orWhere('name','like','%'.$search.'%')->pluck('id')->toArray();
                        $db->where('team','like','%'.$search.'%');
                        break;
                    case 2:
                        $db->where('project_number','like','%'.$search.'%');
                        break;
                    case 3:
                        $db->where('project_content','like','%'.$search.'%');
                        break;
                    case 4:
                        $db->where('project_manager','like','%'.$search.'%');
                        break;
                }
            }
            $id = $db->pluck('project_team')->toArray();
//            dd($id);
            if ($finish){
                switch ($finish){
                    case 1 :
                        $lists = ProjectTeam::whereIn('id',$id)->where('need_invoice','=',0)->orderBy('id','DESC')->paginate(10);
                        break;
                    case 2:
                        $lists = ProjectTeam::whereIn('id',$id)->where('need_invoice','!=',0)->orderBy('id','DESC')->paginate(10);
                        break;
                }
            }else{
                $lists = ProjectTeam::whereIn('id',$id)->orderBy('id','DESC')->paginate(10);
            }
        }else{
            $idArr = getRoleProject('build_invoice_list');
            $db = RequestPayment::where('state','=',3);
//            $DB =
            if ($key){
                switch ($key){
                    case 1:
                        $db->where('team','like','%'.$search.'%');
                        break;
                    case 2:
                        $db->where('project_number','like','%'.$search.'%');
                        break;
                    case 3:
                        $db->where('project_content','like','%'.$search.'%');
                        break;
                    case 4:
                        $db->where('project_manager','like','%'.$search.'%');
                        break;
                }
            }
            $id = $db->pluck('project_team')->toArray();
            if ($finish){
                switch ($finish){
                    case 1 :
                        $lists = ProjectTeam::whereIn('id',$id)->whereIn('project_id',$idArr)->orderBy('id','DESC')->paginate(10);
                        break;
                    case 2:
                        $lists = ProjectTeam::whereIn('id',$id)->whereIn('project_id',$idArr)->where('need_invoice','!=',0)->orderBy('id','DESC')->paginate(10);
                        break;
                }
            }else{
                $lists = $lists = ProjectTeam::whereIn('id',$id)->whereIn('project_id',$idArr)->orderBy('id','DESC')->paginate(10);
            }

        }

        if (!empty($lists)){
            foreach ($lists as $list){
                $list->invoice_price = $list->invoices()->sum('with_tax');
                $list->project = Project::where('number','=',$list->project_number)->first();
            }
        }
        return view('build.get_list',['lists'=>$lists,'searchType'=>$key,'search'=>$search,'finish'=>$finish]);
    }
    public function finishSinglePage()
    {
        $id = Input::get('id');
        $apply = RequestPayment::find($id);
        $lists = $apply->lists()->get();
        $picture = RequestPaymentPicture::where('payment_id','=',$id)->get();
        return view('build.finish_single',['apply'=>$apply,'lists'=>$lists,'pictures'=>$picture]);
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
        $team = Team::find($projectTeam->team_id);
        $lists = $projectTeam->payments()->where('state','=',3)->get();
        $applies = $projectTeam->applies()->get();
        return view('build.pay_single',['projectTeam'=>$projectTeam,'lists'=>$lists,'applies'=>$applies,'team'=>$team]);
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
        $team = Team::find($projectTeam->team_id);
        return view('build.pay_apply',['projectTeam'=>$projectTeam,'pay'=>$pay,'team'=>$team]);
    }
    public function finishBuildPayApply(Request $post)
    {
        $id = Input::get('team_id');
        DB::beginTransaction();
        try{
            if ($id){
                $pay = BuildPayFinish::find($id);
                $projectTeam = ProjectTeam::find($pay->project_team);
            }else{
                $pay = new BuildPayFinish();
                $pay->project_team = $post->get('project_id');
//                $count = BuildPayFinish::whereDate('created_at', date('Y-m-d',time()))->count();
                $count = getRedisData('SGFK');
                $pay->number = 'SGFK'.date('Ymd',time()).sprintf("%03d", $count+1);
                setRedisData('SGFK',$count+1,getRedisTime());
                $projectTeam = ProjectTeam::find($pay->project_team);
                $projectTeam->pay_price += $post->get('price');
                $projectTeam->need_price = $projectTeam->price-$projectTeam->pay_price;
                $projectTeam->save();
            }
            $pay->apply_date = $post->get('date');
//            $price = $projectTeam->payments()->where('state','=',3)->sum('price')-$projectTeam->applies()->where('state','=',4)->sum('apply_price');
//            if ($price<$post->get('price')){
//                return response()->json([
//                    'code'=>'400',
//                    'msg'=>'不能超过剩余应付帐款！'
//                ]);
//            }
            $price = $projectTeam->payments()->where('state','=',3)->sum('price')-$projectTeam->applies()->where('state','=',3)->sum('apply_price');
            if ($price<$post->get('price')){
                return response()->json([
                    'code'=>'400',
                    'msg'=>'不能超过请款金额！'
                ]);
            }
            $pay->apply_price = $post->get('price');
            $pay->payee = $post->get('payee');
            $pay->bank = $post->get('bank');
            $pay->account = $post->get('account');
            $pay->worker = Auth::user()->username;
            $pay->worker_id = Auth::id();
            DB::commit();
            if ($pay->save()){
                return response()->json([
                    'code'=>'200',
                    'msg'=>'SUCCESS',
                    'data'=>[
                        'id'=>$pay->id
                    ]
                ]);
            }
        }catch (\Exception $exception){
            DB::rollback();
//            dd($exception);
            return response()->json([
                'code'=>'400',
                'msg'=>'数据出错，请核对数据！'
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
                $task->title = '施工付款申请复核';
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
                $task->title = '施工付款申请审批';
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
                'msg'=>'当前状态不允许审批！'
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
    public function payAddDelete()
    {
        $id = Input::get('id');
        $pay = BuildPayFinish::find($id);
        if ($pay->state==4){
            return redirect()->back()->with('status','当前状态不能删除！');
        }
        $pay->delete();
        Task::where('type','=','build_pay_pass')->where('content','=',$id)->delete();
        Task::where('type','=','build_finish_pass')->where('content','=',$id)->delete();
        return redirect()->back()->with('status','删除成功！');
    }
    public function payAdd(Request $post)
    {
        $id = $post->get('apply_id');
        $pay = BuildPayFinish::find($id);
        if ($pay->state<3){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态不允许录入!'
            ]);
        }
        if ($pay->state==4){
            $pay->remark = $post->get('remark');
            $pay->save();
        }else{
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
        }

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
//        dd($lists);
        if (!empty($lists)){
            foreach ($lists as $list){
                $tax = isset($list['tax'])?$list['tax']:0;
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
                $invoice->with_tax = $list['without_tax']+$tax;
                $invoice->tax = $tax;
                $invoice->save();
            }
            $projectTeam = ProjectTeam::find($post->get('pay_id'));
            if (!empty($projectTeam)){
                $projectTeam->need_invoice = $projectTeam->payments()->where('state','>=',3)->sum('price')-$projectTeam->invoices()->sum('with_tax')>0?1:0;
                $projectTeam->save();
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
        $id = Input::get('id');
        $team = ProjectTeam::find($id);
        $info = Team::find($team->team_id);
        $payments = $team->payments()->where('state','=',3)->get();
        $applies = $team->applies()->where('passer_id','!=',0)->get();
//        $count = count($applies)>count($payments)?count($applies):count($payments);
        return view('build.pay_print',['team'=>$team,'payments'=>$payments,'applies'=>$applies,'info'=>$info]);
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
        $id = Input::get('id');
        $invoice = BuildInvoice::find($id);
//        dd($invoice);
        $invoices = Invoice::where('state','=',1)->select(['id','name'])->get()->toArray();
//        $invoices = array_column($invoices,'name');
//        dd($invoices);
        return view('build.get_edit',['invoice'=>$invoice,'invoices'=>$invoices]);
    }
    public function editBuildGet(Request $post)
    {
//        DB::begin?
        $id = $post->id;
        if (!$id){
            return redirect()->back()->with('status','参数错误！');
        }
        $invoice = BuildInvoice::find($id);
        $invoice->date = $post->get_date?$post->get_date:$invoice->date;
        $invoice->worker = $post->worker?$post->worker:$invoice->worker;
        $invoice->invoice_date = $post->invoice_date?$post->invoice_date:$invoice->invoice_date;
        $type = Invoice::where('name','=',$post->type)->where('state','=',1)->first();
        $invoice->type = $post->type?$post->type:$invoice->type;
        $invoice->type_id = $type?$type->id:$invoice->type_id;
        $invoice->without_tax = $post->amount_without_tax?$post->amount_without_tax:$invoice->without_tax;
        $invoice->tax = $post->tax?$post->tax:$invoice->tax;
        $invoice->with_tax = $invoice->without_tax+$invoice->tax;
        if ($invoice->save()){
            $projectTeam = ProjectTeam::find($invoice->project_team);
            if (!empty($projectTeam)){
                $projectTeam->need_invoice = $projectTeam->payments()->where('state','>=',3)->sum('price')-$projectTeam->invoices()->sum('with_tax')>0?1:0;
                $projectTeam->save();
            }
            return redirect()->back()->with('status','修改成功！');
        }
    }
    public function detailDealPage()
    {
        $id = Input::get('id');
        $contract = ConstructionContract::find($id);
        $pictures = $contract->lists()->get();
        return view('build.detail_single',['pictures'=>$pictures]);
    }
    public function editFinishPage()
    {
        $id = Input::get('id');
        $apply = RequestPayment::find($id);
        $apply->lists  = $apply->lists()->get();
//        dd($apply);
        $apply->build_name = $apply->team;
        $apply->build_manager = $apply->manager;
        $apply->date = $apply->request_date;
        $apply->project_id = Project::where('number','=',$apply->project_number)->pluck('id')->first();
        $apply->pictures = $apply->pictures()->get();
//        dd($apply);
//        $lists = $apply->lists()->get();
        return view('build.finish_edit',['apply'=>$apply]);
    }
    public function listDealPicturesPage()
    {
        $id = Input::get('id');
        $contract = ConstructionContract::find($id);
        $pictures = $contract->lists()->get();
//        dd($pictures);
        return view('build.pictures',['contract'=>$contract,'pictures'=>$pictures]);
    }

}
