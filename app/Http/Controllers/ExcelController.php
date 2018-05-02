<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\LoanPay;
use App\Models\LoanPayList;
use App\Models\LoanSubmit;
use App\Models\Material;
use App\Models\PayApply;
use App\Models\Project;
use App\Models\Supplier;
use App\Models\Team;
use App\Models\Warehouse;
use App\User;
use Illuminate\Http\Request;
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
}
