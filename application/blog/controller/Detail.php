<?php
namespace app\blog\controller;
use think\Controller;
use think\Db;

class Detail extends Controller
{
    public function index(){
        return $this->fetch('',['catId'=>0]);
    }
}