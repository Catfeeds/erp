<?php

namespace App\Http\Controllers;

use App\Cost;
use App\CostPicture;
use App\Models\CostAllow;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Task;
use App\PayType;
use App\PayTypeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

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
        }else{
            return view('cost.add',['types'=>$types]);
        }
    }
    public function addPay(Request $post)
    {
        $id = $post->id?$post->id:0;
        $count = Cost::whereDate('created_at', date('Y-m-d',time()))->count();
        if($id){
            $cost = Cost::find($id);
        }else{
            $cost = new Cost();
            $cost->number = 'FK'.date('Ymd',time()).sprintf("%03d", $count+1);
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
        $details = PayTypeDetail::where('type_id','=',$id)->where('title','like','%'.$title.'%')->select(['id','title'])->get();
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
        $db = DB::table('costs');
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
            }
        }
        $data = $db->orderBy('id','DESC')->paginate(10);
//        dd($data);
        return view('cost.list',['type'=>$searchType,'value'=>$searchValue,'costs'=>$data]);
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
                $task->url = 'pay/single?id='.$id;
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
        return view('cost.single',['cost'=>$cost]);
    }
}
