<?php

namespace App\Http\Controllers;

use App\Cost;
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
use App\Models\ProjectPicture;
use App\Models\ProjectTeam;
use App\Models\ProjectType;
use App\Models\Purchase;
use App\Models\Stock;
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
//        $allow =  [
//            'jpg',
//            'png',
//            'txt',
//            'bmp',
//            'gif',
//            'jpeg',
//            'pdf',
//            'mp4',
//            'doc',
//            'docx',
//            'xls',
//            'xlsx'
//
//    ];
//        if (!in_array(strtolower($name[1]),$allow)){
//            return response()->json([
//                'return_code'=>'FAIL',
//                'return_msg'=>'不支持的文件格式'
//            ]);
//        }
//        $md5 = md5_file($file);
        $name = $name[1];
        $name = date('Y-m-d His',time()).'.'.$name;
        if (!$file){
            return response()->json([
                'return_code'=>'FAIL',
                'return_msg'=>'空文件'
            ]);
        }
        $count = ProjectPicture::count();
        if ($file->isValid()){
            $destinationPath = 'uploads';
            $file->move($destinationPath,$name);
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS',
                'data'=>[
                    'size'=>$count+1,
                    'name'=>$name,
                    'url'=>env('APP_URL').$destinationPath.'/'.$name,
                ]
            ]);
        }
    }
    //供应商列表
    public function listSupplierPage()
    {
        $name = Input::get('name');
        $type = Input::get('search-type');
        $DbObj = DB::table('suppliers');
        if ($type){
            switch ($type){
                case 1:
                    $DbObj->where('name','like','%'.$name.'%');
                    break;
                case 2:
                    $DbObj->where('bank','like','%'.$name.'%');
                    break;
                case 3:
                    $DbObj->where('account','like','%'.$name.'%');
                    break;
            }
        }
        $data = $DbObj->where('state','=',1)->orderBy('id','DESC')->paginate(10);
        return view('supplier.list',['suppliers'=>$data,'name'=>$name,'type'=>$type]);
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
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function delSupplier()
    {
        $id = Input::get('id');
        $supplier = Supplier::find($id);
        $supplier->state = 0;
        $supplier->save();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
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
        return view('supplier.add',['supplier'=>$supplier]);
    }
    public function searchSupplier()
    {
        $name = Input::get('name');
        $db = DB::table('suppliers');
        if ($name){
            $db->where('name','like','%'.$name.'%');
        }
        $data = $db->where('state','=',1)->orderBy('id','DESC')->get();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$data
        ]);
    }
    public function searchBank()
    {
        $name = Input::get('name');
        $db = DB::table('bank_accounts');
        if ($name){
            $db->where('name','like','%'.$name.'%')->orWhere('account','like','%'.$name.'%');
        }
        $data = $db->where('state','=',1)->get();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$data
        ]);
    }
    //物料列表
    public function listMaterialPage()
    {
        $name = Input::get('value');
        $DbObj = DB::table('materials')->where('state','=',1);
        $type = Input::get('search-type');
        if ($type){
            switch ($type){
                case 1:
                    $DbObj->where('name','like','%'.$name.'%');
                    break;
                case 2:
                    $DbObj->where('model','like','%'.$name.'%');
                    break;
                case 3:
                    $DbObj->where('factory','like','%'.$name.'%');
                    break;
            }
        }
//        if ($name){
//            $DbObj->where(function($q1) use($name){
//                $q1->orWhere('model','like','%'.$name.'%')
//                    ->orWhere('factory','like','%'.$name.'%')
//                    ->orWhere('name','like','%'.$name.'%')
//                ;
//            });
//        }
        $data = $DbObj->orderBy('id','DESC')->paginate(10);
//        dd($data);
        return view('material.list',['materials'=>$data,'name'=>$name,'type'=>$type]);
    }

    public function delMaterial()
    {
        $id = Input::get('id');
        $material = Material::find($id);
        if (empty($material)){
            return response()->json([
                'code'=>'404',
                'msg'=>'Not Found'
            ]);
        }
        $material->state = 0;
        if ($material->save()){
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
        $material->name = $post->get('name');
        $material->param = $post->get('param');
        $material->model = $post->get('model');
        $material->factory = $post->get('factory');
        $material->unit = $post->get('unit');
        if ($material->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
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
            $count = Warehouse::where('name','=', $post->get('name'))->where('state','=',1)->count();
            if ($count!=0){
                return response()->json([
                    'code'=>'400',
                    'msg'=>'该仓库已存在！'
                ]);
            }
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
    public function delWarehouse()
    {
        $id = Input::get('id');
        $warehouse = Warehouse::find($id);
        $warehouse->state = 0;
        $warehouse->save();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }

    public function listWarehousesPage()
    {
        $name = Input::get('name');
        $DbObj = DB::table('warehouses');
        $type = Input::get('search-type');
        if ($type){
            switch ($type){
                case 1:
                    $DbObj->where('name','like','%'.$name.'%');
                    break;
                case 2:
                    $DbObj->where('admin','like','%'.$name.'%');
                    break;
            }
        }
        $data = $DbObj->where('state','=',1)->orderBy('id','DESC')->paginate(10);
        return view('warehouse.list',['warehouses'=>$data,'name'=>$name,'type'=>$type]);
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
    public function delBank()
    {
        $id = Input::get('id');
        $bank = BankAccount::find($id);
        $bank->state = 0;
        $bank->save();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }

    public function listBankAccountsPage()
    {
        $name = Input::get('name');
        $DbObj = DB::table('bank_accounts');
        $type = Input::get('search-type');
        if ($type){
            switch ($type){
                case 1:
                    $DbObj->where('name','like','%'.$name.'%');
                    break;
                case 2:
                    $DbObj->where('account','like','%'.$name.'%');
                    break;
            }
        }
        $DbObj->where('state','=',1);
        $accounts = $DbObj->paginate(10);
        return view('bank.list',['accounts'=>$accounts,'name'=>$name,'type'=>$type]);
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
        $invoice->rate = $post->get('rate');
        if ($invoice->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function delInvoiceType()
    {
        $id = Input::get('id');
        $invoice = Invoice::find($id);
        $invoice->state = 0;
        $invoice->save();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
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
        $invoices = Invoice::where('state','=',1)->paginate(10);
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
        $team->bank = $post->get('bank');
        $team->account = $post->get('account');
        if ($team->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function delTeam()
    {
        $id = Input::get('id');
        $team = Team::find($id);
        $team->state = 0;
        $team->save();
        return response()->json([
        'code'=>'200',
        'msg'=>'SUCCESS'
    ]);
    }
    public function getTeams()
    {
        $name = Input::get('name');
        $dbObj = DB::table('teams')->select(['id','name','manager','bank','account']);
        if ($name){
            $dbObj->where('name','like','%'.$name.'%');
        }
        $data = $dbObj->where('state','=',1)->orderBy('id','DESC')->get();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$data
        ]);
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
        $DbObj = DB::table('teams');
        $type = Input::get('search-type');
        if ($type){
            switch ($type){
                case 1:
                    $DbObj->where('name','like','%'.$name.'%');
                    break;
                case 2:
                    $DbObj->where('manager','like','%'.$name.'%');
                    break;
            }
        }
//        if ($name){
//            $DbObj->where('name','like','%'.$name.'%')->orWhere('manager','like','%'.$name.'%');
//        }
//        if ($manager){
//            $DbObj->where('manager','like','%'.$manager.'%');
//        }
        $teams = $DbObj->where('state','=',1)->paginate(10);
        return view('team.list',['teams'=>$teams,'name'=>$name,'type'=>$type]);
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
    public function delProjectType()
    {
        $id = Input::get('id');
        $type = ProjectType::find($id);
        $type -> state = 0;
        $type->save();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
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
    public function listProjectTypesPage()
    {
        $type = ProjectType::where('state','=',1)->paginate(10);
        return view('data.type_list',['types'=>$type]);
    }
    public function listCategoryPage()
    {
        $categories = Category::where('state','=',1)->paginate(10);
        for ($i=0;$i<count($categories);$i++){
            $categories[$i]->kinds = $categories[$i]->kinds()->where('state','=',1)->pluck('title')->toArray();
        }
        return view('data.payment_list',['categories'=>$categories]);
    }
    public function addCategory(Request $post)
    {
//        dd($post->all());
        $id = $post->id;
        if ($id){
            $category = Category::find($id);
//            Detail::where('')
        }else{
            $category = new Category();
            $category->title = $post->get('title');
            $category->save();
        }

        $kinds = $post->get('kinds');
        Detail::where('category_id','=',$category->id)->update(['state'=>0]);
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
    public function delCategory()
    {
        $id = Input::get('id');
        $category = Category::find($id);
        $category->state = 0;
        $category->save();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS'
        ]);
    }
    public function addCategoryPage()
    {
        return view('data.payment_add');
    }
    public function editCategoryPage()
    {
        $id = Input::get('id');
        $category = Category::find($id);
        $details = Detail::where('category_id','=',$category->id)->where('state','=',1)->select(['id','title as name'])->get();
        return view('data.payment_edit',['category'=>$category,'details'=>$details]);
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
    public function searchCategory()
    {
        $categories = Category::where('state','=',1)->get();
        for($i=0;$i<count($categories);$i++){
            $categories[$i]->kinds = $categories[$i]->kinds()->where('state','=',1)->get();
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$categories
        ]);
    }
    public function searchMaterial()
    {
        $name = Input::get('name');
        $db = DB::table('materials');
        if ($name){
            $db->where('name','like','%'.$name.'%');
        }
        $data = $db->where('state','=',1)->orderBy('id','DESC')->get();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$data
        ]);
    }
    public function searchStockMaterial()
    {
        $id = Input::get('id');
        $name = Input::get('name');
        $materialId = Stock::where('warehouse_id','=',$id)->where('number','!=',0)->pluck('material_id')->toArray();
        $db = Material::whereIn('id',$materialId);
        if ($name){
            $db->where('name','like','%'.$name.'%');
        }
        $id_arr = $db->pluck('id')->toArray();
        if ($id){
            $stockId = Stock::where('warehouse_id','=',$id)->where('number','!=',0)->whereIn('material_id',$id_arr)->get();
        }else {
            return response()->json([
                'code'=>'400',
                'msg'=>'请先选择仓库！'
            ]);
        }
//        dd($stockId);
        foreach ($stockId as $item){
            $item->material = $item->material();
            $price = $item->number==0?0:$item->cost/$item->number;
            $item->price = sprintf('%.2f',$price);
            $item->stock_number = $item->number;
        }
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$stockId
        ]);
    }
    public function fixData()
    {
        $type = Input::get('type');
        if ($type){
            switch ($type){
                case 1:
                    $costs = Cost::all();
                    foreach ($costs as $cost){
                        $cost->need_pay = $cost->apply_price-\App\Models\CostPay::where('cost_id','=',$cost->id)->sum('cost')<=0?0:1;
                        $cost->need_invoice = $cost->apply_price-\App\Models\CostInvoice::where('cost_id','=',$cost->id)->sum('with_tax')<=0?0:1;
                        $cost->save();
                    }
                    break;
                case 2:
                    $projectTeams = ProjectTeam::all();
                    foreach ($projectTeams as $projectTeam){
                        $projectTeam->need_invoice = $projectTeam->payments()->where('state','>=',3)->sum('price')-$projectTeam->invoices()->sum('with_tax')>0?1:0;
                        $projectTeam->save();
                    }
                    break;
                case 3:
                    $projectTeams = ProjectTeam::all();
                    foreach ($projectTeams as $projectTeam){
                        $projectTeam->need_pay = $projectTeam->payments()->where('state','>=',3)->sum('price')-$projectTeam->applies()->where('state','=',4)->sum('apply_price')>0?1:0;
                        $projectTeam->save();
                    }
                    break;
                case 4:
                $purchases = Purchase::all();
                foreach ($purchases as $purchase){
                    $need = 0;
                    $swap = $purchase->lists()->get();
                    for ($i=0;$i<count($swap);$i++){
                        $need += $swap[$i]->price * $swap[$i]->need;
                    }
                    $purchase->need_stock = $need>0?1:0;
                    $purchase->save();
                }
                break;
                case 5:
                $purchases = Purchase::all();
                foreach ($purchases as $purchase){
                    $purchase->need_invoice = $purchase->lists()->sum('cost')-$purchase->invoices()->sum('with_tax')>0?1:0;
                    $purchase->save();
                }
                break;
                case 6:
                    $purchases = Purchase::all();
                    foreach ($purchases as $purchase){
                        $purchase->need_pay = $purchase->lists()->sum('cost')-$purchase->payments()->sum('pay_price')>0?1:0;
                        $purchase->save();
                    }
                    break;
            }
        }
    }

}
