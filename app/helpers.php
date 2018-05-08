<?php
/**
 * Created by PhpStorm.
 * User: zeng
 * Date: 2018/4/26
 * Time: 上午11:15
 */
if (!function_exists('getRole')){
    function getRole($role){
        $uid = \Illuminate\Support\Facades\Auth::id();
        $admin = \App\Models\Role::where('user_id','=',$uid)
            ->where('role_name','=','admin')->first();
        if ($admin){
            $value = 'all';
        }else{
            $value = \App\Models\Role::where('user_id','=',$uid)
                ->where('role_name','=',$role)->pluck('role_value')->first();
            if (empty($value)){
                $value = 'off';
            }
        }
        return $value;
    }
    function getRoleProject($role)
    {
        $uid = \Illuminate\Support\Facades\Auth::id();
        $idArr = \App\Models\ProjectRole::where('role_value','=',$role)->where('start','<',time())->where('end','>',time())->where('user_id','=',$uid)->pluck('project_id')->toArray();
        return $idArr;
    }
    function checkRole($role,$id)
    {
        $task = \App\Models\Task::where('type','=',$role)->where('content','=',$id)
            ->where('user_id','=',\Illuminate\Support\Facades\Auth::id())->where('state','=',1)->first();
        if ($task){
            return true;
        }
        return false;
    }
}