<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login;
use App\Models\ProjectRole;
use App\Models\Role;
use App\Models\RoleDetail;
use App\Models\Task;
use App\Providers\AuthServiceProvider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    //
    public function loginPage()
    {
        return view('login');
    }
    public function login(Login $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        if (Auth::attempt(['username'=>$username,'password'=>$password],true)){
            return redirect('index');
        }else{
            return redirect()->back()->with('status','用户名或密码错误！');
        }
    }
    public function logout()
    {
        if (Auth::logout()){
            return redirect('login');
        }
        return redirect('login');
    }
    public function registerPage()
    {

    }
    public function register(Request $post)
    {
        $user = new User();
        $user->username = $post->get('username');
        $user->department = $post->get('department');
        $user->phone = $post->get('phone');
        $user->name = $post->get('username');
        $user->password = bcrypt($post->get('password'));
        if ($user->save()){
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS'
            ]);
        }
    }
    public function index()
    {
        if (Auth::check()){
            $tasks = Task::where('user_id','=',Auth::id())->where('state','=',1)->get();
            return view('index',['tasks'=>$tasks]);
        }
        return redirect('login');
    }
    public function getUsers()
    {
        $role = Input::get('role');
        $project_id = Input::get('project_id',0);
        if ($project_id!=0){
            $idArr = Role::where('role_name','=',$role)->where('role_value','=','all')->pluck('user_id')->toArray();
            $users = User::whereIn('id',$idArr)->select(['id','name'])->get();
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS',
                'data'=>$users
            ]);
        }else{
            $idArr = Role::where('role_name','=',$role)->where('role_value','=','all')->pluck('user_id')->toArray();
            $idArr2 = ProjectRole::where('role_value','=',$role)->where('project_id','=',$project_id)->pluck('user_id')->toArray();
            $idArr = array_merge($idArr,$idArr2);
            $users = User::whereIn('id',$idArr)->select(['id','name'])->get();
            return response()->json([
                'code'=>'200',
                'msg'=>'SUCCESS',
                'data'=>$users
            ]);
        }

    }
    public function listUsers()
    {
        $users = User::paginate(10);
        return view('auth.list',['users'=>$users]);
    }
    public function createUserPage()
    {
        $id = Input::get('id');
        if ($id){
            $user = User::find($id);
        }else{
            $user = new User();
        }
        return view('auth.create',['user'=>$user]);
    }
    public function createAuth()
    {

    }
    public function listUserRole()
    {
        $id = Input::get('id');
        $user = User::find($id);
        $rolelists = Role::where('user_id','=',$id)->select(['role_name','role_value'])->get()->toArray();
        $lists = array_column($rolelists, 'role_value','role_name');
        return view('auth.check',['lists'=>$lists,'user'=>$user]);
    }
    public function addUserRoles()
    {
        $data = Input::all();
        $id = $data['id'];
        unset($data['id']);
        foreach ($data as $item =>$value){
            $role = Role::where('user_id','=',$id)->where('role_name','=',$item)->first();
            if (empty($role)){
                $role = new Role();
                $role->user_id = $id;
                $role->role_name = $item;
            }
            $role->role_value = $value;
            $role->save();
        }
        return redirect()->back()->with('status','操作成功！');
    }
    public function editUserRoles()
    {
        return view('auth.edit');
    }
    public function searchUser()
    {
        $permission = Input::get('permission');
        $project_id = Input::get('project_id');
        $idArr = RoleDetail::where([
            'permission'=>$permission,
            'project_id'=>$project_id
        ])->pluck('user_id');
        $users = User::whereIn('id',$idArr)->select(['id','name'])->get();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$users
        ]);
    }


    

}
