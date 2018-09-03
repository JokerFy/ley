<?php

namespace app\admin\model;

use app\lib\exception\CurdException;
use think\Db;
use think\Exception;
use app\lib\exception\LoginException;

class Admin extends Base
{
    protected $autoWriteTimestamp = true;

    /**
     * 管理员添加或者编辑
     * @param $data
     * @return false|int
     */
    public function adminStore($data)
    {
        try {
            $data['password'] = md5($data['password'] . config('secure.admin_salt'));
            if (isset($data['id'])) {
                //判断该用户是否已经存在于一个用户组
                $isGroup = Db::name('auth_group_access')->where('uid', $data['id'])->find();
                $result = $this->allowField(true)->save($data, ['id' => $data['id']]);
                if ($isGroup) {
                    $group = Db::name('auth_group_access')->where('uid', $data['id'])->update(['group_id' => $data['group_id']]);
                } else {
                    $group = Db::name('auth_group_access')->insert(['uid' => $data['id'], 'group_id' => $data['group_id']]);
                }

            } else {
                $result = $this->relationSave($data);
            }
            return $result;
        }catch (Exception $e){
            $exception = new CurdException(
                [
                    'errorCode'=>3001,
                    'msg' => is_array($this->error) ? implode(
                        ';', $this->error) : $this->error,
                ]
            );
            throw $exception;
        }
    }

    /**
     * 将用户和用户组关系存入数据库
     * @param $data
     * @return false|int
     */
    public function relationSave($data)
    {
        $result = $this->data($data)->allowField(true)->save();
        $uid = $this->getLastInsID();
        $groupid = $data['group_id'];
        $group = Db::name('auth_group_access')->insert(['uid' => $uid, 'group_id' => $groupid]);
        return $result;
    }

    /**
     * 关联删除admin和用户组关系表数据
     * @param $id
     * @return bool
     * @throws Exception
     */
    public static function relationDelete($id)
    {
        try {
            Db::query('delete a,g from cms_admin as a left join cms_auth_group_access as g ON a.id = g.uid where a.id = :id',
                ['id' => $id]
            );
        } catch (Exception $e) {
            $exception = new CurdException(
                [
                    'errorCode'=>3001,
                    'msg' => $e->getMessage()
                ]
            );
            throw $exception;
        }
        return true;
    }

    /**
     * 数据分页
     * @return \think\Paginator
     */
    public function pageList()
    {
        $admin = session('adminUser');
        if ($admin['id'] == 1) {
            $groupid = getGroups($admin['id']);
            $pageList = Db::view('auth_group', 'id,pid,title')
                ->view('auth_group_access', 'uid,group_id', 'auth_group_access.group_id=auth_group.id')
                ->view('admin', 'id,username,email,create_time,status', 'admin.id=auth_group_access.uid')
                ->paginate(10);
        } else {
            $groupid = getGroups($admin['id']);
            $pageList = Db::view('auth_group', 'id,pid,title')
                ->view('auth_group_access', 'uid,group_id', 'auth_group_access.group_id=auth_group.id')
                ->view('admin', 'id,username,email,create_time,status', 'admin.id=auth_group_access.uid')
                ->where('auth_group.id|auth_group.pid', '=', $groupid)
                ->paginate(10);
        }

        return $pageList;
    }

    /**
     * 获取用户组
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getGroup()
    {
        $rolesModel = new AuthModel();
        $groups = $rolesModel->roleTree();
        $groupList = setPrefix($groups);
        return $groupList;
    }

    /**
     * 获取用户信息
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getInfo($id)
    {
        $res = Db::view('admin a','id,username,email')
            ->view('auth_group_access ag','uid,group_id','a.id=ag.uid')
            ->view('auth_group g','id,pid,title','ag.group_id=g.id')
            ->where('a.id','=',$id)
            ->find();
        return $res;
    }


    public function getAdminByUsername($username, $password)
    {
        $exist = self::where('username', $username)->where('status', 1)->find();
        if(!$exist){
            throw new LoginException([
                'msg'=>'账号不存在'
            ]);
        }
        $admin = self::where('username', $username)
                ->where('status', 1)
                ->where('password', md5($password . config('secure.admin_salt')))
                ->find();
        if(!$admin){
            throw new LoginException([
                'msg'=>'账号或密码错误'
            ]);
        }
        return $admin;
    }


}