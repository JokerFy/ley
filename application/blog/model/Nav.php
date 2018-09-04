<?php
namespace app\blog\model;
use think\Model;

class Nav extends Model
{
    protected $table = 'cms_menu';
    public function getHomeNavs()
    {
        $data = array(
            'status' => 1,
        );

        return $res = self::where($data)
            ->order('listorder desc,id desc')
            ->select();
    }
}