<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\LoanList;
use App\Models\LoanPay;
use App\Models\LoanPayList;
use App\Models\LoanSubmit;
use App\Models\Material;
use App\Models\OutContract;
use App\Models\PayApply;
use App\Models\Project;
use App\Models\ProjectSituations;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Team;
use App\Models\Warehouse;
use App\User;
use Illuminate\Http\Request;
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
        $data = Supplier::select(['name','bank','account'])->where('state','=',1)->get()->toArray();
        //供应商名称	收款银行	收款账号
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
        $data = Material::select(['name','param','model','factory','unit'])->where('state','=',1)->get()->toArray();
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
        $tr = [['银行名称','收款账号']];
        $data = array_merge($tr,$data);
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
        $data = PayApply::select(['number','price','use','project_number','project_content',
            'proposer','approver','pay_date','cash','transfer','bank','account','other'])->get()->toArray();
        //
        for ($i=0;$i<count($data);$i++){
            $data[$i]['bank'] = $data[$i]['bank'].' '.$data[$i]['account'];
            unset($data[$i]['account']);
        }
        $tr = [['业务编号','付款金额','用途','项目编号','项目内容','申请人',
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
        ])->get()->toArray();
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
            $list1 = LoanList::where('borrower','=',$name)->whereBetween('apply_date',[$s,$e])->select(['number','price','apply_date as date','loanBalance','submitBalance'])->get()->toArray();
            $list2 = LoanSubmit::where('loan_user','=',$name)->whereBetween('date',[$s,$e])->select(['number','price','date','loanBalance','submitBalance'])->get()->toArray();
            $list3 = LoanPay::where('applier','=',$name)->whereBetween('date',[$s,$e])->select(['number','price','date','loanBalance','submitBalance','cash','transfer','deduction'])->get()->toArray();
            $swap = array_merge($list1,$list2);
            $lists = array_merge($swap,$list3);
            array_multisort(array_column($lists,'date'),SORT_ASC,$lists);
        }
        $tr = [['日期','借款编号','借款金额','报销编号','报销金额	','付款编号','付款金额','其中：抵扣借款','其中：现金付款','其中：银行转账','未支付报销余额','借款余额']];
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
                    $swap['FKPrice'] = $lists[$i]['price'];
                    $swap['deduction'] = $lists[$i]['deduction'];
                    $swap['cash'] = $lists[$i]['cash'];
                    $swap['transfer'] = $lists[$i]['transfer'];
                    $swap['submitBalance'] = $lists[$i]['submitBalance'];
                    $swap['loanBalance'] = $lists[$i]['loanBalance'];
                }elseif (strstr($lists[$i]['number'],'JK')) {
                    $swap = [];
                    $swap['date'] = $lists[$i]['date'];
                    $swap['JKNumber'] = $lists[$i]['number'];
                    $swap['JKPrice'] = $lists[$i]['price'];
                    $swap['BXNumber'] = '';
                    $swap['BXPrice'] = '';
                    $swap['FKNumber'] = '';
                    $swap['FKPrice'] = '';
                    $swap['deduction'] = '';
                    $swap['cash'] = '';
                    $swap['transfer'] = '';
                    $swap['submitBalance'] = $lists[$i]['submitBalance'];
                    $swap['loanBalance'] = $lists[$i]['loanBalance'];
                }else{
                    $swap = [];
                    $swap['date'] = $lists[$i]['date'];
                    $swap['JKNumber'] = '';
                    $swap['JKPrice'] = '';
                    $swap['BXNumber'] = $lists[$i]['number'];
                    $swap['BXPrice'] = $lists[$i]['price'];
                    $swap['FKNumber'] = '';
                    $swap['FKPrice'] = '';
                    $swap['deduction'] = '';
                    $swap['cash'] = '';
                    $swap['transfer'] = '';
                    $swap['submitBalance'] = $lists[$i]['submitBalance'];
                    $swap['loanBalance'] = $lists[$i]['loanBalance'];
                }
                $lists[$i] = $swap;
            }
        }
        $data = array_merge($tr,$lists);
        $this->excel->create('报销明细清单',function ($excel) use ($tr,$data){
            $excel->sheet('sheet1',function ($sheet) use ($data){
                $count = count($data);
                for ($j=0;$j<$count;$j++){
                    $sheet->row($j+1,$data[$j]);
                }
            });
        })->export('xls');
    }
    public function exportStockList()
    {
        $stock = Stock::all();
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
                $swap['price'] = sprintf('%.2f',$stock[$i]->cost/$stock[$i]->number);
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
        $projects = $projectDb->orderBy('id','DESC')->paginate(10);
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
            $swap['unit'] = number_format(ProjectSituations::where('project_id','=',$projects[$i]->id)->where('type','=',2)->sum('price'));
            $swap['finishTime'] = date('Y-m-d',$projects[$i]->finishTime);
            $data[$i] = $swap;
        }
        $data = array_merge($tr,$data);
        $this->excel->create('项目清单',function ($excel) use ($tr,$data){
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
    }
    public function exportBudgetList()
    {

    }
    public function exportProjectBudget()
    {
        $project_id = Input::get('project_id');
        $project = Project::find($project_id);
        $budgets = $project->budget()->get()->toArray();
        dd($budgets);
    }

}
