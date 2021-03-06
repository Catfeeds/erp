<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Budget;
use App\Models\Category;
use App\Models\LoanList;
use App\Models\LoanPay;
use App\Models\LoanPayList;
use App\Models\LoanSubmit;
use App\Models\LoanSubmitList;
use App\Models\Material;
use App\Models\OutContract;
use App\Models\PayApply;
use App\Models\Project;
use App\Models\ProjectSituations;
use App\Models\ProjectTeam;
use App\Models\Purchase;
use App\Models\PurchaseList;
use App\Models\RequestPayment;
use App\Models\Stock;
use App\Models\StockRecord;
use App\Models\StockRecordList;
use App\Models\Supplier;
use App\Models\Team;
use App\Models\Warehouse;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Excel;

class ExcelController extends Controller
{
    //
    public function __construct(\Maatwebsite\Excel\Excel $excel)
    {
        $this->excel = $excel;
    }
    public function exportUser()
    {
        $data = User::select(['username','department','phone'])->where('state','=',1)->get()->toArray();
        $tr = [['姓名','部门','电话']];
        $data = array_merge($tr,$data);
        $this->excel->create('user',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
//        dd($data);
    }
    public function exportSupplier()
    {
        $data = Supplier::select(['name','bank','account'])->where('state','=',1)->orderBy('id','DESC')->get()->toArray();
        //供应商名称	收款银行	收款账号
        for ($i=0;$i<count($data);$i++){
            $data[$i]['account'] = ' '.$data[$i]['account'];
        }
        $tr = [['供应商名称','收款银行','收款账号']];
        $data = array_merge($tr,$data);
        $this->excel->create('supplier',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportMaterial()
    {
        $data = Material::select(['name','param','model','factory','unit'])->where('state','=',1)->orderBy('id','DESC')->get()->toArray();
        //物料名称		品牌型号	生产厂家
        $tr = [['物料名称','性能与技术参数','品牌型号','生产厂家','单位']];
        $data = array_merge($tr,$data);
        $this->excel->create('material',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportWarehouse()
    {
        $data = Warehouse::select(['name','address','admin'])->where('state','=',1)->get()->toArray();
        //
        $tr = [['仓库名称','仓库地址','仓管员']];
        $data = array_merge($tr,$data);
        $name = 'warehouse';
        $this->excel->create($name,function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportBank()
    {
        $data = BankAccount::select(['name','account'])->where('state','=',1)->get()->toArray();
        //银行名称	收款账号
        for ($i=0;$i<count($data);$i++){
            $data[$i]['account'] = ' '.$data[$i]['account'];
        }
        $tr = [['银行名称','收款账号']];
        $data = array_merge($tr,$data);
//        dd($data);
        $this->excel->create('bank',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportTeam()
    {
        $data = Team::select(['name','manager'])->where('state','=',1)->get()->toArray();
        //
        $tr = [['施工队名称','施工队经理']];
        $data = array_merge($tr,$data);
        $this->excel->create('team',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportBudgets()
    {
        $id = Input::get('id');
        $project = Project::find($id);
        $budgets = $project->budget()->get()->toArray();
        for ($i=0;$i<count($budgets);$i++){
            if ($budgets[$i]->type==1){
                $material = Material::find($budgets[$i]->material_id);
            }

        }
    }
    public function exportPayApplies()
    {
        $role = getRole('pay_list');
        if ($role=='all'){
            $data = PayApply::select(['number','price','use','project_number','project_content',
                'proposer','remark','approver','pay_date','cash','transfer','bank','account','other'])->orderBy('id','DESC')->get()->toArray();
        }elseif ($role=='only'){
            $data = PayApply::select(['number','price','use','project_number','project_content',
                'proposer','remark','approver','pay_date','cash','transfer','bank','account','other'])->where('proposer','=',Auth::user()->username)->orderBy('id','DESC')->get()->toArray();
        }else{
            $idArr = getRoleProject('pay_list');
            $data = PayApply::select(['number','price','use','project_number','project_content',
                'proposer','remark','approver','pay_date','cash','transfer','bank','account','other'])->whereIn('project_id',$idArr)->orderBy('id','DESC')->get()->toArray();
        }

        //
        for ($i=0;$i<count($data);$i++){
            $data[$i]['bank'] = $data[$i]['bank'].' '.$data[$i]['account'];
            unset($data[$i]['account']);
        }
        $tr = [['业务编号','付款金额','用途','项目编号','项目内容','申请人','备注',
            '审批人','付款日期','现金','转账','银行及账号','其他'
        ]];
        $data = array_merge($tr,$data);
        $this->excel->create('pay_applies',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportLoanPay()
    {

    }
    public function exportLoanSubmit()
    {
        $lists = LoanSubmit::select([
            'number',
            'type',
            'price',
            'project_id',
            'loan_user',
            'checker',
            'passer',
            'state',
            'FKNumber'
        ])->orderBy('id','DESC')->get()->toArray();
        for ($i=0;$i<count($lists);$i++){
            $lists[$i]['type'] = $lists[$i]['type']==2?'项目报销':'期间报销';
            if ($lists[$i]['project_id']!=0){
                $project = Project::find($lists[$i]['project_id']);
                $lists[$i]['project_number']=$project->number;
                $lists[$i]['project_content']=$project->name;
            }else{
                $lists[$i]['project_number']='';
                $lists[$i]['project_content']='';
            }
            $lists[$i]['state']=$lists[$i]['state']==4?'已付款':'未付款';
            unset($lists[$i]['project_id']);
        }
//        dd($lists);
        $tr = [['报销编号','类型','金额','报销人','复核人','审批人','付款状态','付款编号','项目编号','项目内容']];
        $data = array_merge($tr,$lists);
        $this->excel->create('报销申请清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportLoanPayList()
    {
        $lists = LoanPay::select([
            'id',
            'number',
            'applier',
            'price',
            'deduction',
            'cash',
            'transfer',
            'bank',
            'account',
            'worker'
        ])->get()->toArray();
        for ($i=0;$i<count($lists);$i++){
            $lists[$i]['bank'] = $lists[$i]['bank'].' '.$lists[$i]['account'];
            unset($lists[$i]['account']);
            $idArr = LoanPayList::where('pay_id','=',$lists[$i]['id'])->pluck('loan_id')->toArray();
            $lists[$i]['BXNumber'] = LoanSubmit::whereIn('id',$idArr)->pluck('number')->toArray();
            $lists[$i]['BXNumber'] = implode(',',$lists[$i]['BXNumber']);
            $lists[$i]['worker'] = User::find($lists[$i]['worker'])->username;
            unset($lists[$i]['id']);
        }
        //
        $tr = [['报销付款编号','报销人','付款金额','借款抵扣','现金付款','银行转账','付款银行及账号','经办人','报销编号']];
        $data = array_merge($tr,$lists);
        $this->excel->create('报销付款清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportLoanDetailList()
    {
        $name = Input::get('name');
        $s = Input::get('s');
        $e = Input::get('e');
        if (!$name||!$s){
            $lists = [];
        }else{
            $list1 = LoanList::where('borrower','=',$name)->where('state','=',3)->whereBetween('created_at',[$s,$e])->select(['number','price','apply_date as date','loanBalance','submitBalance','created_at'])->get()->toArray();
            $list2 = LoanSubmit::where('loan_user','=',$name)->where('state','>=',3)->whereBetween('created_at',[$s,$e])->select(['number','price','date','loanBalance','submitBalance','created_at'])->get()->toArray();
            $list3 = LoanPay::where('applier','=',$name)->whereBetween('created_at',[$s,$e])->select(['number','price','date','loanBalance','submitBalance','cash','transfer','deduction','created_at'])->get()->toArray();
            $swap = array_merge($list1,$list2);
            $lists = array_merge($swap,$list3);
            $swap4 = [];
            $swap1 = LoanList::where('borrower','=',$name)->where('state','=',3)->where('created_at','<',$s)->select(['number','price','apply_date as date','loanBalance','submitBalance','created_at'])->orderBy('id','DESC')->get()->toArray();
            if (!empty($swap1)){
                array_push($swap4,$swap1[0]);
            }
            $swap2 = LoanSubmit::where('loan_user','=',$name)->where('state','>=',3)->where('created_at','<',$s)->select(['number','price','date','loanBalance','submitBalance','created_at'])->orderBy('id','DESC')->get()->toArray();
            if (!empty($swap2)){
                array_push($swap4,$swap2[0]);
            }
            $swap3 = LoanPay::where('applier','=',$name)->where('created_at','<',$s)->select(['number','price','date','loanBalance','submitBalance','cash','transfer','deduction','created_at'])->orderBy('id','DESC')->get()->toArray();
            if (!empty($swap3)){
                array_push($swap4,$swap3[0]);
            }
//            $swap4 = [$swap1,$swap2,$swap3];
//            dd($swap4);
            if (!empty($swap4)){
                array_multisort(array_column($swap4,'created_at'),SORT_DESC,$swap4);
            }
//            dd($swap4);
            $startK = !empty($swap4)?$swap4[0]['loanBalance']:0;
            $loanStart = !empty($swap4)?$swap4[0]['submitBalance']:0;
            array_multisort(array_column($lists,'created_at'),SORT_ASC,$lists);
//            dd($lists);
        }
        $nTr = [['人员名称',$name,'开始日期',$s,'结束日期',$e]];
        $tr = [['日期','借款编号','借款金额','报销编号','报销金额	','付款编号','付款金额','其中：抵扣借款','其中：现金付款','其中：银行转账','未支付报销余额','借款余额']];
        $tr = array_merge($nTr,$tr);
        $start = [[
            'date'=>'期初',
            'JKNumber'=>'',
            'JKPrice'=>'',
            'BXNumber'=>'',
            'BXPrice'=>'',
            'FKNumber'=>'',
            'FKPrice'=>'',
            'deduction'=>'',
            'cash'=>'',
            'transfer'=>'',
            'submitBalance'=>number_format($loanStart,2),
            'loanBalance'=>number_format($startK,2)
        ]];
        $tr = array_merge($tr,$start);
        if (!empty($lists)){
            for ($i=0;$i<count($lists);$i++){
                if (strstr($lists[$i]['number'],'BXFK')){
                    $swap = [];
                    $swap['date'] = $lists[$i]['date'];
                    $swap['JKNumber'] = '';
                    $swap['JKPrice'] = '';
                    $swap['BXNumber'] = '';
                    $swap['BXPrice'] = '';
                    $swap['FKNumber'] = $lists[$i]['number'];
                    $swap['FKPrice'] = number_format($lists[$i]['price'],2);
                    $swap['deduction'] = number_format($lists[$i]['deduction'],2);
                    $swap['cash'] = number_format($lists[$i]['cash'],2);
                    $swap['transfer'] = number_format($lists[$i]['transfer'],2);
                    $swap['submitBalance'] = number_format($lists[$i]['submitBalance'],2);
                    $swap['loanBalance'] = number_format($lists[$i]['loanBalance'],2);
                }elseif (strstr($lists[$i]['number'],'JK')) {
                    $swap = [];
                    $swap['date'] = $lists[$i]['date'];
                    $swap['JKNumber'] = $lists[$i]['number'];
                    $swap['JKPrice'] = number_format($lists[$i]['price'],2);
                    $swap['BXNumber'] = '';
                    $swap['BXPrice'] = '';
                    $swap['FKNumber'] = '';
                    $swap['FKPrice'] = '';
                    $swap['deduction'] = '';
                    $swap['cash'] = '';
                    $swap['transfer'] = '';
                    $swap['submitBalance'] = number_format($lists[$i]['submitBalance'],2);
                    $swap['loanBalance'] = number_format($lists[$i]['loanBalance'],2);
                }else{
                    $swap = [];
                    $swap['date'] = $lists[$i]['date'];
                    $swap['JKNumber'] = '';
                    $swap['JKPrice'] = '';
                    $swap['BXNumber'] = $lists[$i]['number'];
                    $swap['BXPrice'] = number_format($lists[$i]['price'],2);
                    $swap['FKNumber'] = '';
                    $swap['FKPrice'] = '';
                    $swap['deduction'] = '';
                    $swap['cash'] = '';
                    $swap['transfer'] = '';
                    $swap['submitBalance'] = number_format($lists[$i]['submitBalance'],2);
                    $swap['loanBalance'] = number_format($lists[$i]['loanBalance'],2);
                }
                $lists[$i] = $swap;
            }
        }
        $data = array_merge($tr,$lists);
       // dd($data);
        $this->excel->create('报销明细清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                //dd($count);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportStockList()
    {
        $stock = Stock::orderBy('cost','DESC')->orderBy('id','DESC')->get();
        $tr = [['物料名称','性能与技术参数','品牌型号','生产厂家','单位','库存数量','库存金额','平均单价','仓库']];
        $data = [];
        if (!empty($stock)){
            for ($i=0;$i<count($stock);$i++){
                $swap = [];
                $material = $stock[$i]->material();
                $warehouse = $stock[$i]->warehouse();
                $swap['name'] = $material->name;
                $swap['param'] = $material->param;
                $swap['model'] = $material->model;
                $swap['factory'] = $material->factory;
                $swap['unit'] = $material->unit;
                $swap['number'] = $stock[$i]->number;
                $swap['cost'] = $stock[$i]->cost;
                $swap['price'] = $stock[$i]->number==0?0:sprintf('%.2f',$stock[$i]->cost/$stock[$i]->number);
                $swap['warehouse'] = $warehouse->name;
                $data[$i] = $swap;
            }
        }
        $data = array_merge($tr,$data);
        $this->excel->create('库存清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportProjectList()
    {
        $name = Input::get('search');
        $projectDb = DB::table('projects');
        $role = getRole('project_list');
//        dd($role);
        $tr = [['项目号','立项日期	','项目内容','项目经理','合同金额','实际金额','甲方','主合同金额','发包单位','分包合同金额','合同约定完工日期']];
        if ($role=='any'){
            $idArr = getRoleProject('project_list');
            $projectDb->whereIn('id',$idArr);
        }
        if ($name){
            $projectDb->where('number','like','%'.$name.'%')->orWhere('name','like','%'.$name.'%')->orWhere('PartyA','like','%'.$name.'%');
        }
        $data = [];
        $projects = $projectDb->orderBy('id','DESC')->get();
        for ($i=0;$i<count($projects);$i++){
            $swap = [];
            $swap['number'] = $projects[$i]->number;
            $swap['createTime'] = date('Y-m-d',$projects[$i]->createTime);
            $swap['content'] = $projects[$i]->name;
            $swap['manager'] = $projects[$i]->pm;
            $swap['price'] = number_format($projects[$i]->price);
            $swap['SJPrice'] = number_format(ProjectSituations::where('project_id','=',$projects[$i]->id)->sum('price'));
            $swap['partyA'] = $projects[$i]->PartyA;
            $swap['main'] = number_format(ProjectSituations::where('project_id','=',$projects[$i]->id)->where('type','=',1)->sum('price'));
            $unit = OutContract::where('project_id','=',$projects[$i]->id)->pluck('unit')->toArray();
            $swap['unit'] = implode('|',$unit);
            $swap['pit'] = number_format(ProjectSituations::where('project_id','=',$projects[$i]->id)->where('type','=',2)->sum('price'));
            $swap['finishTime'] = date('Y-m-d',$projects[$i]->finishTime);
            $data[$i] = $swap;
        }
        $data = array_merge($tr,$data);
        $this->excel->create('已立项清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportProjectDetail()
    {
        $search = Input::get('search');
        $role = getRole('project_detail');
        if ($role=='any'){
            $idArr = getRoleProject('project_detail');
            $db = Project::whereIn('id',$idArr);
            if ($search){
                $db->where('name','like','%'.$search.'%')->where('number','=','%'.$search.'%');
            }
            $data = $db->orderBy('id','DESC')->get();
        }else{
            if ($search){
                $data = Project::where('name','like','%'.$search.'%')->where('number','=','%'.$search.'%')->orderBy('id','DESC')->get();
            }else{
                $data = Project::orderBy('id','DESC')->get();
            }
        }
        $all = [];
        if (!empty($data)){
            for ($i=0;$i<count($data);$i++){
                $swap = [];
                $swap['a'] = $data[$i]->number;
                $swap['b'] = $data[$i]->name;
                $swap['c'] = $data[$i]->pm;
                $swap['d'] = date('Y-m-d',$data[$i]->finishTime);
                $swap['e'] = $data[$i]->acceptance_date;
                $swap['f'] = $data[$i]->deadline;
                $swap['g'] = number_format($data[$i]->price,2);
                $swap['h'] = number_format($data[$i]->situation()->sum('price'),2);
                $swap['i'] = number_format($data[$i]->situation()->where('type','=',1)->sum('price'),2);
                $swap['j'] = number_format($data[$i]->situation()->where('type','=',2)->sum('price'),2);
                $swap['k'] = number_format($data[$i]->situation()->sum('price')-$data[$i]->collects()->where('type','=',2)->sum('price')-$data[$i]->collects()->where('type','=',3)->sum('price'),2);
                $swap['l'] = number_format($data[$i]->situation()->where('type','=',1)->sum('price')-$data[$i]->collects()->where('type','=',2)->sum('price'),2);
                $swap['m'] = number_format($data[$i]->situation()->where('type','=',2)->sum('price')-$data[$i]->collects()->where('type','=',3)->sum('price'),2);
                $swap['n'] = number_format($data[$i]->invoices()->sum('price')-$data[$i]->collects()->where('type','=',2)->sum('price')-$data[$i]->collects()->where('type','=',3)->sum('price'),2);
                $swap['o'] = number_format($data[$i]->invoices()->sum('price'),2);
                $swap['p'] = number_format($data[$i]->collects()->where('type','=',2)->sum('price'),2);
                $swap['q'] = number_format($data[$i]->collects()->where('type','=',3)->sum('price'),2);
                $swap['r'] = number_format($data[$i]->stockRecords()->where('type','=',3)->sum('cost')+$data[$i]->requestPayments()->where('state','=',3)->sum('price')+$data[$i]->loanSubmits()->where('state','>',3)->sum('price')+$data[$i]->payApplies()->sum('price')-$data[$i]->costs()->where('state','>=',2)->sum('apply_price')-$data[$i]->stockRecords()->where('type','=',2)->sum('cost'),2);
                $swap['s'] = number_format($data[$i]->stockRecords()->where('type','=',3)->sum('cost'),2);
                $swap['t'] = number_format($data[$i]->requestPayments()->where('state','=',3)->sum('price'),2);
                $swap['u'] = number_format($data[$i]->loanSubmits()->where('state','>',3)->sum('price'),2);
                $swap['v'] = number_format($data[$i]->payApplies()->sum('price')+$data[$i]->costs()->where('state','>=',2)->sum('apply_price'),2);
                $swap['w'] = number_format($data[$i]->stockRecords()->where('type','=',2)->sum('cost'),2);
                $all[$i] = $swap;
            }
        }
        $tr = [[
            '项目号','项目内容','项目经理','约定完工日期','验收日期','保修截至日期','合同金额','项目实际金额',
            '主合同金额','分包合同金额','项目剩余未收款','主合同未收款','分包合同未收款','应收账款','已开票请款','主合同收款',
            '分包合同收款','已发生成本','领料成本','施工成本','报销项目成本	','费用其他成本','退料成本'
        ]];
        $all = array_merge($tr,$all);
        $this->excel->create('项目明细清单',function ($excel) use ($tr,$all){
            $excel->sheet('sheet1',function ($sheet) use ($all){
                $count = count($all);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$all[$j]);
                }
            });
        })->export('xls');
    }
    public function exportBudgetList()
    {
        $search = Input::get('search');
        $role = getRole('budget_list');
        if ($role=='all'){
            if ($search){
                $projects = Project::where('name','like','%'.$search.'%')->orWhere('number','like','%'.$search.'%')->orderBy('id','DESC')->get();
            }else{
                $projects = Project::orderBy('id','DESC')->get();
            }
        }else{
            $idArr = getRoleProject('budget_list');
            $db = Project::whereIn('id',$idArr);
            if ($search){
                $db->where('name','like','%'.$search.'%')->orWhere('number','like','%'.$search.'%');
            }
            $projects = $db->orderBy('id','DESC')->get();
        }
        $data = [];
        if (!empty($projects)){
            foreach ($projects as $project){
                $swap = [];
                $materialId = Category::where('title','=','材料')->where('state','=',1)->pluck('id')->first();
                $idArr = $project->loanSubmits()->where('state','>',2)->pluck('id')->toArray();
                $materialCount = LoanSubmitList::whereIn('loan_id',$idArr)->where('category_id','=',$materialId)->sum('price');
                $engineId = Category::where('title','=','工程款')->where('state','=',1)->pluck('id')->first();
                $engineCount = LoanSubmitList::whereIn('loan_id',$idArr)->where('category_id','=',$engineId)->sum('price');
                $otherCount = LoanSubmitList::whereIn('loan_id',$idArr)->where('category_id','!=',$materialId)->where('category_id','!=',$engineId)->sum('price');
                $project->materialCount = $materialCount;
                $project->engineCount = $engineCount;
                $project->otherCount = $otherCount;
//                dd($project);
                $swap['a'] = $project->number;
                $swap['b'] = $project->name;
                $swap['c'] = $project->pm;
                $swap['d'] = $project->situation()->sum('price');
                $swap['e'] = $project->situation()->where('type','=',1)->sum('price');
                $swap['f'] = $project->situation()->where('type','=',2)->sum('price');
                $swap['g'] = $project->budget()->sum('cost');
                $swap['h'] = $project->budget()->where('type','=',1)->sum('cost');
                $swap['i'] = $project->budget()->where('type','=',2)->sum('cost');
                $swap['j'] = $project->budget()->where('type','=',3)->sum('cost');
                $swap['k'] = $project->stockRecords()->where('type','=',3)->sum('cost')+$project->requestPayments()->where('state','=',3)->sum('price')+$project->loanSubmits()->where('state','>',3)->sum('price')+$project->payApplies()->sum('price')+$project->costs()->where('state','>=',2)->sum('apply_price')-$project->stockRecords()->where('type','=',2)->sum('cost');
                $swap['l'] = $project->stockRecords()->where('type','=',3)->sum('cost');
                $swap['m'] = $project->requestPayments()->where('state','=',3)->sum('price');
                $swap['n'] = $project->materialCount;
                $swap['o'] = $project->engineCount;
                $swap['p'] = $project->otherCount;
                $swap['q'] = $project->payApplies()->sum('price')+$project->costs()->where('state','>=',2)->sum('apply_price');
                $swap['r'] = $project->stockRecords()->where('type','=',2)->sum('cost');
                $swap['s'] = $project->stockRecords()->where('type','=',3)->sum('cost')+$project->requestPayments()->where('state','=',3)->sum('price')+$project->loanSubmits()->where('state','>',3)->sum('price')+$project->payApplies()->sum('price')+$project->costs()->where('state','>=',2)->sum('apply_price')-$project->stockRecords()->where('type','=',2)->sum('cost').'/'.$project->budget()->sum('cost');
                $swap['t'] = $project->stockRecords()->where('type','=',3)->sum('cost')+$project->materialCount-$project->stockRecords()->where('type','=',2)->sum('cost').'/'.$project->budget()->where('type','=',1)->sum('cost');
                $swap['u'] = $project->requestPayments()->where('state','=',3)->sum('price')+$project->engineCount.'/'.$project->budget()->where('type','=',2)->sum('cost');
                $swap['v'] = $project->otherCount+$project->payApplies()->sum('price')+$project->costs()->where('state','>=',2)->sum('apply_price').'/'.$project->budget()->where('type','=',3)->sum('cost');
                array_push($data,$swap);
            }
        }

        $tr = [[
            '项目号','项目内容','项目经理','项目实际金额','主合同金额','分包合同金额','预算总额',
            '物料采购金额','工程金额','其他','已发生成本','领料成本','施工成本','报销材料款','报销工程款',
            '报销其他费用','费用付款其他成本','退料成本','总成本 / 预算','物料实际成本 / 预算','工程实际成本 / 预算',
            '其他成本 / 预算'
        ]];
        $data = array_merge($tr,$data);
        $this->excel->create('预算清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
//        dd($projects);
    }
    public function exportProjectBudget()
    {
        $project_id = Input::get('project_id');
        $project = Project::find($project_id);
        $budgets = $project->budget()->get()->toArray();
        dd($budgets);
    }
    public function exportPurchaseCollect()
    {
        $value = Input::get('search');

        $tr = [['采购日期	','采购编号','预算内/外','供货商','物料名称','性能及技术','品牌型号','生产厂家','单位','单价','数量','金额','保修截止日期']];
        if ($value){
            $project = Project::where('name','=',$value)->orWhere('number','=',$value)->first();
            $pTr = [['项目编号',$project->number,'项目内容',$project->name,'项目保修截止日期',$project->deadline]];
            $tr = array_merge($pTr,$tr);
            $idArr = $project->purchases()->where('state','=',3)->pluck('id')->toArray();
            $lists = PurchaseList::whereIn('purchase_id',$idArr)->get();
        }else{
            $lists = [];
        }
        $data = [];
        if(!empty($lists)){
            for ($i=0;$i<count($lists);$i++){
                $swap = [];
                $purchase = Purchase::find($lists[$i]->purchase_id);
                $material = Material::find($lists[$i]->material_id);
                $swap['date'] = $purchase->date;
                $swap['number'] = $purchase->number;
                $swap['type'] = $purchase->type==1?'内':'外';
                $swap['supplier'] = $purchase->supplier;
                $swap['material_name'] = $material->name;
                $swap['material_param'] = $material->param;
                $swap['material_model'] = $material->model;
                $swap['material_factory'] = $material->factory;
                $swap['material_unit'] = $material->unit;
                $swap['price'] = $lists[$i]->price;
                $swap['sum'] = $lists[$i]->number;
                $swap['cost'] = $lists[$i]->cost;
                $swap['warranty_date'] = $lists[$i]->warranty_date;
                $data[$i] = $swap;
            }
        }
        $data = array_merge($tr,$data);
        $this->excel->create('项目采购物料清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportBuildList()
    {
        $role = getRole('build_list');
        if ($role=='all'){
            $id = RequestPayment::where('state','=',3)->pluck('project_team')->toArray();
            $lists = ProjectTeam::whereIn('id',$id)->get();
        }else{
            $idArr = getRoleProject('build_list');
            $numberArr = Project::whereIn('id',$idArr)->pluck('number')->toArray();
            $id = RequestPayment::where('state','=',3)->whereIn('project_number',$numberArr)->pluck('project_team')->toArray();
            $lists = ProjectTeam::whereIn('id',$id)->get();
        }
        $data = [];
        if (!empty($lists)){
            for ($i=0;$i<count($lists);$i++){
                $swap = [];
                $swap['team'] = $lists[$i]->team;
                $swap['manager'] = $lists[$i]->manager;
                $swap['project_number'] = $lists[$i]->project_number;
                $swap['project_content'] = $lists[$i]->project_content;
                $swap['project_manager'] = $lists[$i]->project_manager;
                $swap['payments'] = $lists[$i]->payments()->where('state','=',3)->sum('price');
                $swap['pay_payments'] = $lists[$i]->applies()->where('state','=',4)->sum('apply_price');
                $swap['need_pay'] = $lists[$i]->payments()->where('state','=',3)->sum('price')-$lists[$i]->applies()->where('state','=',4)->sum('apply_price');
                $swap['invoices'] = $lists[$i]->invoices()->sum('with_tax');
                $swap['need_invoice'] = $lists[$i]->applies()->where('state','=',4)->sum('apply_price')-$lists[$i]->invoices()->sum('with_tax');
                $swap['state'] = $lists[$i]->payments()->where('state','=',3)->sum('price')-$lists[$i]->applies()->where('state','=',4)->sum('apply_price')!=0?'未结清':'已结清';
                $data[$i] = $swap;
            }
        }
//        dd($lists);
        $tr = [['施工队','施工经理','项目编号','项目内容','项目经理','已完工请款','已付款','应付账款','已收票','未收票','系统状态']];
        $data = array_merge($tr,$data);
        $this->excel->create('施工费清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportBuildFinishList()
    {
        $role = getRole('build_finish_list');
        if ($role == 'all') {
            $applies = RequestPayment::orderBy('id', 'DESC')->get();
        } else {
            $idArr = getRoleProject('build_finish_list');
            $numberArr = Project::whereIn('id', $idArr)->pluck('number')->toArray();
            $applies = RequestPayment::whereIn('project_number', $numberArr)->orderBy('id', 'DESC')->get();
        }

        $data = [];
        if (!empty($applies)) {
            for ($i = 0; $i < count($applies); $i++) {
                $swap = [];
                $swap['number'] = $applies[$i]->number;
                $swap['team'] = $applies[$i]->team;
                $swap['manager'] = $applies[$i]->manager;
                $swap['project_number'] = $applies[$i]->project_number;
                $swap['project_content'] = $applies[$i]->project_content;
                $swap['project_manager'] = $applies[$i]->project_manager;
                $swap['price'] = $applies[$i]->price;
                $swap['applier'] = $applies[$i]->applier;
                $swap['checker'] = empty($applies[$i]->checker) ? '未复核' : $applies[$i]->checker;
                $swap['passer'] = empty($applies[$i]->passer) ? '未审批' : $applies[$i]->passer;
                $data[$i] = $swap;
            }
        }
        $tr = [['请款编号', '施工队', '施工经理', '	项目编号', '项目内容', '	项目经理', '请款金额', '	经办人', '复核人', '审核人']];
        $data = array_merge($tr,$data);
        $this->excel->create('完工请款清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportBuildPayList()
    {
        $role = getRole('build_pay_list');
        if ($role=='all'){
            $id = RequestPayment::where('state','=',3)->pluck('project_team')->toArray();
            $lists = ProjectTeam::whereIn('id',$id)->orderBy('id','DESC')->get();
        }else{
            $idArr = getRoleProject('build_pay_list');
            $id = RequestPayment::where('state','=',3)->pluck('project_team')->toArray();
            $lists = ProjectTeam::whereIn('id',$id)->whereIn('project_id',$idArr)->orderBy('id','DESC')->get();
        }
        $data = [];
        if (!empty($lists)){
            for ($i=0;$i<count($lists);$i++){
                $swap = [];
                $swap['team'] = $lists[$i]->team;
                $swap['manager'] = $lists[$i]->manager;
                $swap['project_number'] = $lists[$i]->project_number;
                $swap['project_content'] = $lists[$i]->project_content;
                $swap['project_manager'] = $lists[$i]->project_manager;
                $swap['payments'] = $lists[$i]->price;
                $swap['apply'] = $lists[$i]->applies()->where('state','>=',3)->sum('apply_price');
                $swap['pay'] = $lists[$i]->applies()->where('state','=',4)->sum('apply_price');
                $swap['need'] = number_format($lists[$i]->payments()->where('state','>=',3)->sum('price')-$lists[$i]->applies()->where('state','=',4)->sum('apply_price'),2);
                $data[$i] = $swap;
            }
        }
//        dd($lists);

        $tr =[['施工队','施工经理','项目编号','	项目内容','项目经理','	已完工请款','	已申请付款','	已付款','应付账款']];
        $data = array_merge($tr,$data);
        $this->excel->create('施工付款清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function importPayment(Request $post)
    {
        $file = $post->file('file');
        if ($file){
            $list = [];
            $this->excel->selectSheetsByIndex(0)->load($file,function ($sheet) use (&$list){
                $sheet->ignoreEmpty()->each(function ($data) use (&$list){
                    $origin = $data->toArray();
//                    dd($origin);
//                    $origin = array_values($origin);
//                    dd($origin);
                    $swap = [];
                    $swap['name'] = isset($origin['设备名称'])?$origin['设备名称']:'';
                    $swap['param'] = isset($origin['性能参数'])?$origin['性能参数']:'';
                    $swap['unit'] = isset($origin['单位'])?$origin['单位']:'';
                    $swap['number'] = isset($origin['数量'])?$origin['数量']:'';
                    $swap['price'] = isset($origin['含税单价'])?$origin['含税单价']:0;
                    $swap['remark'] = isset($origin['备注'])?$origin['备注']:'';
//                    dd($swap);
                    array_push($list,$swap);
//                    dd($origin);
                });
            });
//            dd($list);
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS',
                'data'=>$list

            ]);
//            dd($file);
        }else{
            return response()->json([
                'code'=>'400',
                'msg'=>'空文件'
            ]);
        }
    }
    public function importBudget(Request $post)
    {
//        dd($post);
//        return redirect()->back()->with('status','dadf');
        $project_id = $post->project_id;
        $file = $post->file('file');
        if ($file){
//            $this->excel->load($file,function ($reader){
//               dd($reader->ignoreEmpty()->all());
//            });
            DB::beginTransaction();
            try{
                Budget::where('project_id','=',$project_id)->delete();
            $this->excel->selectSheetsByIndex(0)->load($file,function ($sheet) use($project_id){
//               dd($sheet);

                    $sheet->ignoreEmpty()->each(function ($data) use ($project_id){
                        $origin = $data->toArray();
//                        var_dump($origin);
//                        dd($origin);
//                        $origin = array_values($origin);
//                        dd($origin);
                        if (!empty($origin)){
                            if ($origin['物料名称']){
                                $budget = new Budget();
                                $budget->project_id = $project_id;
                                if ($origin['物料工程其他']=='物料') {
                                    $material = Material::where('state','=',1)->
                                    where('name','=',$origin['物料名称'])->where('param','=',$origin['性能及技术参数'])->
                                    where('model','=',$origin['品牌型号'])->where('factory','=',$origin['生产厂家'])
                                        ->where('unit','=',$origin['单位'])->first();
                                    if (empty($material)){
                                        $material = new Material();
                                        $material->name = $origin['物料名称'];
                                        $material->param = $origin['性能及技术参数'];
                                        $material->model = $origin['品牌型号'];
                                        $material->factory = $origin['生产厂家'];
                                        $material->unit = $origin['单位'];
                                        $material->save();
                                    }
                                    $budget->material_id = $material->id;
                                    $budget->name = $material->name;
                                    $budget->param = $material->param;
                                    $budget->model = $material->model;
                                    $budget->factory = $material->factory;
                                    $budget->unit = $material->unit;
                                    $budget->type = 1;
//                                dd($origin);
                                }elseif($origin['物料工程其他']=='工程'){
                                    $budget->name = empty($origin['物料名称'])?'无':(string)$origin['物料名称'];
                                    $budget->param = empty($origin['性能及技术参数'])?'无':(string)$origin['性能及技术参数'];
                                    $budget->model = empty($origin['品牌型号'])?'无':(string)$origin['品牌型号'];
                                    $budget->factory = empty($origin['生产厂家'])?'无':(string)$origin['生产厂家'];
                                    $budget->unit = empty($origin['单位'])?'无':(string)$origin['单位'];
                                    $budget->type = 2;
                                }else{
                                    $budget->name = empty($origin['物料名称'])?'无':(string)$origin['物料名称'];
                                    $budget->param = empty($origin['性能及技术参数'])?'无':(string)$origin['性能及技术参数'];
                                    $budget->model = empty($origin['品牌型号'])?'无':(string)$origin['品牌型号'];
                                    $budget->factory = empty($origin['生产厂家'])?'无':(string)$origin['生产厂家'];
                                    $budget->unit = empty($origin['单位'])?'无':(string)$origin['单位'];
                                    $budget->type = 3;
                                }
                                $budget->price = $origin['单价'];
                                $budget->number = $origin['数量'];
                                $budget->need_buy = $origin['数量'];
                                $budget->cost = $origin['金额'];
                                $budget->save();
                            }

                        }

//                   var_dump($origin);
                    });


            });
                DB::commit();
                return redirect()->back()->with('status','导入成功!');
//                    return 'DDDD';
//                    return view()
//                    return redirect()->to()->with('status','导入成功！');
//                    return redirect('budget/detail?id='.$project_id);
//                    return redirect('budget/detail?id='.$project_id)->with('status','导入成功！');
            }catch (\Exception $exception){
//                    dd($exception->getMessage());
                DB::rollback();
                return redirect()->back()->with('status','数据格式错误');
//                    return redirect('budget/detail?id='.$project_id)->with('status','数据格式错误！');
            }
        }else{
            return redirect()->back()->with('status','空文件!');
        }

    }

    public function importPurchase(Request $post)
    {
//        dd($post);
//        return redirect()->back()->with('status','dadf');
//        $project_id = $post->project_id;
        $file = $post->file('file');
        if ($file) {
//            $this->excel->load($file,function ($reader){
//               dd($reader->ignoreEmpty()->all());
//            });
//            DB::beginTransaction();

            $purchaseData = [];

            $this->excel->selectSheetsByIndex(0)->load($file,function ($sheet) use (&$purchaseData){
//               dd($sheet);

                $sheet->ignoreEmpty()->each(function ($data) use (&$purchaseData) {
                    $origin = $data->toArray();
//                        var_dump($origin);
//                        dd($origin);
//                        $origin = array_values($origin);
//                        dd($origin);
                    $item = [];
                    if (!empty($origin)){
                        if ($origin['物料名称']){
//                            dd($origin);
                            $material = Material::where('state','=',1)->
                            where('name','=',$origin['物料名称'])->where('param','=',$origin['性能及技术参数'])->
                            where('model','=',$origin['品牌型号'])->where('factory','=',$origin['生产厂家'])
                                ->where('unit','=',$origin['单位'])->first();
                            if (empty($material)){
                                $material = new Material();
                                $material->name = $origin['物料名称'];
                                $material->param = $origin['性能及技术参数'];
                                $material->model = $origin['品牌型号'];
                                $material->factory = $origin['生产厂家'];
                                $material->unit = $origin['单位'];
                                $material->save();
                            }
                            $item['id'] = $material->id;
                            $item['name'] = $material->name;
                            $item['param'] = $material->param;
                            $item['model'] = $material->model;
                            $item['factory'] = $material->factory;
                            $item['unit'] = $material->unit;
                            $item['price'] = $origin['单价'];
                            $item['number'] = $origin['数量'];
                            $item['cost'] = $origin['金额'];
//                            dd($item);
                            array_push($purchaseData,$item);
//                            dd($purchaseData);
                        }

                    }

//                   var_dump($origin);
                });

            });
//            dd($purchaseData);
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS',
                'data'=>$purchaseData
            ]);
        }
        return response()->json([
            'code'=>'400',
            'msg'=>'空文件!'
        ]);

    }

    public function exportBudget()
    {
        $id = Input::get('id');
        $list = Budget::where('project_id','=',$id)->get();
        $tr = [['物料名称','性能及技术参数','品牌型号','生产厂家','单位','单价','数量','金额','物料/工程/其他']];
        $data = [];
        if (!empty($list)){
            for ($i=0;$i<count($list);$i++){
                if ($list[$i]->type==1){
                    $type = '物料';
                }elseif ($list[$i]->type ==2){
                    $type = '工程';
                }else{
                    $type = '其他';
                }
                $swap = [];
                $swap['name'] = $list[$i]->name;
                $swap['param'] = $list[$i]->param;
                $swap['model'] = $list[$i]->model;
                $swap['factory'] = $list[$i]->factory;
                $swap['unit'] = $list[$i]->unit;
                $swap['price'] = $list[$i]->price;
                $swap['number'] = $list[$i]->number;
                $swap['cost'] = $list[$i]->cost;
                $swap['type'] = $type;
                $data[$i] = $swap;
            }
        }
        $data = array_merge($tr,$data);
        $this->excel->create('预算清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportPurchaseList()
    {
        $role = getRole('buy_list');
        $db = Purchase::where('state','=',3);
//        $search = Input::get('search');
        if ($role=='any'){
            $idArr = getRoleProject('buy_list');
            $db->whereIn('project_id',$idArr);
        }
        $list = $db->orderBy('id','DESC')->get();
        $tr = [[
            '采购编号','供货商','采购金额','项目编号','项目内容','项目经理','预算内/外','已收货','未收货',
            '已付款','应付账款','发票条件','已收票','未收票','项目状态'
        ]];
        $data = [];
        if (!empty($list)){
            foreach ($list as $item){
                $swap = [];
                $project = Project::find($item->project_id);
                $swap['number'] = $item->number;
                $swap['supplier'] = $item->supplier;
                $swap['cost'] = $item->lists()->sum('cost');
                $swap['project_number'] = $project?$project->number:'';
                $swap['project_content'] = $project?$project->name:'';
                $swap['project_manager'] = $project?$project->pm:'';
                $swap['type'] = $item->type==1?'内':'外';
                $received = 0;
                $need = 0;
                $swapData  = $item->lists()->get();
                if (count($swapData)!=0){
                    foreach ($swapData as $datum){
                        $received+= $datum->price*$datum->received;
                        $need+= $datum->price*$datum->need;
                    }
                }
//                $list->received = $received;
//                $list->need = $need;
                $swap['buy'] = $received;
                $swap['need'] = $need;
                $swap['pay'] = number_format($item->payments()->sum('pay_price'));
                $swap['need_pay'] = $item->lists()->sum('cost')-$item->payments()->sum('pay_price');
                $swap['content'] = $item->content;
                $swap['invoices'] = $item->invoices()->sum('with_tax');
                $swap['unInvoices'] = $item->payments()->sum('pay_price')-$item->invoices()->sum('with_tax');
                $swap['state'] = $item->lists()->sum('cost')-$item->payments()->sum('pay_price')==0?'已结清':'未结清';
                array_push($data,$swap);
            }
        }
        $data = array_merge($tr,$data);
        $this->excel->create('采购清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportPurchasePayList()
    {
        $role = getRole('buy_list');
        $db = Purchase::where('state','=',3);
        if ($role=='any'){
            $idArr = getRoleProject('buy_list');
            $lists = $db->whereIn('project_id',$idArr)->orderBy('id','DESC')->get();
        }else{
            $lists = $db->orderBy('id','DESC')->get();
        }
        $data = [];
        $tr = [[
            '采购编号','供货商','采购金额','项目编号','项目内容','项目经理','已付款','应付账款','系统状态','操作状态'
        ]];
        if (!empty($lists)){
            foreach ($lists as $list){
                $swap = [];
                $project = Project::find($list->project_id);
                $swap['number'] = $list->number;
                $swap['supplier'] = $list->supplier;
                $swap['cost'] = $list->lists()->sum('cost');
                $swap['project_number'] = $project?$project->number:'';
                $swap['project_content'] = $project?$project->name:'';
                $swap['project_manager'] = $project?$project->pm:'';
                $swap['pay'] = number_format($list->payments()->sum('pay_price'));
                $swap['need'] = $list->lists()->sum('cost')-$list->payments()->sum('pay_price');
                $count = $list->payments()->where('state','=',2)->count();
                $swap['payState'] = $list->lists()->sum('cost')-$list->payments()->sum('pay_price')==0?'已结清':'未结清';
                $swap['handle'] = $count==0?'':'待处理';
                array_push($data,$swap);
            }
        }
        $data = array_merge($tr,$data);
        $this->excel->create('采购付款清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportPurchaseChargeList()
    {
        $role = getRole('buy_list');
        $db = Purchase::where('state','=',3);
        if ($role=='any'){
            $idArr = getRoleProject('buy_list');
            $purchases = $db->whereIn('project_id',$idArr)->orderBy('id','DESC')->get();
        }else{
            $purchases = $db->orderBy('id','DESC')->get();
        }
        $data = [];
        $tr =[[
            '采购编号','供货商','采购金额','项目编号','项目内容','项目经理','发票条件','已收票','未收票','系统状态'
        ]];
        if (!empty($purchases)){
            foreach ($purchases as $purchase){
                $swap = [];
                $project = Project::find($purchase->project_id);
                $swap['number'] = $purchase->number;
                $swap['supplier'] = $purchase->supplier;
                $swap['cost'] = $purchase->lists()->sum('cost');
                $swap['project_number'] = $project?$project->number:'';
                $swap['project_content'] = $project?$project->name:'';
                $swap['project_manager'] = $project?$project->pm:'';
                $swap['content'] = $purchase->content;
                $swap['invoices'] = $purchase->invoices()->sum('with_tax');
                $swap['unInvoices'] = $purchase->lists()->sum('cost')-$purchase->invoices()->sum('with_tax');
                $swap['state'] = $purchase->lists()->sum('cost')-$purchase->invoices()->sum('with_tax')==0?'已结清':'未结清';
                array_push($data,$swap);
            }
        }
        $data = array_merge($tr,$data);
        $this->excel->create('采购收票清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportPurchaseParityList()
    {
        $id = Input::get('material_id');
        $start = Input::get('s');
        $end = Input::get('e');
        if (!empty($start)){
            $lists = PurchaseList::where('material_id','=',$id)->whereDate('created_at','>=',$start)
                ->whereDate('created_at','<=',$end)->get();
        }else{
            $lists = [];
        }
        $material = Material::find($id);
        $mTr = [['物料名称','性能及技术参数','型号','生产商家','单位','开始时间','结束时间']];
        $mData = [[
            'name'=>$material->name,
            'param'=>$material->param,
            'model'=>$material->model,
            'factory'=>$material->factory,
            'unit'=>$material->unit,
            'start'=>$start,
            'end'=>$end
        ]];
        $mTr  = array_merge($mTr,$mData);
//        dd($mTr);
//        dd($lists);
        $data = [];
        if (!empty($lists)){
            foreach ($lists as $list){
                $swap = [];
                $list->purchase = Purchase::find($list->purchase_id);
                $swap['date'] = $list->purchase->date;
                $swap['number'] = $list->purchase->number;
                $swap['supplier'] = $list->purchase->supplier;
                $swap['content'] = $list->purchase->content;
                $swap['payContent'] = $list->purchase->condition;
                $swap['sum'] = $list->number;
                $swap['price'] = $list->price;
                $swap['time'] = $list->warranty_time;
                array_push($data,$swap);
            }
        }
        $tr = [[
           '采购日期','采购编号','供货商','发票条件','付款条件','数量','单价','保修时间'
        ]];
        $tr = array_merge($mTr,$tr);
        $data = array_merge($tr,$data);
//        dd($data);
        $this->excel->create('物料采购比价清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportStockBuyList()
    {
        $role = getRole('stock_buy_list');
        $db = Purchase::where('state','=',3);
        $data = [];
        if ($role=='any'){
            $idArr = getRoleProject('stock_buy_list');
            $lists = $db->whereIn('project_id',$idArr)->orderBy('id','DESC')->get();
        }else{
            $lists = $db->orderBy('id','DESC')->get();
        }
        if (!empty($lists)){
            foreach ($lists as $list){
                $received = 0;
                $need = 0;
                $swap = $list->lists()->get();
                for ($i=0;$i<count($swap);$i++){
                    $received += $swap[$i]->price * $swap[$i]->received;
                    $need += $swap[$i]->price * $swap[$i]->need;
                }
                $swap = [];
                $project = Project::find($list->project_id);
                $swap['number'] = $list->number;
                $swap['supplier'] = $list->supplier;
                $swap['cost'] = $list->lists()->sum('cost');
                $swap['project_number'] = $project?$project->number:'';
                $swap['project_content'] = $project?$project->name:'';
                $swap['project_manager'] = $project?$project->pm:'';
                $swap['receive'] = $received;
                $swap['need'] = $need;
                $swap['state'] = $need==0?'已结清':'未结清';
                array_push($data,$swap);
            }
        }
        $tr = [[
            '采购编号','供货商','采购金额','项目编号','项目内容','项目经理','已收货','未收货','系统状态'
        ]];
        $data = array_merge($tr,$data);
//        dd($data);
        $this->excel->create('采购收货入库清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportStockReturnList()
    {
        $data = [];

        $role = getRole('stock_return_list');
        if ($role=='all'){
            $id_arr = StockRecord::where('type','=',2)->pluck('id')->toArray();
            $lists = StockRecordList::whereIn('record_id',$id_arr)->paginate(10);
        }else{
            $idArr = getRoleProject('stock_return_list');
            $id_arr = StockRecord::where('type','=',2)->pluck('id')->toArray();
            $lists = StockRecordList::whereIn('record_id',$id_arr)->whereIn('project_id',$idArr)->paginate(10);
        }
        $tr = [[
            '退料编号	','物料名称','性能与技术参数','型号','生产厂家','单位','退料数量','退料单价','退料金额','项目编号',
            '项目内容	','项目经理','退料人','入库仓库	','收货人'
        ]];
        if (!empty($lists)){
            foreach ($lists as $list){
                $list->material = $list->material()->first();
                $list->record = $list->record()->first();
                $swap = [];
                $swap['number'] = $list->record->number;
                $swap['name'] = $list->material->name;
                $swap['param'] = $list->material->param;
                $swap['model'] = $list->material->model;
                $swap['factory'] = $list->material->factory;
                $swap['unit'] = $list->material->unit;
                $swap['sum'] = $list->sum;
                $swap['price'] = $list->price;
                $swap['cost'] = $list->cost;
                $swap['project_number'] = $list->record->project_number;
                $swap['project_content'] = $list->record->project_content;
                $swap['project_manager'] = $list->record->project_manager;
                $swap['returnee'] = $list->record->worker;
                $swap['warehouse'] = $list->record->warehouse;
                $swap['worker'] = $list->record->returnee;
                array_push($data,$swap);
            }
        }
//        dd($data);
        $data = array_merge($tr,$data);
        $this->excel->create('退料入库清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportStockGetList()
    {
        $data = [];
        $role = getRole('stock_get_list');
        if ($role =='all'){
            $id_arr = StockRecord::where('type','=',3)->pluck('id')->toArray();
            $lists = StockRecordList::whereIn('record_id',$id_arr)->orderBy('id','DESC')->get();
        }else{
            $idArr = getRoleProject('stock_get_list');
            $id_arr = StockRecord::where('type','=',3)->whereIn('project_id',$idArr)->pluck('id')->toArray();
            $lists = StockRecordList::whereIn('record_id',$id_arr)->orderBy('id','DESC')->get();
        }
        $tr = [[
            '领料编号	','出库仓库','物料名称	','性能与技术参数','型号','厂家','单位','库存均价','领料数量','领料金额','项目编号',
            '项目内容','项目经理','领料人'
        ]];
        if (!empty($lists)){
            foreach ($lists as $list){
                $swap = [];
                $list->material = $list->material()->first();
                $list->record = $list->record()->first();
                $swap['number'] = $list->record->number;
                $swap['warehouse'] = $list->record->warehouse;
                $swap['name'] = $list->material->name;
                $swap['param'] = $list->material->param;
                $swap['model'] = $list->material->model;
                $swap['factory'] = $list->material->factory;
                $swap['unit'] = $list->material->unit;
                $swap['price'] = $list->price;
                $swap['sum'] = $list->sum;
                $swap['cost'] = $list->cost;
                $swap['project_number'] = $list->record->project_number;
                $swap['project_content'] = $list->record->project_content;
                $swap['project_manager'] = $list->record->project_manager;
                $swap['worker'] = $list->record->worker;
                array_push($data,$swap);
            }
        }
        $data = array_merge($tr,$data);
        $this->excel->create('领料出库清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportStockOutList()
    {
        $data =[];
        $role = getRole('stock_out_list');
        if ($role =='all'){
            $id_arr = StockRecord::where('type','=',4)->pluck('id')->toArray();
            $lists = StockRecordList::whereIn('record_id',$id_arr)->paginate(10);
        }else{
            $idArr = getRoleProject('stock_get_list');
            $id_arr = StockRecord::where('type','=',4)->whereIn('project_id',$idArr)->pluck('id')->toArray();
            $lists = StockRecordList::whereIn('record_id',$id_arr)->paginate(10);
        }
        if (!empty($lists)){
            foreach ($lists as $list){
                $swap =[];
                $list->material = $list->material()->first();
                $list->record = $list->record()->first();
                $swap['number'] = $list->record->number;
                $swap['warehouse'] = $list->record->warehouse;
                $swap['name'] = $list->material->name;
                $swap['param'] = $list->material->param;
                $swap['model'] = $list->material->model;
                $swap['factory'] = $list->material->factory;
                $swap['unit'] = $list->material->unit;
                $swap['purchase_number'] = $list->record->purchase_number;
                $swap['supplier'] = $list->record->supplier;
                $swap['price'] = $list->price;
                $swap['sum'] = $list->sum;
                $swap['cost'] = $list->cost;
                $swap['project_number'] = $list->record->project_number;
                $swap['project_content'] = $list->record->project_content;
                $swap['project_manager'] = $list->record->project_manager;
                $swap['worker'] = $list->record->worker;
                array_push($data,$swap);
            }
        }
        $tr = [[
            '退货出库编号','出库仓库','物料名称','性能及技术参数','品牌型号','生产厂家','单位','采购编号',
            '供应商','单价','退货数量','退货金额','项目编号','项目内容','项目经理','退货人'
        ]];
        $data = array_merge($tr,$data);
        $this->excel->create('退货出库清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportBuildGetList()
    {
        $data = [];
        $role = getRole('build_invoice_list');
        if ($role == 'all'){
            $id = RequestPayment::where('state','=',3)->pluck('project_team')->toArray();
            $lists = ProjectTeam::whereIn('id',$id)->orderBy('id','DESC')->get();
        }else{
            $idArr = getRoleProject('build_invoice_list');
            $id = RequestPayment::where('state','=',3)->pluck('project_team')->toArray();
            $lists = ProjectTeam::whereIn('id',$id)->whereIn('project_id',$idArr)->orderBy('id','DESC')->get();
        }

        if (!empty($lists)){
            foreach ($lists as $list){
                $swap = [];
                $list->invoice_price = $list->invoices()->sum('with_tax');
                $swap['team'] = $list->team;
                $swap['manager'] = $list->manager;
                $swap['project_number'] = $list->project_number;
                $swap['project_content'] = $list->project_content;
                $swap['project_manager'] = $list->project_number;
                $swap['request'] = $list->price;
                $swap['pay'] = number_format($list->applies()->where('state','=',4)->sum('apply_price'),2);
                $swap['need'] = number_format($list->payments()->where('state','>=',3)->sum('price')-$list->applies()->where('state','=',4)->sum('apply_price'),2);
                $swap['invoice'] = number_format($list->invoice_price,2);
                $swap['need_invoice'] = number_format($list->payments()->where('state','>=',3)->sum('price')-$list->invoice_price,2);

                array_push($data,$swap);
            }
        }
        $tr = [[
            '施工队','施工经理','项目编号','项目内容','项目经理','已完工请款','已付款','应付账款','已收票',
            '未收票'
        ]];
        $data = array_merge($tr,$data);
        $this->excel->create(' 施工收票清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportStockCheck()
    {
        $id = Input::get('id');
        $stock = Stock::find($id);
        $stock->material = $stock->material();
        $stock->warehouse = $stock->warehouse();
        $start = '';
        $end = '';
        $s = Input::get('s');
        $e = Input::get('e');
//        $material = Material::find($id);
        $mTr = [['物料名称','性能及技术参数','型号','生产商家','单位','开始时间','结束时间']];
        $mData = [[
            'name'=>$stock->material->name,
            'param'=>$stock->material->param,
            'model'=>$stock->material->model,
            'factory'=>$stock->material->factory,
            'unit'=>$stock->material->unit,
            'start'=>$s,
            'end'=>$e
        ]];
        $mTr  = array_merge($mTr,$mData);
        $tr = [[
            '日期','数量','单价','金额','供货商','收货/退料编号','收货人','数量',
            '单价','金额','项目号','项目内容','领料/退货出库编号','领料人','类型','库存数量','库存金额',
            '库存平均单价'
        ]];
        $tr = array_merge($mTr,$tr);
//        dd($e);
        $data = [];
        if($s){
            $start = $s;
            $end = $e;
//            dd($s)
//            $start =
            $startData = StockRecord::where('date','<',$start)->where('warehouse_id','=',$stock->warehouse_id)->orderBy('id','DESC')->first();
            if (!empty($startData)){
//                dd($startData);
                $startData = StockRecordList::where('record_id','=',$startData->id)->where('material_id','=',$stock->material_id)->orderBy('id','DESC')->first();
                $startData = empty($startData)?new StockRecordList():$startData->toArray();
//                dd($startData);
                //                ->toArray();
            }else{
                $startData = new StockRecordList();
            }

//            dd($startData);
            $idArr = StockRecord::whereBetween('date',[$s,$e])
                ->where('warehouse_id','=',$stock->warehouse_id)->pluck('id')->toArray();
            $lists = StockRecordList::whereIn('record_id',$idArr)->where('material_id','=',$stock->material_id)->get();

        }else{
            $idArr = StockRecord::where('warehouse_id','=',$stock->warehouse_id)->pluck('id')->toArray();
//            dd($idArr);
            $lists = StockRecordList::whereIn('record_id',$idArr)->where('material_id','=',$stock->material_id)->get();
//            dd($lists);
            $startData = [];
            $startData['stock_number'] = 0;
            $startData['stock_price'] = 0;
            $startData['stock_cost'] = 0;
//            if (!empty($lists)){
//                foreach ($lists as $list){
//                    $list->record = $list->record()->first();
//                }
//            }
        }
        if (!empty($lists)){
            foreach ($lists as $list){
                $list->record = $list->record()->first();
                $swap = [];
                $swap['a'] = $list->record->date;
                if ($list->record->type==1||$list->record->type==2){
                    $swap['b'] = $list->sum;
                    $swap['c'] = number_format($list->price,2);
                    $swap['d'] = number_format($list->cost,2);
                    $swap['e'] = $list->record->supplier;
                    $swap['f'] = $list->record->number;
                    $swap['g'] = $list->record->worker;
                    $swap['h'] = '';
                    $swap['i'] = '';
                    $swap['j'] = '';
                    $swap['k'] = $list->record->project_number;
                    $swap['l'] = $list->record->project_content;
                    $swap['m'] = '';
                }else{
                    $swap['b'] = '';
                    $swap['c'] = '';
                    $swap['d'] = '';
                    $swap['e'] = '';
                    $swap['f'] = '';
                    $swap['g'] = $list->record->worker;
                    $swap['h'] = $list->sum;
                    $swap['i'] = number_format($list->price,2);
                    $swap['j'] = number_format($list->cost,2);
                    $swap['k'] = $list->record->project_number;
                    $swap['l'] = $list->record->project_content;
                    $swap['m'] = $list->record->number;
                }
                $swap['n'] = empty($list->record->returnee)?'':$list->record->returnee;
                if ($list->record->type==1||$list->record->type==2){
                $swap['o'] = '入库';
                }else{
                    $swap['o'] = '出库';
                }

                $swap['p'] = $list->stock_number;
                $swap['q'] = number_format($list->stock_cost,2);
                $swap['r'] = number_format($list->stock_price,2);
                array_push($data,$swap);
            }
        }
        $data = array_merge($tr,$data);
        $this->excel->create(' 出入库记录',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');

//        dd($data);
//        dd($lists);
    }
    public function exportPayList()
    {
        $searchType = Input::get('search-type');
        $searchValue = Input::get('value');
        $finish = Input::get('finish',0);
        $role = getRole('pay_list');
        $db = DB::table('costs');
        if ($role=='all'){
            if ($finish){
                switch ($finish){
                    case 1:
                        $db->where('need_invoice','!=',1)->where('need_pay','!=',1);
                        break;
                    case 2:
                        $idArray = Cost::where('need_invoice','!=',1)->where('need_pay','!=',1)->pluck('id')->toArray();
                        $db->whereNotIn('id',$idArray);
                        break;
                }
            }
            if ($searchType){
                switch ($searchType){
                    case 1:
                        $db->where('number','like','%'.$searchValue.'%');
                        break;
                    case 2:
                        $projectId = Project::where('number','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('project_id',$projectId);
                        break;
                    case 3:
                        $projectId = Project::where('name','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('project_id',$projectId);
                        break;
                    case 4:
                        $db->where('proposer','like','%'.$searchValue.'%');
                        break;
                    case 5:
                        $db->where('approver','like','%'.$searchValue.'%');
                        break;
                    case 6:
                        $suppliersId = Supplier::where('name','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('supplier_id',$suppliersId);
                        break;
                    case 7:
                        $types = PayType::where('title','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('pay_type',$types);
                        break;
                    case 8:
                        $details = PayTypeDetail::where('title','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('pay_detail',$details);
                        break;
                    case 9:
                        $db->where('application','like','%'.$searchValue.'%');
                        break;
                }
            }

        }elseif($role=='only'){
            $db->where('proposer','=',Auth::user()->username);
            if ($finish){
                switch ($finish){
                    case 1:
                        $db->where('need_invoice','!=',1)->where('need_pay','!=',1);
                        break;
                    case 2:
                        $idArray = Cost::where('need_invoice','!=',1)->where('need_pay','!=',1)->pluck('id')->toArray();
                        $db->whereNotIn('id',$idArray);
                        break;
                }
            }
            if ($searchType){
                switch ($searchType){
                    case 1:
                        $db->where('number','like','%'.$searchValue.'%');
                        break;
                    case 2:
                        $projectId = Project::where('number','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('project_id',$projectId);
                        break;
                    case 3:
                        $projectId = Project::where('name','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('project_id',$projectId);
                        break;
                    case 4:
                        $db->where('proposer','like','%'.$searchValue.'%');
                        break;
                    case 5:
                        $db->where('approver','like','%'.$searchValue.'%');
                        break;
                    case 6:
                        $suppliersId = Supplier::where('name','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('supplier_id',$suppliersId);
                        break;
                    case 7:
                        $types = PayType::where('title','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('pay_type',$types);
                        break;
                    case 8:
                        $details = PayTypeDetail::where('title','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('pay_detail',$details);
                        break;
                    case 9:
                        $db->where('application','like','%'.$searchValue.'%');
                        break;
                }
            }
        }else{
            $idArr = getRoleProject('pay_list');
            $db->whereIn('project_id',$idArr);
            if ($finish){
                switch ($finish){
                    case 1:
                        $db->where('need_invoice','=',0)->where('need_pay','=',0);
                        break;
                    case 2:
                        $idArray = Cost::where('need_invoice','!=',1)->where('need_pay','!=',1)->pluck('id')->toArray();
                        $db->whereNotIn('id',$idArray);
                        break;
                }
            }
            if ($searchType){
                switch ($searchType){
                    case 1:
                        $db->where('number','like','%'.$searchValue.'%');
                        break;
                    case 2:
                        $projectId = Project::where('number','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('project_id',$projectId);
                        break;
                    case 3:
                        $projectId = Project::where('name','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('project_id',$projectId);
                        break;
                    case 4:
                        $db->where('proposer','like','%'.$searchValue.'%');
                        break;
                    case 5:
                        $db->where('approver','like','%'.$searchValue.'%');
                        break;
                    case 6:
                        $suppliersId = Supplier::where('name','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('supplier_id',$suppliersId);
                        break;
                    case 7:
                        $types = PayType::where('title','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('pay_type',$types);
                        break;
                    case 8:
                        $details = PayTypeDetail::where('title','like','%'.$searchValue.'%')->pluck('id')->toArray();
                        $db->whereIn('pay_detail',$details);
                        break;
                    case 9:
                        $db->where('application','like','%'.$searchValue.'%');
                        break;
                }
            }

        }
        $data = $db->orderBy('id','DESC')->get();
        $list = [];
        $tr = [['业务编号','项目编号','付款方式','收款银行及账号','项目内容','付款金额','收款人','费用类型','具体事项','用途','发票类型','备注','申请人','审批人','已付款金额','应付账款','已收票金额','未收票金额']];

        if (!empty($data)){
            foreach ($data as $datum){
                $swap = [];
                $swap['a'] = $datum->number;
                $swap['b'] = $datum->project_id==0?'':\App\Models\Project::find($datum->project_id)->number;
                $swap['c'] = $datum->type==1?'现金':'付款';
                $swap['d'] = $datum->supplier_id==0?'':\App\Models\Supplier::find($datum->supplier_id)->bank.\App\Models\Supplier::find($datum->supplier_id)->account;
                $swap['e'] = $datum->project_id==0?'':\App\Models\Project::find($datum->project_id)->name;
                $swap['f'] = number_format($datum->apply_price,2);
                $swap['g'] = $datum->supplier_id==0?'':\App\Models\Supplier::find($datum->supplier_id)->name;
                $swap['h'] = $datum->pay_type==0?'':\App\PayType::find($datum->pay_type)->title;
                $swap['i'] = $datum->pay_detail==0?'':\App\PayTypeDetail::find($datum->pay_detail)->title;
                $swap['j'] = $datum->application;
                $swap['k'] = $datum->invoice_type==0?'':\App\Models\Invoice::find($datum->invoice_type)->name;
                $swap['l'] = $datum->remark;
                $swap['m'] = $datum->proposer;
                $swap['n'] = $datum->approver;
                $swap['o'] = number_format(\App\Models\CostPay::where('cost_id','=',$datum->id)->sum('cost'),2);
                $swap['p'] = number_format($datum->apply_price-\App\Models\CostPay::where('cost_id','=',$datum->id)->sum('cost'),2);
                $swap['q'] = number_format(\App\Models\CostInvoice::where('cost_id','=',$datum->id)->sum('with_tax'),2);
                $swap['r'] = $datum->need_invoice==0?0:number_format($datum->apply_price-\App\Models\CostInvoice::where('cost_id','=',$datum->id)->sum('with_tax'),2);
                array_push($list,$swap);
            }
        }
        $list = array_merge($tr,$list);
        $this->excel->create('付款审批清单',function ($excel) use ($tr,$list){
            $excel->sheet('sheet1',function ($sheet) use ($list){
                $count = count($list);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$list[$j]);
                }
            });
        })->export('xls');
    }
}
