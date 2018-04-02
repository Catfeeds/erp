<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login;
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
            return view('index');
        }
        return redirect('login');
    }
    public function getUsers()
    {
        $type = Input::get('type');
        $users = User::all();
        return response()->json([
            'code'=>'200',
            'msg'=>'SUCCESS',
            'data'=>$users
        ]);
    }


    

}
