<?php

namespace App\Http\Controllers;

use App\Http\Requests\BudgetPost;
use App\Http\Requests\CreateProjectPost;
use App\Models\Budget;
use App\Models\MainContract;
use App\Models\OutContract;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ProjectController extends Controller
{
    //
    public function addProject()
    {

    }
    public function createProjectPage()
    {
        return view('project.create');
    }
    public function listProject()
    {
        $number = Input::get('number');
        $name = Input::get('name');
        $projectDb = DB::table('projects');
        if ($number){
            $projectDb->where('number','=',$number);
        }
        if ($name){
            $projectDb->where('name','like','%'.$name.'%');
        }
        $projects = $projectDb->paginate(10);
        return view('project.list',$projects);
    }
    public function createProject(CreateProjectPost $post)
    {
        $projectData = $post->get('project');
        if (!empty($projectData)){
            if (isset($projectData['id'])){
                $project = new Project();
                $count = Project::where('date')->count();
                $project->number = 'XM'.date('Yms',time()).sprintf("%03d", $count);
            }else{
                $project = Project::find($projectData['id']);
            }
            $project->name = $post->get('name');
            $project->PartyA = $post->get('PartyA');
            $project->price = $post->get('price');
            $project->finishTime = strtotime($post->get('finishTime'));
            $project->pm = $post->get('pm');
            $project->createTime = strtotime($post->get('createTime'));
            $project->condition = $post->get('condition');
            $project->save();
        }
        $mainContracts = $post->get('mainContracts');
        if (!empty($mainContracts)){
            foreach ($mainContracts as $mainContract){
                if (isset($mainContract['id'])){
                    $contract = MainContract::find($mainContract['id']);
                    $contract->project_id = $project->id;
                }else{
                    $contract = new MainContract();
                }
                $contract->unit = $mainContract['unit'];
                $contract->price = $mainContract['price'];
                $contract->remark = $mainContract['remark'];
                $contract->save();
            }
        }
        $outContracts = $post->get('outContracts');
        if (!empty($outContracts)){
            foreach ($outContracts as $outContract){
                if (isset($outContract['id'])){
                    $out_contract = OutContract::find($outContract['id']);
                    $out_contract->project_id = $project->id;
                }else{
                    $out_contract = new OutContract();
                }
                $out_contract->unit = $outContract['unit'];
                $out_contract->price = $outContract['price'];
                $out_contract->remark = $outContract['remark'];
                $out_contract->save();
            }
        }

        return response()->json([
            'dd'
        ]);
    }
    public function addBudget(BudgetPost $budgetPost)
    {
        $budget = new Budget();
    }
    public function addBudgetPage()
    {

    }

    public function outputBudget()
    {

    }
    public function importBudget()
    {

    }

}
