<?php

namespace App\Http\Controllers;

use App\Http\Requests\BudgetPost;
use App\Http\Requests\CreateProjectPost;
use App\Models\Bail;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\InvoiceList;
use App\Models\LoanSubmitList;
use App\Models\MainContract;
use App\Models\Material;
use App\Models\OutContract;
use App\Models\Project;
use App\Models\ProjectCollect;
use App\Models\ProjectInvoice;
use App\Models\ProjectPicture;
use App\Models\ProjectRole;
use App\Models\ProjectSituations;
use App\Models\ProjectType;
use App\Models\Purchase;
use App\Models\PurchaseContract;
use App\Models\PurchaseList;
use App\Models\Receipt;
use App\Models\Role;
use App\Models\SituationList;
use App\Models\Supplier;
use App\Models\Task;
use App\Models\TaxRate;
use App\Models\Tip;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Mockery\Exception;

class ProjectController extends Controller
{
    //
    public function searchProject()
    {
        $number = Input::get('id');
        $name = Input::get('name');
        $DbObj = DB::table('projects');
        $type = Input::get('type');
//        $data = $DbObj->get();
//        return response()->json([
//            'code'=>'200',
//            'msg'=>'SUCCESS',
//            'data'=>$data
//        ]);
        if ($type){
            if ($type=='buy_budgetary_edit'||$type=='buy_extrabugetary_edit'||$type=='build_finish_list'||$type=='stock_get_list'||
            $type=='loan_project_submit_edit'||$type=='stock_return_edit'||$type=='pay_add'||$type=='build_contract_edit'){
                if ($number){
                    $DbObj->where('number','like','%'.$number.'%');
                }
                if ($name){
                    $DbObj->where('name','like','%'.$name.'%');
                }
                $data = $DbObj->orderBy('id','DESC')->get();
            }else{
                $idArr = getRoleProject($type);
                $DbObj->whereIn('id',$idArr);
                if ($number){
                    $DbObj->where('number','like','%'.$number.'%');
                }
                if ($name){
                    $DbObj->where('name','like','%'.$name.'%');
                }
                $data = $DbObj->orderBy('id','DESC')->get();
            }

        }else{
            $data = [];
        }

        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$data
        ]);

    }
    public function searchBudget()
    {
        $number = Input::get('project');
        $project = Project::where('number','=',$number)->first();
        if ($project){
            $budgets = $project->budget()->where('type','=',1)->get();
//            $need_cost_count = 0;
//            $budget_cost_count = 0;
//            $buy_cost_count = 0;
            foreach ($budgets as $budget){
                $budget->material = Material::find($budget->material_id);
//                $budget->cost = number_format($budget->cost);
                $budget->price = $budget->price;
//                $purchaseId = Purchase::where()->pluck('');
                $budget->buy_cost = PurchaseList::where('budget_id','=',$budget->id)->where('material_id','=',$budget->material_id)->sum('cost');
                $budget->need_cost = $budget->cost-$budget->buy_cost;
//                $budget_cost_count += $budget->cost;
//                $need_cost_count += $budget->need_cost;
//                $buy_cost_count += $budget->buy_cost;
//                $budget->cost = number_format($budget->cost);
//                $budget->need_cost = number_format($budget->need_cost);
//                $budget->buy_cost = number_format($budget->buy_cost);
            }
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS',
                'data'=>$budgets
                ]);
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>[]
        ]);
    }
    public function searchProjectUnit()
    {
        $id = Input::get('project_id');
        $name = Input::get('payee');
        $type = Input::get('type');
        if ($id){
            $obj = MainContract::where('project_id','=',$id);
            $obj2 = OutContract::where('project_id','=',$id);
        }else{
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS',
                'data'=>[]
            ]);
        }
        if ($name){
            $obj->where('unit','like','%'.$name.'%');
            $obj2->where('unit','like','%'.$name.'%');
        }
        $data = $obj->select('unit')->get()->toArray();
        $data2 = $obj2->select('unit')->get()->toArray();
        $data = array_merge($data,$data2);
        $swap = [];
        for ($i=0;$i<count($data);$i++){
            $swap[$i] = $data[$i]['unit'];
        }
        $swap = array_unique($swap);
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$swap
        ]);
    }
    public function searchProjectMaterial()
    {
        $project_id = Input::get('project_id');
        $data = Budget::where('project_id','=',$project_id)->get();
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
//            $project->mainContract = $project->mainContract()->get();
//            $project->outContract = $project->outContract()->get();
            $project->createTime = date('Y-m-d',$project->createTime);
            $project->finishTime = date('Y-m-d',$project->finishTime);
            $situations = $project->situation()->get();
            foreach ($situations as $situation){
                $situation->lists = $situation->lists()->get();
            }
//            $project->situations = $situations;
//            $project->bails = $project->bail()->get();
//            $project->receipts = $project->receipt()->get();
//            $project->pictures = $project->picture()->get();
//            return response()->json($project);
            $types =ProjectType::select(['id','name','rate'])->where('state','=',1)->get()->toArray();
            $rates = ProjectType::select(['id','rate as name'])->get()->toArray();
//            return response()->json($situations);
            return view('project.create',['types'=>$types,'project'=>$project,'situations'=>$situations]);
        }else{
            $types = ProjectType::select(['id','name','rate'])->where('state','=',1)->get()->toArray();
            $rates = ProjectType::select(['id','rate as name'])->get()->toArray();
            return view('project.create',['types'=>$types,'rates'=>$rates]);
        }
    }
    public function listProject()
    {
        $name = Input::get('search');
        $projectDb = DB::table('projects');
        $role = getRole('project_list');
//        dd($role);
        if ($role=='any'){
            $idArr = getRoleProject('project_list');
            $projectDb->whereIn('id',$idArr);
        }
        if ($name){
            $projectDb->where('number','like','%'.$name.'%')->orWhere('name','like','%'.$name.'%')->orWhere('PartyA','like','%'.$name.'%');
        }
        $projects = $projectDb->orderBy('id','DESC')->paginate(10);
        foreach ($projects as $project){
            $project->unit = OutContract::where('project_id','=',$project->id)->pluck('unit')->toArray();
        }
        return view('project.list',['projects'=>$projects,'search'=>$name]);
    }
    public function createProject(Request $post)
    {
        DB::beginTransaction();
        try{
        $projectData = $post->get('project');
        if (!empty($projectData)){
            if (isset($projectData['id'])){
                $project = Project::find($projectData['id']);
                $project->mainContract()->delete();
                $project->outContract()->delete();
                $project->bail()->delete();
                $project->receipt()->delete();
                $project->picture()->delete();
                $situations = $project->situation()->get();
                foreach ($situations as $situation){
                    $situation->lists()->delete();
                }
                $project->situation()->delete();
            }else{
                $project = new Project();
                $count = Project::whereDate('created_at', date('Y-m-d',time()))->count();
                $project->number = 'XM'.date('Ymd',time()).sprintf("%03d", $count+1);
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
//                if (isset($mainContract['id'])){
//                    $contract = MainContract::find($mainContract['id']);
//                    if (empty($contract)){
//                        $contract = new MainContract();
//                        $contract->project_id = $project->id;
//                    }
//                }else{
                    $contract = new MainContract();
                    $contract->project_id = $project->id;
//                }
                $contract->unit = $mainContract['unit'];
                $contract->price = $mainContract['price'];
                if (isset($mainContract['remark'])){
                    $contract->remark = $mainContract['remark'];
                }
                $contract->save();
            }
        }
        $outContracts = $post->get('outContracts');
        if (!empty($outContracts)){
            foreach ($outContracts as $outContract){
//                if (isset($outContract['id'])){
//                    $out_contract = OutContract::find($outContract['id']);
//                    if (empty($out_contract)){
//                        $out_contract = new OutContract();
//                        $out_contract->project_id = $project->id;
//                    }
//                }else{
                    $out_contract = new OutContract();
                    $out_contract->project_id = $project->id;
//                }
                $out_contract->unit = $outContract['unit'];
                $out_contract->price = $outContract['price'];
//                $out_contract->remark = $outContract['remark'];
                if (isset($outContract['remark'])){
                    $out_contract->remark = $outContract['remark'];
                }
                $out_contract->save();
            }
        }
        $situations = $post->get('situations');
        if (!empty($situations)){
            foreach($situations as $situation){
//                if (isset($situation['id'])){
//                    $situ = ProjectSituations::find($situation['id']);
//                    if (empty($situ)){
//                        $situ = new ProjectSituations();
//                        $situ->project_id = $project->id;
//                    }
//                }else{
                    $situ = new ProjectSituations();
                    $situ->project_id = $project->id;
//                }
                $situ->price = $situation['price'];
                $situ->type = $situation['type'];
                $situ->is_main = $situation['is_main'];
                $situ->save();
                if (!empty($situation['lists'])){
                    foreach ($situation['lists'] as $list){
//                        if (isset($list['id'])){
//                            $lis = SituationList::find($list['id']);
//                        }else{
                            $lis = new SituationList();
                            $lis->situation_id = $situ->id;
//                        }
//                        $type = ProjectType::find($list['name']);
                        $lis->name = $list['name'];
                        $lis->tax = $list['tax'];
                        $lis->price = $list['price'];
                        if (isset($list['remark'])){
                            $lis->remark = $list['remark'];
                        }

                        $lis->save();
                    }
                }
            }
        }
        $bails = $post->get('bails');
        if (!empty($bails)){
            foreach ($bails as $item){
//                if (isset($item['id'])){
//                    $bail = Bail::find($item['id']);
//                }else{
                    $bail = new Bail();
                    $bail->project_id = $project->id;
//                }
                if (isset($item['unit'])){
                    $bail->unit = $item['unit'];
                }
                if (isset($item['price'])){
                    $bail->price = $item['price'];
                }
                if (isset($item['term'])){
                    $bail->term = $item['term'];
                }
                if (isset($item['cost'])){
                    $bail->cost = $item['cost'];
                }
                if (isset($item['other'])){
                    $bail->other = $item['other'];
                }
                if (isset($item['pay_date'])){
                    $bail->pay_date = $item['pay_date'];
                }
                if (isset($item['pay_price'])){
                    $bail->pay_price = $item['pay_price'];
                }
                if (isset($item['payee'])){
                    $bail->payee = $item['payee'];
                }
                if (isset($item['bank'])){
                    $bail->bank = $item['bank'];
                }
                if (isset($item['bank_account'])){
                    $bail->bank_account = $item['bank_account'];
                }
                if (isset($item['condition'])){
                    $bail->condition = $item['condition'];
                }
                $bail->save();
            }
        }
        $receipts = $post->get('receipts');
        if (!empty($receipts)){
            foreach ($receipts as $item){
//                if (isset($item['id'])){
//                    $receipt = Receipt::find($item['id']);
//                }else{
                    $receipt = new Receipt();
                    $receipt->project_id = $project->id;
//                }
                $receipt->ratio = $item['ratio'];
                $receipt->price = $item['price'];
                if (isset($item['condition'])){
                    $receipt->condition = $item['condition'];
                }
                $receipt->save();
            }
        }
        $pictures = $post->get('pictures');
        if (!empty($pictures)){
            foreach ($pictures as $item){
//                if (isset($item['id'])){
//                    $picture = ProjectPicture::find($item['id']);
//                    if (empty($picture)){
//                        $picture = new ProjectPicture();
//                        $picture->project_id = $project->id;
//                    }
//                }else{
                    $picture = new ProjectPicture();
                    $picture->project_id = $project->id;
//                }
                $picture->url = $item['url'];
                $picture->name = $item['name'];
                $picture->save();
            }
        }
        DB::commit();
            return response()->json([
                'code'=>'200',
                'msg'=>"SUCCESS",
                'data'=>[
                    'id'=>$project->id
                ]
            ]);
        }catch (\Exception $exception){
            DB::rollback();
//            dd($exception);
            return response()->json([
                'code'=>'400',
                'message'=>$exception->getMessage(),
                'line'=>$exception->getLine(),
                'msg'=>'数据格式错误！'
            ]);
        }
    }
    public function listProjectsDetail()
    {

        $search = Input::get('search');
        $role = getRole('project_detail');
        if ($role=='all'){
            if ($search){
                $project = Project::where('name','like',$search)->orWhere('number','=',$search)->orderBy('id','DESC')->paginate(10);
            }else{
                $project = Project::orderBy('id','DESC')->paginate(10);
            }
        }else{
            $idArr = getRoleProject('project_detail');
//            dd($idArr);
            $projectDB = Project::whereIn('id',$idArr);
            if ($search){
                $projectDB->where('name','like',$search)->orWhere('number','=',$search);
            }
            $project = $projectDB->orderBy('id','DESC')->paginate(10);
//            dd($project);

        }
        return view('project.detail',['projects'=>$project,'search'=>$search]);
    }
    public function listBudgetsPage()
    {
        $search = Input::get('search');
        $role = getRole('budget_list');
        if ($role=='all'){
            if ($search){
                $projects = Project::where('name','like','%'.$search.'%')->orWhere('number','like','%'.$search.'%')->orderBy('id','DESC')->paginate(10);
            }else{
                $projects = Project::orderBy('id','DESC')->paginate(10);
            }
        }else{
            $idArr = getRoleProject('budget_list');
            $db = Project::whereIn('id',$idArr);
            if ($search){
                $db->where('name','like','%'.$search.'%')->orWhere('number','like','%'.$search.'%');
            }
            $projects = $db->orderBy('id','DESC')->paginate(10);
        }
        if (!empty($projects)){
            foreach ($projects as $project){
                $materialId = Category::where('title','=','材料')->where('state','=',1)->pluck('id')->first();
                $idArr = $project->loanSubmits()->where('state','>=',3)->pluck('id')->toArray();
                $materialCount = LoanSubmitList::whereIn('loan_id',$idArr)->where('category_id','=',$materialId)->sum('price');
                $engineId = Category::where('title','=','工程款')->where('state','=',1)->pluck('id')->first();
                $engineCount = LoanSubmitList::whereIn('loan_id',$idArr)->where('category_id','=',$engineId)->sum('price');
                $otherCount = LoanSubmitList::whereIn('loan_id',$idArr)->where('category_id','!=',$materialId)->where('category_id','!=',$engineId)->sum('price');
                $project->materialCount = $materialCount;
                $project->engineCount = $engineCount;
                $project->otherCount = $otherCount;
//                dd($project);
            }
        }

        return view('budget.list',['projects'=>$projects]);
    }
    public function showBudgetPage()
    {
        $id = Input::get('id');
        $project = Project::find($id);
        return view('budget.detail',['project'=>$project]);
    }
    public function showProjectsDetail()
    {
        $id = Input::get('id');
        $project = Project::find($id);
        $mainContracts = $project->mainContract()->get();
        $outContracts = $project->outContract()->get();
        $situations = $project->situation()->get();
        for ($i=0;$i<count($situations);$i++){
            $situations[$i]->lists = $situations[$i]->lists()->get();
        }
        $bails =  $project->bail()->get();
        $receipts = $project->receipt()->get();
        $picture = $project->picture()->get();
//        $invoice = $project->
        return view('project.check',[
            'project'=>$project,
            'mainContracts'=>$mainContracts,
            'outContracts'=>$outContracts,
            'situations'=>$situations,
            'bails'=>$bails,
            'receipts'=>$receipts,
            'pictures'=>$picture
        ]);
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
        $data = $budgetPost->all();
        $project_id = $data['project_id'];
        unset($data['project_id']);
        $budgets = $data;
//        dd($budgets);
        if (!empty($budgets)){
            foreach ($budgets as $item){
                if ($item['type']==1){
                    if (isset($item['material_id'])){
                        $budget = new Budget();
                        $budget->project_id = $project_id;
                        $budget->material_id = $item['material_id'];
                        $materail = Material::find($item['material_id']);
                        $budget->name = $materail->name;
                        $budget->param = $materail->param;
                        $budget->model = $materail->model;
                        $budget->factory = $materail->factory;
                        $budget->unit = $materail->unit;
                        $budget->price = $item['price'];
                        $budget->number = $item['number'];
                        $budget->cost = $item['price']*$item['number'];
                        $budget->type = $item['type'];
                        $budget->need_buy = $item['number'];
                        $budget->save();
                    }else{
                        $materail = new Material();
                        $materail->name = $item['name'];
                        $materail->param = $item['param'];
                        $materail->model = $item['model'];
                        $materail->factory = $item['factory'];
                        $materail->unit = $item['unit'];
                        $materail->save();
                        $budget = new Budget();
                        $budget->project_id = $project_id;
                        $budget->material_id = $materail->id;
                        $budget->name = $materail->name;
                        $budget->param = $materail->param;
                        $budget->model = $materail->model;
                        $budget->factory = $materail->factory;
                        $budget->unit = $materail->unit;
                        $budget->price = $item['price'];
                        $budget->number = $item['number'];
                        $budget->cost = $item['price']*$item['number'];
                        $budget->type = $item['type'];
                        $budget->need_buy = $item['number'];
                        $budget->save();
                    }
                }else{
                    $budget = new Budget();
                    $budget->project_id = $project_id;
                    $budget->name = $item['name']?$item['name']:'无';
                    $budget->param = $item['param']?$item['param']:'无';
                    $budget->model = $item['model']?$item['model']:'无';
                    $budget->factory = $item['factory']?$item['factory']:'无';
                    $budget->unit = $item['unit']?$item['unit']:'无';
                    $budget->price = $item['price'];
                    $budget->number = $item['number'];
                    $budget->cost = $item['price']*$item['number'];
                    $budget->type = $item['type'];
                    $budget->need_buy = $item['number'];
                    $budget->save();
                }

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
    public function detailBudgetsPage()
    {
        $id = Input::get('id');
        $project = Project::find($id);
        $mainContracts = $project->mainContract()->get();
        $outContracts = $project->outContract()->get();
        $situations = $project->situation()->get();
        $budgets = $project->budget()->get();
//        $projects = Project::all();
        return view('budget.detail',[
            'project'=>$project,
            'mainContracts'=>$mainContracts,
            'outContracts'=>$outContracts,
            'situations'=>$situations,
            'budgets'=>$budgets
        ]);
    }


    public function outputBudget()
    {

    }
    public function importBudget()
    {

    }
    public function checkListsPage()
    {
        $role = getRole('check_list');
        $search = Input::get('search');
        if ($role == 'all'){
            if ($search){
                $projects = Project::where('number','like','%'.$search.'%')->orWhere('name','like','%'.$search.'%')->orderBy('id','DESC')->paginate(10);
            }else{
                $projects = Project::orderBy('id','DESC')->paginate(10);
            }
        }else{
            $idArr = getRoleProject('check_list');
            $db = Project::whereIn('id',$idArr);
            if ($search){
                $db->where('number','like','%'.$search.'%')->orWhere('name','like','%'.$search.'%')->orderBy('id','DESC')->paginate(10);
            }else{
                $db->orderBy('id','DESC')->paginate(10);
            }
            $projects = $db->paginate(10);
        }
        return view('check.list',['projects'=>$projects]);
    }
    public function checkDetailPage()
    {
        $project_id = Input::get('id');
        $project = Project::find($project_id);
        $mainContracts = $project->mainContract()->get();
        $outContracts = $project->outContract()->get();
        $situations = $project->situation()->get();
        $budgets = $project->budget()->get();
        $pictures = $project->picture()->get();
        $receipts = $project->receipt()->get();
        $bails = $project->bail()->get();
        $invoiceTax = Invoice::select('id','rate as value')->get()->toArray();
//        $projects = Project::all();
        $masterContract = $project->collects()->where('type','=',2)->get();
        $subContract = $project->collects()->where('type','=',3)->get();
        $invoice = $project->invoices()->get();
        $tips = $project->tips()->where('type','=',2)->get();
        $subCompany = $project->collects()->where('type','=',4)->get();
        $bailReturn = $project->tips()->where('type','=',1)->get();
        $bailGet = $project->collects()->where('type','=',1)->get();
//        dd($tips);
//        dd($lists);
        $showCount = count($bailGet)>count($bailReturn)?count($bailGet):count($bailReturn);
        return view('check.detail',[
            'project'=>$project,
            'mainContracts'=>$mainContracts,
            'outContracts'=>$outContracts,
            'situations'=>$situations,
            'budgets'=>$budgets,
            'receipts'=>$receipts,
            'pictures'=>$pictures,
            'bails'=>$bails,
            'invoiceTax'=>$invoiceTax,
            'masterContract'=>$masterContract,
            'subContract'=>$subContract,
            'invoiceList'=>$invoice,
            'tips'=>$tips,
            'subCompanies'=>$subCompany,
            'bailReturn'=>$bailReturn,
            'bailGet'=>$bailGet,
            'showCount'=>$showCount
        ]);

    }
    public function checkInvoicePage()
    {
        $id = Input::get('id');
        $invoiceId = Input::get('invoice_id');
        if ($id){
            $project = Project::find($id);
            $invoice = Invoice::select('id','rate as value')->where('state','=',1)->get();
            return view('check.invoice',['project'=>$project,'invoice'=>$invoice]);
        }
        if ($invoiceId){
            $projectInvoice = ProjectInvoice::find($invoiceId);
            $project = Project::find($projectInvoice->project_id);
            $invoice = Invoice::select('id','rate as value')->where('state','=',1)->get();
            $projectInvoice->rate = (int) $projectInvoice->rate;
            $projectInvoice->payee = $projectInvoice->unit;
            $projectInvoice->company = $projectInvoice->unit;
            $lists = $projectInvoice->lists()->get();
            if (!empty($lists)){
                foreach ($lists as $list){
                    $list->with_tax = (float)$list->tax_include;
                    $list->tax = (float)$list->tax_price;
                    $list->without_tax = (float)$list->tax_without;
                }
            }
            $projectInvoice->lists = $lists;
//            return json_encode($projectInvoice);
            return view('check.invoice',['project'=>$project,'invoice'=>$invoice,'projectInvoice'=>$projectInvoice]);
        }


    }
    public function checkCollectPage()
    {
        $id = Input::get('id');
        $project = Project::find($id);
        return view('check.collect',['project'=>$project]);
    }
    public function createInvoice(Request $post)
    {
        DB::beginTransaction();
        try{
            $id = $post->get('id');
            if ($id){
                $lists = $post->get('lists');
                $invoice = ProjectInvoice::find($id);
                $invoice->lists()->delete();
//                $swap = Invoice::find($post->get('rate'));
//                $invoice->project_id = $project_id;
                $invoice->unit = $post->get('payee');
                $invoice->date = $post->get('date');
                $invoice->rate = $post->get('rate');
                $invoice->price = $post->get('price');
                if ($invoice->save()){
                    $price = 0;
                    foreach ($lists as $item){
                        $list = new InvoiceList();
                        $list->invoice_id = $invoice->id;
                        $list->number = $item['number'];
                        $list->tax_include = $item['tax']+$item['without_tax'];
                        $list->tax_price = $item['tax'];
                        $list->tax_without = $item['without_tax'];
                        if (isset($item['remark'])){
                            $list->remark = $item['remark'];
                        }
                        $list->save();
                        $price+=$list->tax_include;
                    }
                }
                if ($price!=$invoice->price){
                    throw new \Exception('金额不等！');
                }
            }else{
                $project_id = $post->get('project_id');
                $lists = $post->get('lists');
                $invoice = new ProjectInvoice();
//                $swap = Invoice::find($post->get('rate'));
                $invoice->project_id = $project_id;
                $invoice->unit = $post->get('payee');
                $invoice->date = $post->get('date');
                $invoice->rate = $post->get('rate');
                $invoice->price = $post->get('price');
                if ($invoice->save()){
                    $price = 0;
                    foreach ($lists as $item){
                        $list = new InvoiceList();
                        $list->invoice_id = $invoice->id;
                        $list->number = $item['number'];
                        $list->tax_include = $item['tax']+$item['without_tax'];
                        $list->tax_price = $item['tax'];
                        $list->tax_without = $item['without_tax'];
                        if (isset($item['remark'])){
                            $list->remark = $item['remark'];
                        }
                        $list->save();
                        $price+=$list->tax_include;
                    }
                }
                if ($price!=$invoice->price){
                    throw new \Exception('金额不等！');
                }
            }


            DB::commit();
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }catch (\Exception $exception){
            DB::rollback();
            return response()->json([
                'code'=>'400',
                'msg'=>$exception->getMessage()
            ]);
        }

    }
    public function createCollect(Request $post)
    {
        $type = $post->get('type');
        $project_id = $post->get('project_id');
        $collect = new ProjectCollect();
        if ($type==1){
            $project = Project::find($project_id);
            $sum = $project->bail()->sum('pay_price')-$project->collects()->where('type','=',1)->sum('price');
//            if ($sum<$post->get('price'))
//            $count = Tip::where('project_id','=',$project_id)->where('type','=',1)->count();
//            $count2 = ProjectCollect::where('project_id','=',$project_id)->where('type','=',1)->count();
            if ($sum<$post->get('price')){
                return response()->json([
                    'code'=>'400',
                    'msg'=>"超出预计收回履约金限制！"
                ]);
            }
        }
        $collect->project_id = $project_id;
        $collect->payee = $post->get('payee');
        $collect->date = $post->get('pay_date');
        $collect->price = $post->get('price');
        $collect->bank = $post->get('bank');
        $collect->account = $post->get('account');
        $collect->type = $type;
        $collect->save();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function acceptancePage()
    {
        $id = Input::get('id');
        $project = Project::find($id);
        return view('check.acceptance',['project'=>$project]);
    }
    public function acceptanceProject(Request $post)
    {
        $project_id = $post->get('project_id');
        $project = Project::find($project_id);
        if ($post->get('to_warranty')==1){
            $project->state = 3;
        }
        $project->acceptance_date = $post->get('acceptance_date');
        $project->remark = $post->get('remark');
        $project->deadline = $post->get('deadline');
        if ($project->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function createTips(Request $post)
    {
//        echo 'ddd';
        $id = $post->get('project_id');
//        dd($id);
        $tips = $post->get('tips');
//        dd($tips);
        foreach ($tips as $item){
            if (isset($item['pay_date'])&&isset($item['price'])&&isset($item['payee'])){
                $tip = new Tip();
                $tip->project_id = $id;
                $tip->pay_date = $item['pay_date'];
                $tip->price = $item['price'];
                $tip->pay_unit = $item['payee'];
                if (isset($item['remark'])){
                    $tip->remark = $item['remark'];
                }
                $tip->type = $item['type'];
                $tip->save();
            }

        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function createTipsPage()
    {
        $id = Input::get('id');
        $project = Project::find($id);
        return view('check.createTips',['project'=>$project]);
    }
    public function createPurchase(Request $post)
    {
        $project_id = $post->get('project_id',0);
//        dd($project_id);
        $basic = $post->get('info');
        $lists = $post->get('lists');
        $contracts = $post->get('contracts');
        DB::beginTransaction();
        try{
            $id = isset($basic['id'])?$basic['id']:0;
            if ($id){
//                dd($id);
//                dd($post->all());
                $purchase = Purchase::find($id);
                $supplier = Supplier::find($basic['supplier_id']);
                $purchase->date = $basic['date'];
                $purchase->supplier = $supplier->name;
                $purchase->supplier_id = $basic['supplier_id'];
                $purchase->bank = $supplier->bank;
                $purchase->account = $supplier->account;
                $purchase->condition = $basic['condition'];
                $purchase->type = $basic['type'];
                $purchase->content = Invoice::find($basic['content'])->name;
                $purchase->content_id = $basic['content'];
                if ($purchase->save()){
                    Task::where('content','=',$purchase->id)->where('type','=','buy_extrabugetary_check')->delete();
                    Task::where('content','=',$purchase->id)->where('type','=','buy_bugetary_check')->delete();
                    Task::where('content','=',$purchase->id)->where('type','=','buy_extrabugetary_pass')->delete();
                    Task::where('content','=',$purchase->id)->where('type','=','buy_bugetary_pass')->delete();

//                    dd($purchaseList);
                    if ($purchase->type==1){
                        $purchaseList = $purchase->lists()->get();
                        if (!empty($purchaseList)){
                            for ($i=0;$i<count($purchaseList);$i++){
                                $budget = Budget::find($purchaseList[$i]->budget_id);
                                $budget->buy_number = $budget->buy_number-$purchaseList[$i]->number;
                                $budget->need_buy = $budget->number-$budget->buy_number;
                                $budget->save();
//                            dd($budget);
                            }
                        }
                    }
                    $purchase->lists()->delete();
                    $purchase->contracts()->delete();
                    foreach ($lists as $item){
//                        if ($item['id']){
//                            $list = PurchaseList::find($item['id']);
////                            if ($list)
//                            dd($item);
//                        }
                        if ($item['material_id']){
                            $list = new PurchaseList();
                            $list->purchase_id = $purchase->id;
                            if ($purchase->type ==1){
                                $list->budget_id = $item['material_id'];
                                $budget = Budget::find($item['material_id']);
//                                dd($budget);
                                if ($budget->need_buy<$item['number']){
                                    throw new Exception('数量错误！');
                                }
                                $budget->buy_number += $item['number'];
                                $budget->need_buy = $budget->number-$budget->buy_number;
                                $budget->save();
                                $list->material_id = $budget->material_id;
                            }else{
                                $list->material_id = $item['material_id'];
                            }
                            $list->price = $item['price'];
                            $list->number = $item['number'];
                            $list->need = $item['number'];
                            $list->cost = $item['number']*$item['price'];
                            $list->warranty_date = $item['warranty_date'];
                            $list->warranty_time = $item['warranty_time'];
                            $list->save();
                        }

                    }
                    foreach ($contracts as $item) {
                        $contract = new PurchaseContract();
                        $contract->purchase_id = $purchase->id;
                        $contract->name = $item['name'];
                        $contract->href = $item['href'];
                        $contract->save();
                    }
                    DB::commit();
                    return response()->json([
                        'code'=>'200',
                        'msg'=>'SUCCESS',
                        'data'=>[
                            'id'=>$purchase->id,
                            'type'=>$purchase->type
                        ]
                    ]);
                }
//                dd($purchase);
            }else{
                $purchase = new Purchase();
                $purchase->project_id = $project_id?$project_id:0;
                $count = Purchase::whereDate('created_at', date('Y-m-d',time()))->count();
                $purchase->number = 'CG'.date('Ymd',time()).sprintf("%03d", $count+1);
                $supplier = Supplier::find($basic['supplier_id']);
                $purchase->date = $basic['date'];
                $purchase->supplier = $supplier->name;
                $purchase->supplier_id = $basic['supplier_id'];
                $purchase->bank = $supplier->bank;
                $purchase->account = $supplier->account;
                $purchase->condition = $basic['condition'];
                $purchase->type = $basic['type'];
                $purchase->content = Invoice::find($basic['content'])->name;
                $purchase->content_id = $basic['content'];
                $purchase->worker_id = Auth::id();
                $purchase->worker = Auth::user()->username;
                if ($purchase->save()){
                    foreach ($lists as $item){
                        if ($item['material_id']){
                            $list = new PurchaseList();
                            $list->purchase_id = $purchase->id;
                            if ($purchase->type ==1){
                                $list->budget_id = $item['material_id'];
                                $budget = Budget::find($item['material_id']);
                                if ($budget->need_buy<$item['number']){
                                    throw new Exception('数量错误！');
                                }
                                $budget->buy_number += $item['number'];
                                $budget->need_buy = $budget->number-$budget->buy_number;
                                $budget->save();
                                $list->material_id = $budget->material_id;
                            }else{
                                $list->material_id = $item['material_id'];
                            }
                            $list->price = $item['price'];
                            $list->number = $item['number'];
                            $list->need = $item['number'];
                            $list->cost = $item['number']*$item['price'];
                            $list->warranty_date = $item['warranty_date'];
                            $list->warranty_time = $item['warranty_time'];
                            $list->save();
                        }

                    }
                    foreach ($contracts as $item) {
                        $contract = new PurchaseContract();
                        $contract->purchase_id = $purchase->id;
                        $contract->name = $item['name'];
                        $contract->href = $item['href'];
                        $contract->save();
                    }
                    DB::commit();
                    return response()->json([
                        'code'=>'200',
                        'msg'=>'SUCCESS',
                        'data'=>[
                            'id'=>$purchase->id,
                            'type'=>$purchase->type
                        ]
                    ]);
                }
            }

        }catch (Exception $exception){
            DB::rollback();
            return response()->json([
                'code'=>'400',
                'msg'=>$exception->getMessage()
            ]);
        }

    }
    public function createPurchasePayment()
    {

    }
    public function checkTipsPage()
    {
        $s = Input::get('s');
        $e = Input::get('e');
        $role = getRole('check_tip');
        if ($role=='any'){
            $idArr = getRoleProject('check_tip');
            $db = Tip::whereIn('project_id',$idArr);
            if ($s){
                $db->whereBetween('pay_date',[$s,$e]);
            }
            $tips = $db->paginate(10);
        }else{
            if ($s){
                $tips = Tip::whereBetween('pay_date',[$s,$e])->orderBy('id','DESC')->paginate(10);
            }else{
                $tips = Tip::orderBy('id','DESC')->paginate(10);
            }
        }
        return view('check.tips',['tips'=>$tips]);
    }
    public function listPurchasesPage()
    {
        $role = getRole('buy_list');
        $db = Purchase::where('state','=',3);
        $search = Input::get('search');
        if ($role=='any'){
            $idArr = getRoleProject('buy_list');
            $db->whereIn('project_id',$idArr);
        }
        if ($search){

            $idArray = Project::where('number','like','%'.$search.'%')->orWhere('name','like','%'.$search.'%')->pluck('id')->toArray();
//            dd($idArray);
            if (!empty($idArray)){
                $db->whereIn('project_id',$idArray)->orWhere('number','like','%'.$search.'%')->orWhere('supplier','like','%'.$search.'%');;
            }else{
                $db->where('number','like','%'.$search.'%')->orWhere('supplier','like','%'.$search.'%');
            }
        }
        $lists = $db->orderBy('id','DESC')->paginate(10);
        if (!empty($lists)){
            foreach ($lists as $list){
                $received = 0;
                $need = 0;
                $data  = $list->lists()->get();
                if (!empty($data)){
                    foreach ($data as $datum){
                        $received+= $datum->price*$datum->received;
                        $need+= $datum->price*$datum->need;
                    }
                }
                $list->received = $received;
                $list->need = $need;
            }
        }
        return view('buy.list',['lists'=>$lists]);
    }
    public function listProjectPurchasesPage()
    {
        $role = getRole('buy_list');
        $search = Input::get('search');
        $type = Input::get('seartch-type');


//        $db = Purchase::where('state','=',3);
        if ($role=='any'){
            $idArr = getRoleProject('buy_list');
            if ($type){
                if ($type<=2){
                    $purchaseId = Purchase::where('number','like','%'.$search.'%')->orWhere('supplier','like','%'.$search.'%')->pluck('id')->toArray();
                    $lists = Purchase::whereIn('project_id',$idArr)->whereIn('id',$purchaseId)->orderBy('id','DESC')->paginate(10);
                }else{
                    $projectId = Project::where('number','like','%'.$search.'%')->orWhere('name','like','%'.$search.'%')->pluck('id')->toArray();
                    $lists = Purchase::whereIn('project_id',$idArr)->whereIn('project_id',$projectId)->orderBy('id','DESC')->paginate(10);
                }
            }else{
                $lists = Purchase::whereIn('project_id',$idArr)->orderBy('id','DESC')->paginate(10);
            }
        }else{
            if ($type){
                if ($type<=2){
                    $purchaseId = Purchase::where('number','like','%'.$search.'%')->orWhere('supplier','like','%'.$search.'%')->pluck('id')->toArray();
                    $lists = Purchase::whereIn('id',$purchaseId)->orderBy('id','DESC')->paginate(10);
                }else{
                    $projectId = Project::where('number','like','%'.$search.'%')->orWhere('name','like','%'.$search.'%')->pluck('id')->toArray();
                    $lists = Purchase::whereIn('project_id',$projectId)->orderBy('id','DESC')->paginate(10);
                }
            }else{
                $lists = Purchase::orderBy('id','DESC')->paginate(10);
            }

        }
        return view('buy.project_list',['lists'=>$lists]);
    }
    public function listPurchasesPayPage()
    {
        $role = getRole('buy_list');
        $search = Input::get('search');
        $db = Purchase::where('state','=',3);
        if ($role=='any'){
            $idArr = getRoleProject('buy_list');
            $lists = $db->whereIn('project_id',$idArr)->orderBy('id','DESC')->paginate(10);
        }
        if ($search){

            $idArray = Project::where('number','like','%'.$search.'%')->orWhere('name','like','%'.$search.'%')->pluck('id')->toArray();
//            dd($idArray);
            if (!empty($idArray)){
                $db->whereIn('project_id',$idArray)->orWhere('number','like','%'.$search.'%')->orWhere('supplier','like','%'.$search.'%');;
            }else{
                $db->where('number','like','%'.$search.'%')->orWhere('supplier','like','%'.$search.'%');
            }
        }
        $lists = $db->orderBy('id','DESC')->paginate(10);
        if(!empty($lists)){
            foreach ($lists as $list){
                $count = $list->payments()->where('state','=',2)->count();
                $list->count = $count;
            }
        }
        return view('buy.pay_list',['lists'=>$lists]);
    }
    public function listPurchasesChargePage()
    {
        $role = getRole('buy_list');
        $db = Purchase::where('state','=',3);
        $search = Input::get('search');
        if ($role=='any'){
            $idArr = getRoleProject('buy_list');
            $purchases = $db->whereIn('project_id',$idArr)->orderBy('id','DESC')->paginate(10);
        }
        if ($search){
            $idArray = Project::where('number','like','%'.$search.'%')->orWhere('name','like','%'.$search.'%')->pluck('id')->toArray();
//            dd($idArray);
            if (!empty($idArray)){
                $db->whereIn('project_id',$idArray)->orWhere('number','like','%'.$search.'%')->orWhere('supplier','like','%'.$search.'%');;
            }else{
                $db->where('number','like','%'.$search.'%')->orWhere('supplier','like','%'.$search.'%');
            }
        }
            $purchases = $db->orderBy('id','DESC')->paginate(10);

//        $purchases = Purchase::paginate(10);
        return view('buy.charge_list',['purchases'=>$purchases]);
    }
    public function purchaseCollectPage()
    {
//        $type = Input::get('seartch-type');
        $value = Input::get('number');
        if ($value){
            $project = Project::where('number','=',$value)->first();
        }else{
            $project = null;
        }
        if (!empty($project)){
            $purchases = $project->purchases()->where('state','=',3)->get();
            foreach ($purchases as $purchase){
                if (!empty($purchase)){
                    $purchase->lists = $purchase->lists()->get();
                }
            }
            $project->purchases = $purchases;
        }
//        dd($project);

//        $role = getRole('')
////        dd($type);
//        if ($type==1){
////            dd($value);
//            $projects = Project::where('number','like','%'.$value.'%')->paginate(10);
//        }elseif ($type==2){
//            $projects = Project::where('name','like','%'.$value.'%')->paginate(10);
//        }else{
//            $projects = Project::paginate(10);
//        }
//        $projects = Project::paginate(10);
//        if (!empty($projects)){
//            foreach ($projects as $project){
//                $purchases = $project->purchases()->get();
//                foreach ($purchases as $purchase){
//                    if (!empty($purchase)){
//                        $purchase->lists = $purchase->lists()->get();
//                    }
//                }
//                $project->purchases = $purchases;
//            }
//        }
        return view('buy.collect',['project'=>$project,'search'=>$value]);
    }
    public function searchPurchaseProject()
    {
        $name = Input::get('name');
        $idArr = Purchase::where('state','=',3)->pluck('project_id')->toArray();
        $db = Project::whereIn('id',$idArr);
        if ($name){
            $db->where('name','like','%'.$name.'%')
                ->orWhere('number','like','%'.$name.'%');
        }
//        dd($name);
        $data = $db->orderBy('id','DESC')->select(['name','number'])->get()->toArray();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$data
        ]);
    }
    public function purchaseParityPage()
    {
        $id = Input::get('material_id');
        $start = Input::get('s');
        $end = Input::get('e');
        if (!empty($start)){
            $idArr = PurchaseList::where('material_id','=',$id)->whereDate('created_at','>=',$start)
                ->whereDate('created_at','<=',$end)->pluck('purchase_id')->toArray();
            $purchaseId = Purchase::whereIn('id',$idArr)->where('state','>=',3)->pluck('id')->toArray();
            $lists = PurchaseList::where('material_id','=',$id)->whereIn('purchase_id',$purchaseId)->get();
        }else{
            $lists = [];
        }
        if (!empty($lists)){
            foreach ($lists as $list){
                $list->purchase = Purchase::find($list->purchase_id);
            }
        }
        return view('buy.parity',['lists'=>$lists,'s'=>$start,'e'=>$end,'id'=>$id]);
    }
    public function createBudgetaryPage()
    {
        return view('buy.budgetary');
    }
    public function createExtraBudgetaryPage()
    {
        $id = Input::get('id');
        if ($id){
            $purchase = Purchase::find($id);
            $contracts = $purchase->contracts()->get();
            $lists = $purchase->lists()->get();
            if (!empty($lists)){
                foreach ($lists as $list){
                    $materail = Material::find($list->material_id);
                    $list->name = $materail->name;
                    $list->param = $materail->param;
                    $list->model = $materail->model;
                    $list->factory = $materail->factory;
                    $list->unit = $materail->unit;
                    $list->material = $materail;
                    $list->own_id = $list->id;
                }
            }
            $purchase->supplier_name = $purchase->supplier;
            $purchase->content = $purchase->content_id;
            $project = $purchase->project_id==0?null:Project::find($purchase->project_id);
//            $content =
            $data = [];
            $data['info'] = $purchase;
            $data['contracts'] = $contracts;
            $data['lists'] = $lists;
            $data['project_id'] = empty($project)?0:$project->id;
            $data['project_number'] = empty($project)?'':$project->number;
            $data['project_content'] = empty($project)?'':$project->name;
//            return json_encode($data);
            $invoice = Invoice::where('state','=',1)->get();
            return view('buy.extrabudgetary',['invoice'=>$invoice,'editData'=>$data]);
//            dd($data);
//            echo $id;
        }else{
            $invoice = Invoice::where('state','=',1)->get();
            return view('buy.extrabudgetary',['invoice'=>$invoice]);
        }

    }
    public function showProjectsAuth()
    {
        $id = Input::get('id');
        $project = Project::find($id);
        $id_arr = Role::where('role_value','=','any')->pluck('user_id')->toArray();
        $user = User::whereIn('id',$id_arr)->select(['id','name'])->get();
        $list1 = DB::table('project_roles')->select(['id','user_id'])->where('project_id','=',$id)->where('type','=',1)->groupby('user_id')->get();
        $list2 = DB::table('project_roles')->where('project_id','=',$id)->where('type','=',2)->select(['id','user_id'])->groupby('user_id')->get();
        $list3 = DB::table('project_roles')->where('project_id','=',$id)->where('type','=',3)->select(['id','user_id'])->groupby('user_id')->get();
        return view('project.auth',[
            'users'=>$user,
            'project'=>$project,
            'lists1'=>$list1,
            'lists2'=>$list2,
            'lists3'=>$list3
        ]);
    }
    public function createProjectAuthPage()
    {
//        dd(Input::all());
        $id = Input::get('user_id');
        $project_id = Input::get('project_id');
        $type = Input::get('type');
//        $user = User::find($id);
        ProjectRole::where('user_id','=',$id)->where('project_id','=',$project_id)->where('type','=',$type)->delete();
        $role = Role::where('user_id','=',$id)->where('role_value','=','any')->get();
        $project = Project::find($project_id);

        foreach ($role as $item){
            $role = new ProjectRole();
            $role->user_id = $id;
            $role->project_id = $project_id;
            $role->type = $type;
            $role->role_value = $item->role_name;
            if ($type==1){
                $role->start = $project->createTime;
                $role->end = $project->finishTime;
            }elseif($type==2){
                if (empty($project->deadline)){
                    return redirect()->back()->with('status','请先设置保修截至日期!');
                }
                $role->start = strtotime($project->acceptance_date);
                $role->end = strtotime($project->deadline);
            }else{
                if (empty($project->deadline)){
                    return redirect()->back()->with('status','请先设置保修截至日期!');
                }
                $role->start = strtotime($project->deadline);
                $role->end = strtotime($project->deadline)+63158400;
            }
            $role->save();
        }
        return redirect()->back()->with('status','操作成功!');
    }
    public function createProjectAuth(Request $post)
    {
        $data = $post->all();
//        dd($data);
        $project_id = $data['project_id'];
        $type = $data['type'];
        $user_id = $data['user_id'];
        unset($data['project_id']);
        unset($data['type']);
        unset($data['user_id']);
        if (!empty($data)){
            ProjectRole::where('user_id','=',$user_id)->where('project_id','=',$project_id)->where('type','=',$type)->delete();
            $project = Project::find($project_id);
            foreach ($data as $datum=>$value){
                if ($value=='all'){
                    $role = new ProjectRole();
                    $role->user_id = $user_id;
                    $role->project_id = $project_id;
                    $role->type = $type;
                    $role->role_value = $datum;
                    if ($type==1){
                        $role->start = $project->createTime;
                        $role->end = $project->finishTime;
                    }elseif($type==2){
                        $role->start = strtotime($project->acceptance_date);
                        $role->end = strtotime($project->deadline);
                    }else{
                        $role->start = strtotime($project->deadline);
                        $role->end = strtotime('2050-12-28');
                    }
                    $role->save();
                }
            }
            return redirect()->back()->with('status','操作成功！');
        }
    }
    public function showAuthPage()
    {
        $user_id = Input::get('user_id');
        $project_id = Input::get('project_id');
        $type = Input::get('type');
        $user = User::find($user_id);
        $project = Project::find($project_id);
        $roles = ProjectRole::where('project_id','=',$project_id)->where('type','=',$type)->where('user_id','=',$user_id)->select('role_value')->get()->toArray();
        $lists = array_column($roles, 'role_value');
        return view('project.auth_check',['project'=>$project,'user'=>$user,'lists'=>$lists,'type'=>$type]);
    }
    public function printBudget()
    {
        $id = Input::get('id');
        $project = Project::find($id);
        $budgets = $project->budget()->get();
//        foreach ($budgets as $budget){
//            if ($budget->material_id!=0){
//                $budget->material = Material::find($budget->material_id);
//            }
//        }
        return view('budget.print',['project'=>$project,'budgets'=>$budgets]);
    }
    public function checkProject()
    {
        $id = Input::get('id');
        $project = Project::find($id);
        if ($project->state != 1){
            return response()->json([
                'code'=>'400',
                'msg'=>'该项目已经复核！'
            ]);
        }
        $project->state = 2;
        $project->save();
        Task::where('type','=','project_check')->where('content','=',$id)->update(['state'=>0]);
        return response()->json([
            'code'=>'200',
            'msg'=>"SUCCESS",
            'data'=>[
                'id'=>$id
            ]
        ]);
    }
    public function selectChecker()
    {
        $id = Input::get('id');
        $users = Input::get('users');
        if (!empty($users)){
            foreach ($users as $user){
                $task = new Task();
                $task->type = 'project_check';
                $task->title = '项目复核';
                $task->number = Project::find($id)->number;
                $task->url = 'project/check?id='.$id;
                $task->content = $id;
                $task->user_id = $user;
                $task->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function passProject()
    {
        $id = Input::get('id');
        $project = Project::find($id);
        if ($project->state != 2){
            return response()->json([
                'code'=>'400',
                'msg'=>'该项目已经审批！'
            ]);
        }
        $project->state = 3;
        $project->save();
        Task::where('type','=','project_pass')->where('content','=',$id)->update(['state'=>0]);
        return response()->json([
            'code'=>'200',
            'msg'=>"SUCCESS"
        ]);
    }
    public function selectPasser()
    {
        $id = Input::get('id');
        $users = Input::get('users');
        if (!empty($users)){
            foreach ($users as $user){
                $task = new Task();
                $task->type = 'project_pass';
                $task->title = '项目审批';
                $task->number = Project::find($id)->number;
                $task->url = 'project/check?id='.$id;
                $task->content = $id;
                $task->user_id = $user;
                $task->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function checkPrintInvoice()
    {
        $id = Input::get('id');
        $invoice = ProjectInvoice::find($id);
        $lists = $invoice->lists()->get();
        return view('check.invoice_print',['invoice'=>$invoice,'lists'=>$lists]);
    }
    public function checkMasterInvoice()
    {
        $id = Input::get('id');
        $collect = ProjectCollect::find($id);
        $project = Project::find($collect->project_id);
        return view('check.collect_master_print',['collect'=>$collect,'project'=>$project]);
    }
    public function checkSubInvoice()
    {
        $id = Input::get('id');
        $collect = ProjectCollect::find($id);
        $project = Project::find($collect->project_id);
        return view('check.collect_sub_print',['collect'=>$collect,'project'=>$project]);
    }
    public function confirmProject()
    {
        $id = Input::get('id');
        $project = Project::find($id);
        if ($project->state!=1){
            return response()->json([
                'code'=>'400',
                'msg'=>'已确认过的项目不需重新确认！'
            ]);
        }
        $project->state = 2;
        $project->save();
        return response()->json([
            'code'=>'200',
            'msg'=>"SUCCESS"
        ]);
    }
    public function deleteProject()
    {
        $id = Input::get('id');
        $project = Project::find($id);
        if ($project->state!=1){
            return response()->json([
                'code'=>'400',
                'msg'=>'确认过的项目不能删除！'
            ]);
        }
        $project->bail()->delete();
        $project->mainContract()->delete();
        $project->outContract()->delete();
        $project->budget()->delete();
        $project->situation()->delete();
        $project->receipt()->delete();
        $project->purchases()->delete();
        $project->collects()->delete();
        $project->invoices()->delete();
        $project->tips()->delete();
        $project->stockRecords()->delete();
        $project->requestPayments()->delete();
        $project->loanSubmits()->delete();
        $project->payApplies()->delete();
        $project->picture()->delete();
        $project->delete();
        return response()->json([
            'code'=>'200',
            'msg'=>"SUCCESS"
        ]);
    }
    public function collect()
    {
        $id = Input::get('id');
        $collect = ProjectCollect::find($id);
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$collect
        ]);
    }
    public function editCollect(Request $post)
    {
        $id = $post->id;
        $collect = ProjectCollect::find($id);
        $collect->date = $post->date?$post->date:$collect->date;
        $collect->payee = $post->payee?$post->payee:$collect->payee;
        $collect->price = $post->price?$post->price:$collect->price;
        $collect->bank = $post->bank?$post->bank:$collect->bank;
        $collect->account = $post->account?$post->account:$collect->account;
        if ($collect->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function getTip()
    {
        $id = Input::get('id');
        $tip = Tip::find($id);
        return response()->json([
            'code'=>'200',
            'data'=>$tip
        ]);
    }
    public function editTip(Request $post)
    {
        $id = $post->id;
        $tip = Tip::find($id);
        $tip->pay_date = $post->pay_date?$post->pay_date:$tip->pay_date;
        $tip->price = $post->price?$post->price:$tip->price;
        $tip->pay_unit = $post->pay_unit?$post->pay_unit:$tip->pay_unit;
        $tip->remark = $post->remark?$post->remark:$tip->remark;
        if ($tip->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function editSubInvoicePage()
    {
        $id = Input::get('id');
        $collect = ProjectCollect::find($id);
        $project = Project::find($collect->project_id);
        return view('check.subContract',['collect'=>$collect,'project'=>$project]);
    }
    public function editSubInvoice(Request $post)
    {
//        dd(Input::all());
        $id = $post->id;
        $collect = ProjectCollect::find($id);
        $collect->price = $post->price?$post->price:$collect->price;
        $collect->payee = $post->payee?$post->payee:$collect->payee;
        $collect->date = $post->date?$post->date:$collect->date;
        $collect->bank = $post->bank?$post->bank:$collect->bank;
        $collect->account = $post->account?$post->account:$collect->account;
        if ($collect->save()){
            return redirect()->back()->with('status','修改成功！');
        }
    }
    public function editMasterInvoicePage()
    {
        $id = Input::get('id');
        $collect = ProjectCollect::find($id);
        $project = Project::find($collect->project_id);
        return view('check.master',['collect'=>$collect,'project'=>$project]);
    }
    public function editMasterInvoice(Request $post)
    {
        $id = $post->id;
        $collect = ProjectCollect::find($id);
        $collect->price = $post->price?$post->price:$collect->price;
        $collect->payee = $post->payee?$post->payee:$collect->payee;
        $collect->date = $post->date?$post->date:$collect->date;
        $collect->bank = $post->bank?$post->bank:$collect->bank;
        $collect->account = $post->account?$post->account:$collect->account;
        if ($collect->save()){
            return redirect()->back()->with('status','修改成功！');
        }
    }
    public function editCompanyInvoicePage()
    {
        $id = Input::get('id');
        $collect = ProjectCollect::find($id);
        $project = Project::find($collect->project_id);
        return view('check.company',['collect'=>$collect,'project'=>$project]);
    }
    public function editCompanyInvoice(Request $post)
    {
        $id = $post->id;
        $collect = ProjectCollect::find($id);
        $collect->price = $post->price?$post->price:$collect->price;
//        $collect->payee = $post->payee?$post->payee:$collect->payee;
        $collect->date = $post->date?$post->date:$collect->date;
//        $collect->bank = $post->bank?$post->bank:$collect->bank;
//        $collect->account = $post->account?$post->account:$collect->account;
        if ($collect->save()){
            return redirect()->back()->with('status','修改成功！');
        }
    }
    public function editBailInvoicePage()
    {
        $id = Input::get('id');
        $collect = ProjectCollect::find($id);
        $project = Project::find($collect->project_id);
//        dd($collect);
        return view('check.bail',['collect'=>$collect,'project'=>$project]);
    }
    public function editBailInvoice(Request $post)
    {
        $id = $post->id;
        $collect = ProjectCollect::find($id);
        $project = Project::find($collect->project_id);
        $price = $post->price;
        $swap =$project->bail()->sum('pay_price')-$project->collects()->where('type','=',1)->sum('price');
        if ($swap==0){
            if ($price>$collect->price){
                return redirect()->back()->with('status','不能超过原有金额！');
            }
        }else{
            if ($swap+$collect->price<$price){
                return redirect()->back()->with('status','不能超过履约保证金余额！');
            }
        }

        $collect->price = $post->price?$post->price:$collect->price;
        $collect->payee = $post->payee?$post->payee:$collect->payee;
        $collect->date = $post->date?$post->date:$collect->date;
        $collect->bank = $post->bank?$post->bank:$collect->bank;
        $collect->account = $post->account?$post->account:$collect->account;
        if ($collect->save()){
            return redirect()->back()->with('status','修改成功！');
        }
    }
    public function editTipPage()
    {
        $id = Input::get('id');
        $tip = Tip::find($id);
        $project = Project::find($tip->project_id);
        return view('check.tip',['tip'=>$tip,'project'=>$project]);
    }
    public function editCheckTip(Request $post)
    {
//        dd($post->all());
        $id = $post->id;
        $tip = Tip::find($id);
        $tip->pay_date = $post->pay_date?$post->pay_date:$tip->pay_date;
        $tip->pay_unit = $post->pay_unit?$post->pay_unit:$tip->pay_unit;
        $tip->price = $post->price?$post->price:$tip->price;
        $tip->remark = $post->remark?$post->remark:$tip->remark;
        if ($tip->save()){
            return redirect()->back()->with('status','修改成功！');
        }
    }
    public function editCheckBailTipPage()
    {
        $id = Input::get('id');
        $tip = Tip::find($id);
        $project = Project::find($tip->project_id);
        return view('check.bailTip',['tip'=>$tip,'project'=>$project]);
    }
    public function editCheckBailTip(Request $post)
    {
        $id = $post->id;
        $tip = Tip::find($id);
        $tip->pay_date = $post->pay_date?$post->pay_date:$tip->pay_date;
        $tip->pay_unit = $post->pay_unit?$post->pay_unit:$tip->pay_unit;
        $tip->price = $post->price?$post->price:$tip->price;
        $tip->remark = $post->remark?$post->remark:$tip->remark;
        if ($tip->save()){
            return redirect()->back()->with('status','修改成功！');
        }
    }

}
