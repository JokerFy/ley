<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/4
 * Time: 9:44
 */

namespace app\admin\model;

use think\Model;

class Menu extends Model
{
    public function getNavMenus()
    {
        $data = array(
            'status' => array('neq', -1)
        );

        return $menu = self::where($data)
            ->order('listorder desc,id desc')
            ->select();
    }

    public function getHomeNavs() {
        $data = array(
            'status' => 1,
        );

        return $res = self::where($data)
            ->order('listorder desc,id desc')
            ->select();
    }

    public static function getBarMenus() {
        $data = array(
            'status' => 1,
//            'type' => 0,
        );

       return $res = self::where($data)
            ->order('listorder desc,id desc')
            ->select();
    }

    public static function updateListorderById($menuId, $v)
    {
        return self::where('id', $menuId)
            ->update(['listorder' => $v]);
    }
}