<?php
/**
 * Created by PhpStorm.
 * User: finley
 * Date: 2018/6/9
 * Time: 19:38
 */

namespace app\admin\controller\auth;
use app\admin\controller\Base;
use app\admin\model\AuthModel;
use app\common\Params;
use app\lib\exception\CurdException;
use app\lib\exception\SuccessNotify;
use think\Auth;
use think\Db;
use think\Exception;

class Roles extends Base
{
    private $authModel;
    public function _initialize()
    {
        parent::_initialize();
        $this->authModel = new AuthModel();
    }

    public function index()
    {
        $roleList = $this->authModel->roleList();
        $pages = $roleList->render();
        return $this->fetch('', ['roleList' => $roleList,'pages'=>$pages]);
    }

    /**
     * 根据目前用户的组别和权限进行角色添加
     * @return mixed
     */
    public function add()
    {
        $auth = new Auth();
        $admin = session('adminUser');
        $ruleList =   $this->authModel->ruleTree();
        if($admin['id']==1){
            $roleFather[0]['uid'] = 1;
        }else{
            $roleFather = $auth->getGroups($admin['id']); //获取当前用户组为父用户组
        }
        $roleSelect = $this->authModel->roleTree(); //获取当前用户组的子用户组
        $roleSelect = setPrefix($roleSelect);

        $data = Params::postCheck(); //TODO 判断是否是保存操作
        if(!empty($data)){
            $data['rules'] = implode(',', $data['rules']);
            try
            {
                Db::name('auth_group')->insert($data);
            }
            catch (Exception $e)
            {
                throw new CurdException([
                    'msg'=>'添加失败'
                ]);
            }

            throw new SuccessNotify();
        }

        return $this->fetch('', ['ruleList' => $ruleList,'roleSelect'=>$roleSelect,'father'=>$roleFather]);
    }

    public function edit()
    {
        if (Params::idParams()) {
            $admin = session('adminUser');
            $auth = new Auth();
            $ruleList =   $this->authModel->ruleTree();
            if($admin['id']==1){
                $roleFather[0]['uid'] = 1;
            }else{
                $roleFather = $auth->getGroups($admin['id']); //获取当前用户组为父用户组
            }
            $roleSelect = $this->authModel->roleTree(); //获取当前用户组的子用户组
            $roleSelect = setPrefix($roleSelect);
            $result = Db::name('auth_group')->where('id', Params::idParams())->find();

            $data = Params::postCheck(); //TODO 判断是否是保存操作
            if(!empty($data)&&isset($data['id'])){
                $data['rules'] = implode(',', $data['rules']);
                try
                {
                    Db::name('auth_group')->where('id',$data['id'])->update($data);
                }
                catch (Exception $e)
                {
                    throw new CurdException([
                        'msg'=>'编辑失败'
                    ]);
                }

                throw new SuccessNotify();
            }
            $params = [
                'ruleList' => $ruleList,
                'rolesInfo' => $result,
                'roleSelect'=>$roleSelect,
                'father'=>$roleFather
            ];
            return $this->fetch('', $params);
        }
    }

    /**
     * 根据group和auth_group_access关联删除
     * @return mixed
     */
    public function delete()
    {
        authModel::relationDelete(Params::idParams());
        throw new SuccessNotify([
            'msg'=>'删除成功'
        ]);
    }


}