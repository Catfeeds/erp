<?php

namespace App\Http\Controllers;

use App\Models\ConstructionContract;
use App\Models\ConstructionContractList;
use Illuminate\Http\Request;

class ConstructionController extends Controller
{
    //
    public function addContract(Request $post)
    {
        $lists = $post->get('lists');
        $contract = new ConstructionContract();
        $contract->date = $post->get('date');
        $contract->team = $post->get('team');
        $contract->manager = $post->get('manager');
        $contract->project_number = $post->get('project_number');
        $contract->project_content = $post->get('project_content');
        $contract->project_manager = $post->get('project_manager');
        $contract->save();
        foreach ($lists as $item){
            $list = new ConstructionContractList();
            $list->href = $item;
            $list->contract_id = $contract->id;
            $list->save();
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
}
