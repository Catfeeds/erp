<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\PayType;
use App\PayTypeDetail;
use Illuminate\Http\Request;
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
}
