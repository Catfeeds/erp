<?php

namespace App\Http\Controllers;

use App\Http\Requests\BudgetPost;
use App\Http\Requests\CreateProjectPost;
use App\Models\Bail;
use App\Models\Budget;
use App\Models\MainContract;
use App\Models\OutContract;
use App\Models\Project;
use App\Models\ProjectPicture;
use App\Models\ProjectSituations;
use App\Models\ProjectType;
use App\Models\Receipt;
use App\Models\SituationList;
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
        $id = Input::get('id');
        if ($id){
            $project = Project::find($id);
            dd($project);
        }else{
            $types = ProjectType::select(['id','name'])->get()->toArray();
            return view('project.create',['types'=>$types]);
        }
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
        return view('project.list',['projects'=>$projects]);
    }
    public function createProject(CreateProjectPost $post)
    {
        $projectData = $post->get('project');
        if (!empty($projectData)){
            if (isset($projectData['id'])){
                $project = Project::find($projectData['id']);
            }else{
                $project = new Project();
                $count = Project::where('date')->count();
                $project->number = 'XM'.date('Yms',time()).sprintf("%03d", $count);
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
                }else{
                    $contract = new MainContract();
                    $contract->project_id = $project->id;
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
                }else{
                    $out_contract = new OutContract();
                    $out_contract->project_id = $project->id;
                }
                $out_contract->unit = $outContract['unit'];
                $out_contract->price = $outContract['price'];
                $out_contract->remark = $outContract['remark'];
                $out_contract->save();
            }
        }
        $situations = $post->get('situations');
        if (!empty($situations)){
            foreach($situations as $situation){
                if (isset($situation['id'])){
                    $situ = ProjectSituations::find($situation['id']);
                }else{
                    $situ = new ProjectSituations();
                    $situ->project_id = $project->id;
                }
                $situ->price = $situation['price'];
                $situ->type = $situation['type'];
                $situ->is_main = $situation['is_main'];
                $situ->save();
                if (!empty($situation['lists'])){
                    foreach ($situation['lists'] as $list){
                        if (isset($list['id'])){
                            $lis = SituationList::find($list['id']);
                        }else{
                            $lis = new SituationList();
                            $lis->situation_id = $situ->id;
                        }
                        $lis->name = $list['name'];
                        $lis->tax = $list['tax'];
                        $lis->price = $list['price'];
                        $lis->remark = $list['remark'];
                        $lis->save();
                    }
                }
            }
        }
        $bails = $post->get('bails');
        if (!empty($bails)){
            foreach ($bails as $item){
                if (isset($item['id'])){
                    $bail = Bail::find($item['id']);
                }else{
                    $bail = new Bail();
                    $bail->project_id = $project->id;
                }
                $bail->unit = $item['unit'];
                $bail->price = $item['price'];
                $bail->term = $item['term'];
                $bail->cost = $item['cost'];
                $bail->other = $item['other'];
                $bail->pay_date = $item['pay_date'];
                $bail->pay_price = $item['pay_price'];
                $bail->payee = $item['payee'];
                $bail->bank = $item['bank'];
                $bail->bank_account = $item['bank_account'];
                $bail->condition = $item['condition'];
                $bail->save();
            }
        }
        $receipts = $post->get('receipts');
        if (!empty($receipts)){
            foreach ($receipts as $item){
                if (isset($item['id'])){
                    $receipt = Receipt::find($item['id']);
                }else{
                    $receipt = new Receipt();
                    $receipt->project_id = $project->id;
                }
                $receipt->ratio = $item['ratio'];
                $receipt->price = $item['price'];
                $receipt->condition = $item['condition'];
                $receipt->save();
            }
        }
        $pictures = $post->get('pictures');
        if (!empty($pictures)){
            foreach ($pictures as $item){
                if (isset($item['id'])){
                    $picture = ProjectPicture::find($item['id']);
                }else{
                    $picture = new ProjectPicture();
                    $picture->project_id = $project->id;
                }
                $picture->url = $item['url'];
                $picture->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function addBudget(Request $budgetPost)
    {
        $budgets = $budgetPost->get('budgets');
        if (!empty($budgets)){
            foreach ($budgets as $item){
                $budget = new Budget();
                $budget->project_id = $item['project_id'];
                $budget->name = $item['name'];
                $budget->param = $item['param'];
                $budget->brand = $item['brand'];
                $budget->factory = $item['factory'];
                $budget->unit = $item['unit'];
                $budget->price = $item['price'];
                $budget->number = $item['number'];
                $budget->cost = $item['cost'];
                $budget->type = $item['type'];
                $budget->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function delBudget($id)
    {
        $budget = Budget::find($id);
        if ($budget->delete()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
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
