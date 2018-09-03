<?php
/**
 * Created by PhpStorm.
 * User: finley
 * Date: 2018/6/3
 * Time: 13:31
 */

namespace app\admin\controller;
use app\admin\model\Admin;
use app\admin\validate\LoginCheck;
use app\lib\exception\SuccessNotify;
use think\Controller;

class Login extends Controller
{
    public function test(){

    }

    public function index()
    {
        if (session('adminUser')) {
            $this->redirect('index/index');
        }
        return $this->fetch();
    }

    public function check($username = '', $password = '')
    {
        $ret = new Admin();
        (new LoginCheck())->goCheck();
        $result = $ret->getAdminByUsername($username, $password);
        session('adminUser', $result);
        throw new SuccessNotify([
            'msg'=>'登录成功'
        ]);
    }

    public function loginout()
    {
        session('adminUser', null);
        $this->redirect('index');
    }
}