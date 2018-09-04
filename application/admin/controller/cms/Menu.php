<?php
/**
 * Created by PhpStorm.
 * User: finley
 * Date: 2018/6/3
 * Time: 22:13
 */

namespace app\admin\controller\cms;

use app\admin\controller\Base;
use app\admin\model\Menu as MenuModel;
use app\common\model\Common;
use app\common\Params;
use think\Db;
use think\Request;


class Menu extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $config = [
            'table' => 'menu',
            'autoWriteTimestamp' => false
        ];
        Common::init($config);
    }


    public function index()
    {
        return $this->fetch('');
    }

    public function add()
    {
        Common::addWithPost();
        $parentMenu = Db::name('menu')->where('parentid', 0)->select();
        return $this->fetch('', ['parentMenu' => $parentMenu]);
    }

    public function edit()
    {
        $id = Params::idParams();
        Common::editWithId();
        $result = MenuModel::get($id);
        $parentMenu = Db::table('cms_menu')->where('parentid', 0)->select();
        return $this->fetch('', ['menu' => $result, 'parentMenu' => $parentMenu]);

    }


    public function delete()
    {
        Common::delWithId();
    }

}

