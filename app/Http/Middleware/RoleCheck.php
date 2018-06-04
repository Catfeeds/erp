<?php

namespace App\Http\Middleware;

use App\Models\ProjectRole;
use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Auth;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$premission)
    {
        $uid = Auth::id();
        $role = Role::where('role_name','=',$premission)->where('user_id','=',$uid)->first();
        $admin = Role::where('user_id','=',$uid)->where('role_name','=','admin')->first();
//        dd($admin);
        if (!$admin){
            if (!$role||$role->role_value=='off') {
                return redirect()->back()->with('status','无权访问！');
            }
        }
        return $next($request);
    }
}
