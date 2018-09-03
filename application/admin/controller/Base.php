<?php
/**
 * Created by PhpStorm.
 * User: finley
 * Date: 2018/6/3
 * Time: 11:34
 */

namespace app\admin\controller;

use app\admin\validate\IDMustBePositiveInt;
use app\common\Params;
use app\lib\exception\AuthException;
use app\lib\exception\ParameterException;
use app\lib\exception\SuccessNotify;
use think\Auth;
use think\Controller;
use think\Db;
use think\Request;
use \app\admin\model\Curd;

class Base extends Controller
{
    protected $Curd;

    public function _initialize()
    {
      /*  $data['autoWriteTimestamp'] = true;
        $this->Curd = new Curd($data);*/
        //实例化通用的CURD模型
        $res = session('adminUser');
        $uid = $res['id'];
        if (!$uid) {
            $this->redirect('Login/index');
        } elseif ($uid == 1) {
            return true;
        }
        $request = Request::instance();
        $name = $request->module() . '/' . $request->controller() . '/' . $request->action();
        $nocheck = ['admin/Index/index', 'admin/Index/main', 'admin/Index/getleftnav', 'admin/Login/index'];
        if (in_array($name, $nocheck)) {
            return true;
        }
        $auth = new Auth();
        if ($auth->check($name, $res['id']) === false) {// 第一个参数是规则名称,第二个参数是用户UID
            if (empty($res)) {
                $this->error("您还没有登录！", 'Login/index');
            }
//            $this->error('你没有权限访问');
            throw new AuthException();

        }
        return true;
    }

    /**
     * 排序功能
     */
    public function listorder()
    {
        $data = Params::dataParams();
        if ($data['listorder']) {
            foreach ($data['listorder'] as $menuId => $v) {
                // 执行更新
                (new Curd())->listUpdate($menuId, $v,$data['table']);
            }
            throw new SuccessNotify([
                'msg' => '排序成功'
            ]);
        }
    }

    /**
     * 更改状态
     */
    public function changeStatus()
    {
        $data = Params::dataParams();
        (new IDMustBePositiveInt())->goCheck();
        if ($data['id'] && $data['status']) {
            $status = $data['status'] == 1 ? -1 : 1;
            $res = Db::name($data['model'])->update(['status' => $status, 'id' => $data['id']]);
            if ($res)
                throw new SuccessNotify([
                    'msg'=>'状态更改成功'
                ]);
        }
    }

}