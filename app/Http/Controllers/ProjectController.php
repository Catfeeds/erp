<?php

namespace App\Http\Controllers;

use App\Http\Requests\BudgetPost;
use App\Http\Requests\CreateProjectPost;
use App\Models\Budget;
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
        if (isset($projectData['id'])){
            $project = new Project();
        }else{
            $project = Project::find($projectData['id']);
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
