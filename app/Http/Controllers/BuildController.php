<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuildController extends Controller
{
    //
    public function listBuildPage()
    {
        return view('build.list');
    }
    public function addDealPage()
    {
        return view('build.deal_add');
    }
    public function listDealPage()
    {
        return view('build.deal_list');
    }
    public function createFinishPage()
    {
        return view('build.finish_add');
    }
    public function listFinishPage()
    {
        return view('build.finish_list');
    }
    public function listPayPage()
    {
        return view('build.pay_list');
    }
    public function listGetPage()
    {
        return view('build.get_list');
    }
}
