<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/15
 * Time: 17:49
 */

namespace app\blog\controller;
use app\blog\model\Common;
use think\Controller;
use think\Db;

class Cat extends Controller
{
    public function index(){
        $id = input('id');
        if(!$id) {
            $this->error('ID不存在');
        }
        $nav = Db::name("menu")->find($id);
        if(!$nav || $nav['status'] !=1) {
            $this->error('栏目id不存在或者状态不为正常');
        }
        $contentList = Common::getCatList($id);
        $pages = $contentList->render();
        return $this->fetch('',['catId'=>$nav['id'],'contentList'=>$contentList,'pages'=>$pages]);
    }
}