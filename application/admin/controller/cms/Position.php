<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/7
 * Time: 10:19
 */

namespace app\admin\controller\cms;

use app\admin\controller\Base;
use app\common\model\Common;
use app\common\model\Curd;
use app\common\Params;
use app\lib\exception\SuccessNotify;
use think\Request;
use think\Db;

class Position extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $config = [
            'table' => 'position',
            'autoWriteTimestamp' => true
        ];
        Common::init($config);
    }

    public function index()
    {
        $list = Db::name('position')
            ->where(['status' => 1])->paginate(10);
        $pages = $list->render();
        return $this->fetch('', ['list' => $list, 'pages' => $pages]);
    }

    public function add()
    {
        Common::addWithPost();
        return $this->fetch('');
    }

    public function edit()
    {
        $id = Params::idParams();
        Common::editWithId();
        $result = Db::name('position')->where('id', $id)->find();
        return $this->fetch('', ['position' => $result]);
    }


    public function delete()
    {
        Common::delWithId();
    }
}