<?php

namespace App\Http\Controllers;

use App\Models\ConstructionContract;
use App\Models\ProjectTeam;
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
        $id = RequestPayment::where('state','=',3)->pluck('project_team')->toArray();
        $lists = ProjectTeam::whereIn('id',$id)->get();
        return view('build.pay_list',['lists'=>$lists]);
    }
    public function listGetPage()
    {
        return view('build.get_list');
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
        return view('build.pay_single',['projectTeam'=>$projectTeam,'lists'=>$lists]);
    }
}
