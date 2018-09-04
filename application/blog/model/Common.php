<?php
namespace app\blog\model;
use think\Db;
use think\Model;

class Common extends Model
{
    public function __construct() {
        header("Content-type: text/html; charset=utf-8");
        parent::__construct();
    }
    
    public static function getCatList($id){
        $res = Db::name('news')
            ->where('catid','=',$id)
            ->where('status','=',1)
            ->order('listorder desc,id desc')
            ->paginate(6);
        return $res;
    }
}