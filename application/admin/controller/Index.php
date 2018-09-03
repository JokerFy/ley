<?php

namespace app\admin\controller;

use app\admin\model\AuthModel;
use app\admin\model\Common as Common;
use think\Db;

class Index extends Base
{
    protected $navId;
    protected $admin;
    protected $adminId;

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->navId = request()->get('navId');
        $admin = session('adminUser');
        $this->admin = $admin;
        $this->adminId = $admin['id'];

        if (empty($this->navId)) {
            $rules = new AuthModel();
            $topNav = $rules->ruleTree();  // TODO: 获取用户的权限列表

            if (empty($navId)) {
                foreach ($topNav as $vo) {
                    if ($vo['pid'] == 0) {
                        $this->navId = $vo['id'];  // TODO: 将用户顶级权限中的第一个作为默认选择
                        break;
                    }
                }
            }

        }
    }

    public function index()
    {
        $topNav = Db::name('auth_rule')->where(['pid' => '0'])->select();
        return $this->fetch('', ['topNav' => $topNav, 'navId' => $this->navId]);
    }

    public function main()
    {
        return $this->fetch();
    }

    public function getLeftNav()
    {
        $navId = request()->post('navId');
        if (empty($navId)) {
            $navId = $this->navId;
        }
        $new = new AuthModel();
        $navMenu = $new->getLeftMenus($navId);
        return json_encode($navMenu);
    }


}