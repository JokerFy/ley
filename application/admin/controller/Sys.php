<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/7/4
 * Time: 9:36
 */

namespace app\admin\controller;
use think\Cache;

class Sys extends Base
{
    public function index()
    {
        $data = request()->post();
        if($data){
            Cache::store('file')->set('basic_web_config',$data);
            return show(config('code.success'),'设置成功');
        }
        $basicInfo = Cache::store('file')->get('basic_web_config');
        if(!$basicInfo){
            return $this->fetch('',['basic'=>$basicInfo]);
        }
        return $this->fetch();
    }
}