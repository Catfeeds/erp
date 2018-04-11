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
    public function listDealPage()
    {
        return view('build.deal_list');
    }
    public function listFinishPage()
    {
        return view('build.finish_list');
    }
    public function listPayPage()
    {
        return view('build.pay_list');
    }
}