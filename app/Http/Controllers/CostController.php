<?php

namespace App\Http\Controllers;

use App\Cost;
use App\CostPicture;
use App\Models\BankAccount;
use App\Models\CostAllow;
use App\Models\CostInvoice;
use App\Models\CostPay;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Supplier;
use App\Models\Task;
use App\PayType;
use App\PayTypeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Mockery\Exception;

class CostController extends Controller
{
    //
    public function addPayTypePage()
    {
        $id = Input::get('id');
        if ($id){
            $type = PayType::find($id);
            $details = PayTypeDetail::where('type_id','=',$type->id)->where('state','=',1)->pluck('title')->toArray();
            $data = [
                'id'=>$type->id,
                'title'=>$type->title,
                'details'=>$details
            ];
            return view('cost.type_add',['editData'=>$data]);
        }else{
            return view('cost.type_add',['editData'=>[]]);
        }
    }
    public function addPayType(Request $post)
    {
        $id = $post->id?$post->id:0;
        $details = $post->details;
        if ($id){
            $type = PayType::findOrFail($id);
        }else{
            $type = new PayType();
        }
        $type->title = $post->title;
        if ($type->save()){
            if (!empty($details)){
                PayTypeDetail::where('type_id','=',$type->id)->update(['state'=>0]);
                for ($i=0 ; $i<count($details);$i++ ){
                    $detail = new PayTypeDetail();
                    $detail->type_id = $type->id;
                    $detail->title = $details[$i];
                    $detail->save();
                }
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>"SUCCESS"
        ]);
    }
    public function listPayTypePage()
    {
        $types = PayType::where('state','=',1)->orderBy('id','DESC')->paginate(10);
        foreach ($types as $type){
            $details = PayTypeDetail::where('state','=',1)->where('type_id','=',$type->id)->orderBy('id','desc')->pluck('title')->toArray();
            $type->details = implode('/',$details);
        }
        return view('cost.type_list',['types'=>$types]);
    }
    public function delPayType()
    {
        $id = Input::get('id');
        $type = PayType::findOrFail($id);
        $type->state = 0;
        $type->save();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }

