<?php
namespace app\blog\controller;

use app\blog\model\Pcontent;
use think\Cache;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
    {
        $pcontent = (new Pcontent())->getPositionContent();
//        print_r($pcontent);exit;
        return $this->fetch('',['catId'=>0,'pcontent'=>$pcontent]);
    }



}
