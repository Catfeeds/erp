<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    //
    public function listStockList()
    {
        return view('stock.list');
    }
    public function listBuyList()
    {
        return view('stock.buy_list');
    }
    public function listReturnList()
    {
        return view('stock.return_list');
    }
    public function listGetList()
    {
        return view('stock.get_list');
    }
    public function listOutList()
    {
        return view('stock.out_list');
    }
}
