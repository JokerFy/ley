<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/14
 * Time: 9:54
 */

namespace app\admin\model;
use think\Model;

class Base extends Model
{
    protected  $admin;
    protected  $adminId;

    public function initialize()
    {
        parent::initialize();
        $admin = session('adminUser');
        $this->admin = $admin;
        $this->adminId = $admin['id'];
    }

    protected function  prefixImgUrl($value, $data){
        $finalUrl = $value;
        if($data['from'] == 1){
            $finalUrl = config('secure.img_prefix').$value;
        }
        return $finalUrl;
    }
}