<?php

namespace App\Http\Controllers;

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
            $details = PayTypeDetail::where('type_id','=',$type->id)->where('state','=',1)->get();
        }else{
            return view('cost.type_add');
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
            'msg'=>'SICCESS'
        ]);
    }

    public function addPayPage()
    {
        $id = Input::get('id');
        if ($id){

        }else{
            return view('cost.add');
        }
    }

}
