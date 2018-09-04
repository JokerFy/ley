<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/15
 * Time: 17:49
 */

namespace app\blog\controller;
use think\Controller;
use think\Db;
use app\admin\Model\Common as CommonModel;
class Common extends Controller
{
    public function __construct() {
        header("Content-type: text/html; charset=utf-8");
        parent::__construct();
    }
    /**
     * @return 获取排行的数据
     */
    public function getRank() {
        $conds['status'] = 1;
        $news = CommonModel::getRank($conds,10);
        return $news;
    }

    public function getCatList($id){
        $res = Db::table('news')
            ->where('catid','=',$id)
            ->where('status','=',1)
            ->order('listorder desc,id desc')
            ->select();
        return $res;
    }
}