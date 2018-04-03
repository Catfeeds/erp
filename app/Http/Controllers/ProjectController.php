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
use App\Models\TaxRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ProjectController extends Controller
{
    //
    public function searchProject()
    {
        $number = Input::get('id');
        $name = Input::get('name');
        $DbObj = DB::table('projects');
        if ($number){
            $DbObj->where('number','like','%'.$number.'%');
        }
        if ($name){
            $DbObj->where('name','like','%'.$name.'%');
        }
        $data = $DbObj->get();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$data
        ]);

    }
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
            $rates = TaxRate::select(['id','rate as name'])->get()->toArray();
            return view('project.create',['types'=>$types,'rates'=>$rates]);
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
    public function createProject(Request $post)
    {
        $projectData = $post->get('project');
        if (!empty($projectData)){
            if (isset($projectData['id'])){
                $project = Project::find($projectData['id']);
            }else{
                $project = new Project();
                $count = Project::whereDate('created_at', date('Y-m-d',time()))->count();;
                $project->number = 'XM'.date('Ymd',time()).sprintf("%03d", $count);
            }
            $project->name = $projectData['name'];
            $project->PartyA = $projectData['PartyA'];
            $project->price = $projectData['price'];
            $project->finishTime = strtotime($projectData['finishTime']);
            $project->pm = $projectData['pm'];
            $project->createTime = strtotime($projectData['createTime']);
            $project->condition = $projectData['condition'];
            $project->save();
        }
        $mainContracts = $post->get('mainContracts');
        if (!empty($mainContracts)){
            foreach ($mainContracts as $mainContract){
                if (isset($mainContract['id'])){
                    $contract = MainContract::find($mainContract['id']);
                    if (empty($contract)){
                        $contract = new MainContract();
                        $contract->project_id = $project->id;
                    }
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
                    if (empty($out_contract)){
                        $out_contract = new OutContract();
                        $out_contract->project_id = $project->id;
                    }
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
                    if (empty($situ)){
                        $situ = new ProjectSituations();
                        $situ->project_id = $project->id;
                    }
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
                $receipt->ratio = $item['radio'];
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
                    if (empty($picture)){
                        $picture = new ProjectPicture();
                        $picture->project_id = $project->id;
                    }
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
    public function listProjectsDetail()
    {
        $project = Project::paginate();
        return view('project.detail',['projects'=>$project]);
    }
    public function addBudgetPage()
    {
        $project_id = Input::get('project_id');
        $project = Project::find($project_id);
        $types = ProjectType::select(['id','name'])->get()->toArray();
        return view('budget.create',['project'=>$project,'types'=>$types]);
    }
    public function addBudget(Request $budgetPost)
    {
        $project_id = $budgetPost->get('project_id');
        $budgets = $budgetPost->get('budgets');
        if (!empty($budgets)){
            foreach ($budgets as $item){
                $budget = new Budget();
                $budget->project_id = $project_id;
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
    public function listBudgetsPage()
    {
        $project = Project::first();
        return view('budget.list');
    }


    public function outputBudget()
    {

    }
    public function importBudget()
    {

    }

}
