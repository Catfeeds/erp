<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBankAccountPost;
use App\Http\Requests\CreateInvoicePost;
use App\Http\Requests\CreateMaterial;
use App\Http\Requests\CreateProjectTypePost;
use App\Http\Requests\CreateTeamPost;
use App\Http\Requests\CreateWarehousePost;
use App\Http\Requests\SupplierCreatePost;
use App\Models\BankAccount;
use App\Models\Category;
use App\Models\ContractContent;
use App\Models\Detail;
use App\Models\Invoice;
use App\Models\Material;
use App\Models\ProjectType;
use App\Models\Supplier;
use App\Models\TaxRate;
use App\Models\Team;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;

class SystemController extends Controller
{
    //添加税率
    public function addTaxRate()
    {
        $id = Input::get('id');
        if ($id){
            $taxRate = TaxRate::find($id);
        }else{
            $taxRate = new TaxRate();
        }
        $taxRate->rate = Input::get('rate');
        if ($taxRate->save()){
            return redirect()->back()->with('status','操作成功！');
        }
    }
    //
    public function addTaxRatePage()
    {

    }
    //税率列表界面
    public function listTaxRate()
    {
        $taxrates = TaxRate::paginate(10);
    }
    //删除税率
    public function delTaxRate($id)
    {
        $taxRate = TaxRate::find($id);
        if ($taxRate){
            $taxRate->delete();
            return redirect()->back()->with('status','操作成功！');
        }
        return redirect()->back()->with('status','没有找到该税率');
    }
    //
    public function addContractContent()
    {
        $id = Input::get('id');
        if ($id){
            $content = ContractContent::find($id);
        }else{
            $content = new ContractContent();
        }
        $content->title = Input::get('title');
        if ($content->save()){
            return redirect()->back()->with('status','操作成功！');
        }
    }
    public function addContractContentPage()
    {

    }
    public function listContractContent()
    {

    }
    public function delContractContent($id)
    {
        $content = ContractContent::find($id);
        if ($content){
            $content->delete();
            return redirect()->back()->with('status','操作成功！');
        }
        return redirect()->back()->with('status','没有该内容！');
    }
    public function upload(Request $request)
    {
        if (!$request->hasFile('image')){
            return response()->json([
                'return_code'=>'FAIL',
                'return_msg'=>'空文件'
            ]);
        }
        $file = $request->file('image');
        $name = $file->getClientOriginalName();
        $name = explode('.',$name);
        if (count($name)!=2){
            return response()->json([
                'return_code'=>'FAIL',
                'return_msg'=>'非法文件名'
            ]);
        }
        $allow =  [
        'jpg',
        'png',
        'txt',
        'bmp',
        'gif',
        'jpeg',
        'pem',
        'mp4',
    ];
        if (!in_array(strtolower($name[1]),$allow)){
            return response()->json([
                'return_code'=>'FAIL',
                'return_msg'=>'不支持的文件格式'
            ]);
        }
//        $md5 = md5_file($file);
        $name = $name[1];
        $name = date('Y-m-d H:i:s',time()).'.'.$name;
        if (!$file){
            return response()->json([
                'return_code'=>'FAIL',
                'return_msg'=>'空文件'
            ]);
        }
        if ($file->isValid()){
            $destinationPath = 'uploads';
            $file->move($destinationPath,$name);
            return response()->json([
                'return_code'=>'SUCCESS',
                'data'=>[
                    'file_name'=>$name,
                    'base_url'=>'http://119.23.202.220:8080'.($destinationPath.'/'.$name),
                ]
            ]);
        }
    }
    //供应商列表
    public function listSupplierPage()
    {
        $name = Input::get('name');
        $bank = Input::get('bank');
        $account = Input::get('account');
        $DbObj = DB::table('suppliers');
        if ($name){
            $DbObj->where('name','like','%'.$name.'%');
        }
        if ($bank){
            $DbObj->where('bank','like','%'.$bank.'%');
        }
        if ($account){
            $DbObj->where('account','like','%'.$account.'%');
        }
        $data = $DbObj->paginate(10);
        return view('supplier.list',['suppliers'=>$data]);
    }
    //创建供应商
    public function createSupplier(Request $post)
    {
        $id = $post->get('id');
        if ($id){
            $supplier = Supplier::find($id);
        }else{
            $supplier = new Supplier();
        }
        $supplier->name = $post->get('name');
        $supplier->bank = $post->get('bank');
        $supplier->account = $post->get('account');
        if ($supplier->save()){
            return redirect()->back('status','操作成功');
        }
    }
    //创建供应商界面
    public function createSupplierPage()
    {
        $id = Input::get('id');
        if ($id){
            $supplier = Supplier::find($id);
        }else{
            $supplier = new Supplier();
        }
        return view('supplier.add',$supplier);
    }
    //物料列表
    public function listMaterialPage()
    {
        $name = Input::get('name');
        $model = Input::get('model');
        $factory = Input::get('factory');
        $DbObj = DB::table('materials');
        if ($name){
            $DbObj->where('name','like','%'.$name.'%');
        }
        if ($model){
            $DbObj->where('model','like','%'.$model.'%');
        }
        if ($factory){
            $DbObj->where('factory','like','%'.$model.'%');
        }
        $data = $DbObj->paginate(10);
        return view('material.list',['materials'=>$data]);
    }

