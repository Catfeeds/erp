<?php

namespace App\Http\Controllers;

use App\Http\Requests\BudgetPost;
use App\Http\Requests\CreateProjectPost;
use App\Models\Bail;
use App\Models\Budget;
use App\Models\Invoice;
use App\Models\InvoiceList;
use App\Models\MainContract;
use App\Models\Material;
use App\Models\OutContract;
use App\Models\Project;
use App\Models\ProjectCollect;
use App\Models\ProjectInvoice;
use App\Models\ProjectPicture;
use App\Models\ProjectSituations;
use App\Models\ProjectType;
use App\Models\Purchase;
use App\Models\PurchaseContract;
use App\Models\PurchaseList;
use App\Models\Receipt;
use App\Models\SituationList;
use App\Models\Supplier;
use App\Models\TaxRate;
use App\Models\Tip;
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
    public function searchBudget()
    {
        $number = Input::get('project');
        $project = Project::where('number','=',$number)->first();
        if ($project){
            $budgets = $project->budget()->get();
            foreach ($budgets as $budget){
                $budget->material = Material::find($budget->material_id);
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
            dd($project);
        }else{
            $types = ProjectType::select(['id','name'])->get()->toArray();
            $rates = ProjectType::select(['id','rate as name'])->get()->toArray();
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
        DB::beginTransaction();
        try{
        $projectData = $post->get('project');
        if (!empty($projectData)){
            if (isset($projectData['id'])){
                $project = Project::find($projectData['id']);
            }else{
                $project = new Project();
                $count = Project::whereDate('created_at', date('Y-m-d',time()))->count();;
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
        DB::commit();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
        }catch (\Exception $exception){
            DB::rollback();
            return response()->json([
                'code'=>'400',
                'msg'=>'ERROR'
            ]);
        }
    }
    public function listProjectsDetail()
    {
        $project = Project::paginate(10);
        return view('project.detail',['projects'=>$project]);
    }
    public function listBudgetsPage()
    {
        $projects = Project::all();
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
                if (isset($item['material_id'])){
                    $budget = new Budget();
                    $budget->project_id = $project_id;
                    $budget->material_id = $item['material_id'];
                    $budget->price = $item['price'];
                    $budget->number = $item['number'];
                    $budget->cost = $item['cost'];
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
                    $budget->price = $item['price'];
                    $budget->number = $item['number'];
                    $budget->cost = $item['cost'];
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
        $projects = Project::paginate(10);
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
//        $projects = Project::all();
        return view('check.detail',[
            'project'=>$project,
            'mainContracts'=>$mainContracts,
            'outContracts'=>$outContracts,
            'situations'=>$situations,
            'budgets'=>$budgets,
            'receipts'=>$receipts,
            'pictures'=>$pictures
        ]);

    }
    public function checkInvoicePage()
    {
        $id = Input::get('id');
        $project = Project::find($id);
        return view('check.invoice',['project'=>$project]);
    }
    public function checkCollectPage()
    {
        $id = Input::get('id');
        $project = Project::find($id);
        return view('check.collect',['project'=>$project]);
    }
    public function createInvoice(Request $post)
    {
        $project_id = $post->get('project_id');
        $lists = $post->get('lists');
        $invoice = new ProjectInvoice();
        $invoice->project_id = $project_id;
        $invoice->unit = $post->get('payee');
        $invoice->date = $post->get('date');
        $invoice->rate = $post->get('rate');
        $invoice->price = $post->get('price');
        if ($invoice->save()){
            foreach ($lists as $item){
                $list = new InvoiceList();
                $list->invoice_id = $invoice->id;
                $list->number = $item['number'];
                $list->tax_include = $item['with_tax'];
                $list->tax_price = $item['tax'];
                $list->tax_without = $item['without_tax'];
                $list->remark = $item['remark'];
                $list->save();
            }
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function createCollect(Request $post)
    {
        $type = $post->get('type');
        $project_id = $post->get('project_id');
        $collect = new ProjectCollect();
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
            $project->state = 2;
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
            $tip = new Tip();
            $tip->project_id = $id;
            $tip->pay_date = $item['pay_date'];
            $tip->price = $item['price'];
            $tip->pay_unit = $item['payee'];
            $tip->remark = $item['remark'];
            $tip->type = $item['type'];
            $tip->save();
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
        $project_id = $post->get('project_id');
        $basic = $post->get('info');
        $lists = $post->get('lists');
        $contracts = $post->get('contracts');
        $purchase = new Purchase();
        $purchase->project_id = $project_id;
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
        if ($purchase->save()){
            foreach ($lists as $item){
                if ($item['material_id']){
                    $list = new PurchaseList();
                    $list->purchase_id = $purchase->id;
                    if ($purchase->type ==1){
                        $list->budget_id = $item['material_id'];
                        $budget = Budget::find($item['material_id']);
                        $budget->buy_number += $item['number'];
                        $budget->need_buy = $budget->number-$budget->buy_number;
                        $budget->save();
                    }else{
                        $list->material_id = $item['material_id'];
                    }
                    $list->price = $item['price'];
                    $list->number = $item['number'];
                    $list->cost = $item['cost'];
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
    public function createPurchasePayment()
    {

    }
    public function checkTipsPage()
    {
        $tips = Tip::paginate(10);
        return view('check.tips',['tips'=>$tips]);
    }
    public function listPurchasesPage()
    {
        $lists = Purchase::paginate(10);
        return view('buy.list',['lists'=>$lists]);
    }
    public function listProjectPurchasesPage()
    {
        $lists = Purchase::paginate(10);
        return view('buy.project_list',['lists'=>$lists]);
    }
    public function listPurchasesPayPage()
    {
        $lists = Purchase::paginate(10);
        return view('buy.pay_list',['lists'=>$lists]);
    }
    public function listPurchasesChargePage()
    {
        return view('buy.charge_list');
    }
    public function purchaseCollectPage()
    {
        return view('buy.collect');
    }
    public function purchaseParityPage()
    {
        return view('buy.parity');
    }
    public function createBudgetaryPage()
    {
        return view('buy.budgetary');
    }
    public function createExtraBudgetaryPage()
    {
        $invoice = Invoice::all();
        return view('buy.extrabudgetary',['invoice'=>$invoice]);
    }

}
