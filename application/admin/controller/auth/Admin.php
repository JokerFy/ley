<?php
/**
 * Created by PhpStorm.
 * User: finley
 * Date: 2018/6/9
 * Time: 11:52
 */

namespace app\admin\controller\auth;

use app\admin\controller\Base;
use app\admin\model\Admin as AdminModel;
use app\common\Params;
use app\lib\exception\SuccessNotify;
use app\admin\validate\AdminNew;
use app\admin\validate\IDMustBePositiveInt;

class Admin extends Base
{

    private $obj;

    public function _initialize()
    {
        parent::_initialize();
        $this->obj = new \app\admin\model\Admin();
    }

    /**
     * 管理员列表页面
     * @return mixed
     */
    public function index()
    {
        $adminInfo = session('adminUser');
        $groupList = $this->obj->getGroup();
        $list = $this->obj->pageList();
        $pages = $list->render();
        return $this->fetch('', ['list' => $list, 'pages' => $pages, 'groupList' => $groupList, 'adminInfo' => $adminInfo]);
    }

    /**
     * 管理员添加页面
     * @return mixed
     */
    public function add()
    {
        if (Params::postCheck()) {
            (new AdminNew())->goCheck();
            $this->obj->adminStore(Params::dataParams());
            throw new SuccessNotify();
        }
        $groupList = $this->obj->getGroup();
        return $this->fetch('', ['groupList' => $groupList]);
    }


    /**
     * 管理员编辑页面
     * @return mixed
     */
    public function edit()
    {
        (new IDMustBePositiveInt())->goCheck();
        if (Params::postCheck()) {
            $this->obj->adminStore(Params::dataParams());
            throw new SuccessNotify();
        }
        $groupList = $this->obj->getGroup();
        $result = AdminModel::getInfo(Params::idParams());
        return $this->fetch('', ['admin' => $result, 'groupList' => $groupList]);
    }

    /**
     * 根据admin和auth_group_access关联删除
     * @return mixed
     */
    public function delete()
    {
        AdminModel::relationDelete(Params::idParams());
        throw new SuccessNotify();
    }

}