    public function delMaterial($id)
    {
        $material = Material::find($id);
        if (empty($material)){
            return response()->json([
                'code'=>'404',
                'msg'=>'Not Found'
            ]);
        }
        if ($material->delete()){
            return response()->json([
                'code'=>'200',
                'msg'=>'success'
            ]);
        }
    }

    public function createMaterial(Request $post)
    {
        $id =$post->get('id');
        if ($id){
            $material = Material::find($id);
        }else{
            $material = new Material();
        }

    }
    //
    public function createMaterialPage()
    {
        $id = Input::get('id');
        if ($id){
            $material = Material::find($id);
        }else{
            $material = new Material();
        }
        return view('material.create',['material'=>$material]);
    }

    //创建仓库
    public function createWarehousePage()
    {
        $id = Input::get('id');
        if ($id){
            $warehouse = Warehouse::find($id);
        }else{
            $warehouse = new Warehouse();
        }
        return view('warehouse.create',['warehouse'=>$warehouse]);
    }

    public function createWarehouse(Request $post)
    {
        $id = Input::get('id');
        if ($id){
            $warehouse = Warehouse::find($id);
        }else{
            $warehouse = new Warehouse();
        }
        $warehouse->name = $post->get('name');
        $warehouse->address = $post->get('address');
        $warehouse->admin = $post->get('admin');
        if ($warehouse->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }

    public function listWarehousesPage()
    {
        $name = Input::get('name');
        $admin = Input::get('admin');
        $DbObj = DB::table('warehouses');
        if ($name){
            $DbObj->where('name','like','%'.$name.'%');
        }
        if ($admin){
            $DbObj->where('admin','like','%'.$admin.'%');
        }
        $data = $DbObj->paginate(10);
        return view('warehouse.list',['warehouses'=>$data]);
    }
    //银行账号
    public function createBankAccount(Request $post)
    {
        $id = $post->get('id');
        if ($id){
            $account = BankAccount::find($id);
        }else{
            $account = new BankAccount();
        }
        $account->name = $post->get('name');
        $account->account = $post->get('account');
        if ($account->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }

    public function listBankAccountsPage()
    {
        $name = Input::get('name');
        $account = Input::get('account');
        $DbObj = DB::table('bank_accounts');
        if ($name){
            $DbObj->where('name','like','%'.$name.'%');
        }
        if ($account){
            $DbObj->where('account','like','%'.$account.'%');
        }
        $accounts = $DbObj->paginate(10);
        return view('bank.list',['accounts'=>$accounts]);
    }

    public function createBankAccountPage()
    {
        $id = Input::get('id');
        if ($id){
            $account = BankAccount::find($id);
        }else{
            $account = new BankAccount();
        }
        return view('bank.create',['account'=>$account]);
    }

    //发票类型
    public function createInvoice(Request $post)
    {
        $id = $post->get('id');
        if ($id){
            $invoice = Invoice::find($id);
        }else{
            $invoice = new Invoice();
        }
        $invoice->name = $post->get('name');
        $invoice->remark = $post->get('remark');
        if ($invoice->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function createInvoicePage()
    {
        $id = Input::get('id');
        if ($id){
            $invoice = Invoice::find($id);
        }else{
            $invoice = new Invoice();
        }
        return view('invoice.create',['invoice'=>$invoice]);
    }

    public function listInvoicesPage()
    {
        $invoices = Invoice::paginate(10);
        return view('invoice.list',['invoices'=>$invoices]);
    }

    //施工队伍
    public function createTeam(Request $post)
    {
        $id = $post->get('id');
        if ($id){
            $team = Team::find($id);
        }else{
            $team = new Team();
        }
        $team->name = $post->get('name');
        $team->manager = $post->get('manager');
        if ($team->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function createTeamPage()
    {
        $id = Input::get('id');
        if ($id){
            $team = Team::find($id);
        }else{
            $team = new Team();
        }
        return view('team.create',['team'=>$team]);
    }
    public function listTeamsPage()
    {
        $name = Input::get('name');
        $manager = Input::get('manager');
        $DbObj = DB::table('teams');
        if ($name){
            $DbObj->where('name','like','%'.$name.'%');
        }
        if ($manager){
            $DbObj->where('manager','like','%'.$manager.'%');
        }
        $teams = $DbObj->paginate(10);
        return view('team.list',['teams'=>$teams]);
    }
    public function createProjectType(Request $post)
    {
        $id = $post->get('id');
        if ($id){
            $type = ProjectType::find($id);
        }else{
            $type = new ProjectType();
        }
        $type->name = $post->get('name');
        $type->rate = $post->get('rate');
        if ($type->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function createProjectTypePage()
    {
        $id = Input::get('id');
        if ($id){
            $type = ProjectType::find($id);
        }else{
            $type = new ProjectType();
        }
        return view('type.create',['type'=>$type]);
    }
    public function addCategory(Request $post)
    {
        $category = new Category();
        $category->title = $post->get('title');
        $category->save();
        $kinds = $post->get('kinds');
        foreach ($kinds as $item){
            $kind = new Detail();
            $kind->category_id = $category->id;
            $kind->title = $item;
            $kind->save();
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function addKinds(Request $post)
    {
        $kinds = $post->get('kinds');
        $category_id = $post->get('category_id');
        foreach ($kinds as $item){
            $kind = new Detail();
            $kind->category_id = $category_id;
            $kind->title = $item;
            $kind->save();
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function delKind($id)
    {
        $detail = Detail::find($id);
        if ($detail->delete()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }

}
