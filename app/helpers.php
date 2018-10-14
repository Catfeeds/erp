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
    /**
     * 设置redis缓存数据
     *
     */
    if (!function_exists('setRedisData')){
        function setRedisData($key,$value,$time=0){
            \Illuminate\Support\Facades\Redis::set($key,$value);
            if ($time!=0){
                \Illuminate\Support\Facades\Redis::expire($key,$time);
            }
        }
    }
    /**
     * 获取redis缓存数据
     */
    if (!function_exists('getRedisData')){
        function getRedisData($key,$default=0){
            $data = \Illuminate\Support\Facades\Redis::get($key);
            if (!$data){
                return $default;
            }
            return $data;
        }
    }
    if (!function_exists('getRedisTime')){
        function getRedisTime(){
            return strtotime(date('Y-m-d').'23:59:59')-time();
        }
    }
}