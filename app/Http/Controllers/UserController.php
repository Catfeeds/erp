<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login;
use App\Providers\AuthServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function loginPage()
    {
        return 'LoginPage';
    }
    public function login(Login $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        if (Auth::attempt(['username'=>$username,'password'=>$password],true)){
            return 'SUCCESS';
        }else{
            return redirect()->back()->withErrors([
                '用户名不存在或密码错误！'
            ]);
        }
    }
    public function logout()
    {
        if (Auth::logout()){
            return redirect('login');
        }
        return redirect('login');
    }
    

}
