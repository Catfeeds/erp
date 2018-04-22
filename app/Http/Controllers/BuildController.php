<?php

namespace App\Http\Controllers;

use App\Models\ConstructionContract;
use App\Models\RequestPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class BuildController extends Controller
{
    //
    public function listBuildPage()
    {
        $list = RequestPayment::paginate();
        return view('build.list',['lists'=>$list]);
    }
    public function addDealPage()
    {
        return view('build.deal_add');
    }
    public function listDealPage()
    {
        $lists = ConstructionContract::paginate(10);
        return view('build.deal_list',['lists'=>$lists]);
    }
    public function createFinishPage()
    {
        return view('build.finish_add');
    }
    public function listFinishPage()
    {
        $applies = RequestPayment::paginate(10);
        return view('build.finish_list',['applies'=>$applies]);
    }
    public function listPayPage()
    {
        return view('build.pay_list');
    }
    public function listGetPage()
    {
        return view('build.get_list');
    }
    public function finishSinglePage()
    {
        $id = Input::get('id');
        $apply = RequestPayment::find($id);
        return view('build.finish_single',['apply'=>$apply]);
    }
}