    public function addPayPage()
    {
        $id = Input::get('id');
        $types = Invoice::where('state','=',1)->get();
        if ($id){
            $cost = Cost::find($id);
            $pictures = CostPicture::where('request_id','=',$id)->get();
            $project = Project::find($cost->project_id);
            $supplier = Supplier::find($cost->supplier_id);
            $data = [
                'id'=>$id,
                'apply_date'=>$cost->apply_date,
                'apply_price'=>$cost->apply_price,
                'application'=>$cost->application,
                'project_id'=>$cost->project_id,
                'project_number'=>empty($project)?'':$project->number,
                'project_content'=>empty($project)?'':$project->name,
                'pay_detail'=>intval($cost->pay_detail),
                'remark'=>$cost->remark,
                'invoice_type'=>intval($cost->invoice_type),
                'type'=>intval($cost->type),
                'supplier_id'=>$cost->supplier_id,
                'payee'=>$supplier->name,
                'pay_type'=>intval($cost->pay_type),
                'currentSupplier'=>$supplier,
                'pictures'=>$pictures
            ];
//            dd($data);
            // const addEdit = {
            //   apply_date: '2018-02-11',
            //   apply_price: 22222,
            //   application: 'zheshiyongtu',
            //   project_id: 1,
            //   project_number: 'XM1232132100123',
            //   project_content: 'name',
            //   pay_detail: 1,
            //   remark: 'beizhu',
            //   invoice_type: 1,
            //   type: 1,
            //   supplier_id: 1,
            //   payee: 'gongyingshang',
            //   pay_type: 1,

            //   // 记得加这个结构，把当前的 payee 顺便塞到这个对象
            //   currentSupplier: {
            //     id: 1,
            //     name: 'name',
            //     bank: 'bank',
            //     account: 'account'
            //   },

            //   pictures: [{
            //     id: 1,
            //     name: 'tupian',
            //     url: 'http://www.baidu.jpg'
            //   }]
            // }
            return view('cost.add',['types'=>$types,'data'=>$data]);
        }else{
            return view('cost.add',['types'=>$types,'data'=>[]]);
        }
    }
    public function addPay(Request $post)
    {
        $id = $post->id?$post->id:0;
        $count = getRedisData('FK');
        if($id){
            $cost = Cost::find($id);
        }else{
            $cost = new Cost();
            $cost->number = 'FK'.date('Ymd',time()).sprintf("%03d", $count+1);
            setRedisData('FK',$count+1,getRedisTime());
        }
        if (empty($post->apply_price)){
            return response()->json([
                'msg'=>'请先录入数据',
                'code'=>'404'
            ]);
        }
        $cost->project_id = $post->project_id?$post->project_id:0;
        $cost->apply_date = $post->apply_date?$post->apply_date:'';
        $cost->apply_price = $post->apply_price?$post->apply_price:0;
        $cost->supplier_id = $post->supplier_id?$post->supplier_id:0;
        $cost->pay_type = $post->pay_type?$post->pay_type:0;
        $cost->pay_detail = $post->pay_detail?$post->pay_detail:0;
        $cost->application = $post->application?$post->application:'';
        $cost->remark = $post->remark?$post->remark:'';
        $cost->type = $post->type?$post->type:0;
        $cost->invoice_type = $post->invoice_type?$post->invoice_type:0;
        $cost->proposer_id = Auth::id();
        $cost->proposer = Auth::user()->name;
        if ($cost->save()){
            $pictures = $post->pictures;
            if (!empty($pictures)){
                CostPicture::where('request_id','=',$cost->id)->delete();
                foreach ($pictures as $picture){
                    $costPicture = new CostPicture();
                    $costPicture->request_id = $cost->id;
                    $costPicture->name = $picture['name'];
                    $costPicture->url = $picture['url'];
                    $costPicture->save();
                }
            }
            return response()->json([
                'msg'=>'SUCCESS',
                'code'=>'200',
                'data'=>[
                    'id'=>$cost->id
                ]
            ]);
        }
    }
    public function searchPayTypes()
    {
        $title = Input::get('title');
        $types = PayType::where('title','like','%'.$title.'%')->where('state','=',1)->get();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$types
        ]);
    }
    public function searchPayDetails()
    {
        $id = Input::get('id');
        if (!$id){
            return response()->json([
                'msg'=>'ID不能为空！',
                'code'=>'400'
            ]);
        }
        $title = Input::get('title');
        $details = PayTypeDetail::where('type_id','=',$id)->where('state','=',1)->where('title','like','%'.$title.'%')->select(['id','title'])->get();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$details
        ]);
    }
    public function listPayPage()
    {
        $searchType = Input::get('search-type');
        $searchValue = Input::get('value');
        $finish = Input::get('finish',0);
        $role = getRole('pay_list');
        $db = DB::table('costs');
        if ($role=='all'){
            if ($finish){
                switch ($finish){
                    case 1:
                        $db->where('need_invoice','!=',1)->orWhere('need_pay','!=',1);
                        break;
                    case 2:
                        $idArray = Cost::where('need_invoice','!=',1)->where('need_pay','!=',1)->pluck('id')->toArray();
                        $db->whereNotIn('id',$idArray);
                        break;
                }
            }
            if ($searchType){
                switch ($searchType){
                    case 1:
                        $db->where('number','like','%'.$searchValue.'%');
                        break;
                    case 2:
                        $projectId = Project::where('number','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('project_id',$projectId);
                        break;
                    case 3:
                        $projectId = Project::where('name','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('project_id',$projectId);
                        break;
                    case 4:
                        $db->where('proposer','like','%'.$searchValue.'%');
                        break;
                    case 5:
                        $db->where('approver','like','%'.$searchValue.'%');
                        break;
                    case 6:
                        $suppliersId = Supplier::where('name','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('supplier_id',$suppliersId);
                        break;
                    case 7:
                        $types = PayType::where('title','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('pay_type',$types);
                        break;
                    case 8:
                        $details = PayTypeDetail::where('title','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('pay_detail',$details);
                        break;
                    case 9:
                        $db->where('application','like','%'.$searchValue.'%');
                        break;
                }
            }

        }elseif($role=='only'){
            $db->where('proposer','=',Auth::user()->username);
            if ($finish){
                switch ($finish){
                    case 1:
                        $db->where('need_invoice','!=',1)->Where('need_pay','!=',1);
                        break;
                    case 2:
                        $idArray = Cost::where('need_invoice','!=',1)->where('need_pay','!=',1)->pluck('id')->toArray();
                        $db->whereNotIn('id',$idArray);
                        break;
                }
            }
            if ($searchType){
                switch ($searchType){
                    case 1:
                        $db->where('number','like','%'.$searchValue.'%');
                        break;
                    case 2:
                        $projectId = Project::where('number','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('project_id',$projectId);
                        break;
                    case 3:
                        $projectId = Project::where('name','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('project_id',$projectId);
                        break;
                    case 4:
                        $db->where('proposer','like','%'.$searchValue.'%');
                        break;
                    case 5:
                        $db->where('approver','like','%'.$searchValue.'%');
                        break;
                    case 6:
                        $suppliersId = Supplier::where('name','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('supplier_id',$suppliersId);
                        break;
                    case 7:
                        $types = PayType::where('title','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('pay_type',$types);
                        break;
                    case 8:
                        $details = PayTypeDetail::where('title','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('pay_detail',$details);
                        break;
                    case 9:
                        $db->where('application','like','%'.$searchValue.'%');
                        break;
                }
            }
        }else{
            $idArr = getRoleProject('pay_list');
            $db->whereIn('project_id',$idArr);
            if ($finish){
                switch ($finish){
                    case 1:
                        $db->where('need_invoice','=',0)->where('need_pay','=',0);
                        break;
                    case 2:
                        $idArray = Cost::where('need_invoice','!=',1)->where('need_pay','!=',1)->pluck('id')->toArray();
                        $db->whereNotIn('id',$idArray);
                        break;
                }
            }
            if ($searchType){
                switch ($searchType){
                    case 1:
                        $db->where('number','like','%'.$searchValue.'%');
                        break;
                    case 2:
                        $projectId = Project::where('number','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('project_id',$projectId);
                        break;
                    case 3:
                        $projectId = Project::where('name','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('project_id',$projectId);
                        break;
                    case 4:
                        $db->where('proposer','like','%'.$searchValue.'%');
                        break;
                    case 5:
                        $db->where('approver','like','%'.$searchValue.'%');
                        break;
                    case 6:
                        $suppliersId = Supplier::where('name','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('supplier_id',$suppliersId);
                        break;
                    case 7:
                        $types = PayType::where('title','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('pay_type',$types);
                        break;
                    case 8:
                        $details = PayTypeDetail::where('title','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('pay_detail',$details);
                        break;
                    case 9:
                        $db->where('application','like','%'.$searchValue.'%');
                        break;
                }
            }

        }


        $data = $db->orderBy('id','DESC')->paginate(10);
//        dd($data);
        return view('cost.list',['type'=>$searchType,'value'=>$searchValue,'costs'=>$data,'finish'=>$finish]);
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
                $task->number = Cost::find($id)->number;
                $task->url = 'new/pay/single?id='.$id;
                $task->content = $id;
                $task->save();
                $allow = new CostAllow();
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
    public function paySingle()
    {
        $id = Input::get('id');
        $cost = Cost::find($id);
        $pictures = CostPicture::where('request_id','=',$id)->get();
        $pays = CostPay::where('cost_id','=',$id)->get();
        $invoices = CostInvoice::where('cost_id','=',$id)->get();
        return view('cost.single',['cost'=>$cost,'pictures'=>$pictures,'pays'=>$pays,'invoices'=>$invoices]);
    }
    public function delCost()
    {
        $id = Input::get('id');
        $cost = Cost::find($id);
        if ($cost->state !=1){
            return response()->json([
                'code'=>'400',
                'msg'=>'当前状态不允许删除！'
            ]);
        }
        $number = $cost->number;
        if ($cost->delete()){
            CostPicture::where('request_id','=',$id)->delete();
            CostPay::where('cost_id','=',$id)->delete();
            CostInvoice::where('cost_id','=',$id)->delete();
            Task::where('number','=',$number)->delete();
            CostAllow::where('apply_id','=',$id)->delete();
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function confirmCost()
    {
        $id = Input::get('id');
        $apply = Cost::find($id);
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
    public function costPayPage()
    {
        $id = Input::get('id');
        $cost = Cost::find($id);
        $pays = CostPay::where('cost_id','=',$id)->get();
        if (count($pays)!=0){
            foreach ($pays as $pay){
                $pay->bank = intval($pay->bank);
            }
        }
        $banks = BankAccount::where('state','=',1)->get()->toArray();
        array_push($banks,[
            'id'=>0,
            'name'=>' ',
            'account'=>'',
            'state'=>1,
            'created_at'=>'',
            'updated_at'=>''
        ]);
        return view('cost.pay',['cost'=>$cost,'banks'=>$banks,'pays'=>$pays]);
    }
    public function costPay(Request $post)
    {
        $request_id = $post->request_id;
        $lists = $post->lists;
        $cost =  Cost::find($request_id);
        if ($cost->state ==1){
            return response()->json([
                'code'=>'400',
                'msg'=>'未审批的付款！'
            ]);
        }
        DB::beginTransaction();
        try{
            CostPay::where('cost_id','=',$request_id)->delete();
            foreach ($lists as $list){
                if (!isset($list['bank'])&&$list['transfer']!=0){
                    throw new Exception('请先选择付款银行！');
                }
                $pay = new CostPay();
                $pay->cost_id = $request_id;
                $pay->project_id = $cost->project_id;
                $pay->pay_date = $list['pay_date'];
                $pay->cash = isset($list['cash'])?$list['cash']:0;
                $pay->transfer = isset($list['transfer'])?$list['transfer']:0;
                $pay->other = isset($list['other'])?$list['other']:0;
                $pay->cost = $pay->cash+$pay->other+$pay->transfer;
                $pay->bank = isset($list['bank'])?$list['bank']:0;
                $pay->worker_id = isset($list['worker_id'])?$list['worker_id']:Auth::id();
                $pay->worker = isset($list['worker'])?$list['worker']:Auth::user()->username;
                $pay->save();
            }
            $sum = CostPay::where('cost_id','=',$request_id)->sum('cost');
            if ($sum>$cost->apply_price){
                throw new Exception('不能超过申请金额！');
            }
            $cost->state = 3;
            if ($sum==$cost->apply_price){
                $cost->need_pay = 0;
                $cost->save();
            }else{
                $cost->need_pay = 1;
                $cost->save();
            }
            DB::commit();
            return response()->json([
                'msg'=>'SUCCESS',
                'code'=>'200'
            ]);
        }catch (Exception $exception){
            DB::rollback();
            return response()->json([
                'msg'=>$exception->getMessage(),
                'code'=>'400'
            ]);
        }
    }
    public function costInvoicePage()
    {
        $cost = Cost::find(Input::get('id'));
        $invoices = Invoice::select(['id','name'])->where('state','=',1)->get();
        $lists = CostInvoice::where('cost_id','=',$cost->id)->get();
        $data = [];
        if (count($lists)!=0){
            $date = $lists[0]->date;
            foreach ($lists as $list){
                $list->date = $list->invoice_date;
                $list->type = intval($list->type);
            }
            $data = [
                'date'=>$date,
                'pay_id'=>0,
                'purchase_id'=>$lists[0]->cost_id,
                'lists'=>$lists
            ];
        }
        // const invoiceEdit = {
        //   date: '2018-01-11', //收票日期
        //   pay_id: '',
        //   purchase_id: 1,
        //   lists: [{
        //     id: 1,
        //     date: '2018-01-11',
        //     number: '123123123',
        //     type: 1,
        //     without_tax: 123,
        //     tax: 21,
        //     with_tax: 12
        //   }]
        // }
        return view('cost.invoice',['invoices'=>$invoices,'cost'=>$cost,'data'=>$data]);
    }
    public function costInvoice(Request $post)
    {
        $lists = $post->lists;
//        dd($lists);
        $cost_id = $post->purchase_id;
        $cost =  Cost::find($cost_id);
        if ($cost->state ==1){
            return response()->json([
                'code'=>'400',
                'msg'=>'未审批的付款！'
            ]);
        }
        $date = $post->date;
        DB::beginTransaction();
        try{
            CostInvoice::where('cost_id','=',$cost_id)->delete();
            foreach ($lists as $list){
                $invoice = new CostInvoice();
                $invoice->cost_id = $cost_id;
                $invoice->date = $date;
                $invoice->invoice_date = $list['date'];
                $invoice->number = $list['number'];
                $invoice->type = $list['type'];
                $invoice->without_tax = $list['without_tax'];
                $invoice->tax = $list['tax'];
                $invoice->with_tax = $invoice->tax+$invoice->without_tax;
                $invoice->worker_id = Auth::id();
                $invoice->worker = Auth::user()->username;
                $invoice->save();
            }
            $sum = CostInvoice::where('cost_id','=',$cost_id)->sum('with_tax');
            if ($sum>=$cost->apply_price){
                $cost->need_invoice = 0;
                $cost->save();
            }else{
                $cost->need_invoice = 1;
                $cost->save();
            }
            DB::commit();
            return response()->json([
                'msg'=>'SUCCESS',
                'code'=>'200'
            ]);
        }catch (Exception $exception){
            DB::rollback();
            return response()->json([
                'msg'=>$exception->getMessage(),
                'code'=>'400'
            ]);
        }
    }
    public function printCost()
    {
        $id = Input::get('id');
        $cost = Cost::find($id);
        $pictures = CostPicture::where('request_id','=',$id)->get();
        $pays = CostPay::where('cost_id','=',$id)->get();
        $invoices = CostInvoice::where('cost_id','=',$id)->get();
        return view('cost.print',['cost'=>$cost,'pictures'=>$pictures,'pays'=>$pays,'invoices'=>$invoices]);
    }
}
