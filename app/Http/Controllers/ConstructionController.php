<?php

namespace App\Http\Controllers;

use App\Models\ConstructionContract;
use App\Models\ConstructionContractList;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;

class ConstructionController extends Controller
{
    //
    public function addContract(Request $post)
    {
        $lists = $post->get('lists');
        $contract = new ConstructionContract();
        $team = Team::find($post->get('team'));
        $contract->date = $post->get('date');
        $contract->team = $team->name;
        $contract->manager = $team->manager;
        $project = Project::find($post->get('project_id'));
        $contract->project_number = $project->number;
        $contract->project_content = $project->name;
        $contract->project_manager = $project->pm;
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
