<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/14
 * Time: 11:58
 */

namespace app\admin\model;

use app\lib\exception\CurdException;
use think\Exception;
use think\Model;
use think\Db;
use think\Auth;

class AuthModel extends Model
{
    protected $admin;
    protected $adminId;

    public function initialize()
    {
        parent::initialize();
        $admin = session('adminUser');
        $this->admin = $admin;
        $this->adminId = $admin['id'];
    }


    //roles
    /**
     * 用户组与用户组关系表一对多关联
     */
    /*    public function authgroup(){
            return $this->hasMany('auth_group_access','group_id','id');
        }*/

    /**
     * 根据当前角色权限返回分页数据
     * @return \think\Paginator
     */
    public function roleList()
    {
        if ($this->adminId == 1) {
            $roleList = Db::name('auth_group')->where('status', 1)->paginate(10);
        } else {
            $group = Db::name('auth_group_access')->where('uid', $this->adminId)->field('group_id')->find();
            $roleList = Db::name('auth_group')->where('pid', $group['group_id'])->paginate(10);
        }
        return $roleList;
    }

    /**
     * 关联删除角色与用户角色的对应数据
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public static function relationDelete($id)
    {
        try {
            Db::query('Delete a,g from cms_auth_group as a LEFT JOIN cms_auth_group_access as g ON a.id = g.group_id WHERE a.id=:id',
                ['id' => $id]
            );
        } catch (Exception $e) {
            $exception = new CurdException(
                [
                    'errorCode'=>3002,
                    'msg' => $e->getMessage()
                ]
            );
            throw $exception;
        }
        return true;
    }

    /**
     * 根据当前角色权限返回角色树
     * @return array
     */
    public function roleTree()
    {
        $auth = new Auth();
        if ($this->adminId == 1) {
            $roleSelect = Db::name('auth_group')->select();
            $tree = getTree($roleSelect);
        } else {
            $roleSelect = $auth->getGroups($this->adminId);
            $groupid = collection($roleSelect)->toArray(); //当前用户所属用户分组
            $roles = Db::name('auth_group')->select();
            $tree = getTree($roles, $groupid[0]['group_id']);
        }
        return $tree;
    }

    //-roles-end


    //-rules

    /**
     * 返回规则树
     * @return array
     */
    public function ruleTree()
    {
        if ($this->adminId == 1) {
            $ruleList = Db::name('auth_rule')->select();
        } else {
            $ruleList = self::getRulesByGroup($this->adminId);
        }
        $ruleList = collection($ruleList)->toArray();
        $tree = getTree($ruleList);
        return $tree;
    }


    /**
     * 根据用户id返回该用户拥有的权限
     * @param $uid
     * @return false|static[]
     */
    public static function getRulesByGroup($uid)
    {
        $auth = new Auth();
        $group = $auth->getGroups($uid);
        $rules = explode(',', $group[0]['rules']);
        $rulesList = Db::name('auth_rule')->order('listorder desc')->select($rules);
        return $rulesList;
    }

    //rules-end

    /**
     * 根据顶部导航栏id查找左侧导航栏id
     * @param $navId
     * @return array
     */
    public function getLeftMenus($navId)
    {
        $uid = $this->adminId;
        if ($uid == 1) {
            $navMenu = Db::name('auth_rule')->where('level', 2)
                ->where('pid', $navId)
                ->order('listorder desc,id asc')
                ->field(['id', 'title', 'icon', 'level', 'pid', 'name'])
                ->select()
                ->toArray();
            foreach ($navMenu as $key => $value) {
                $navMenu[$key]['children'] = Db::name('auth_rule')
                    ->where(['pid' => $navMenu[$key]['id'], 'level' => 3])
                    ->field(['id', 'title', 'icon', 'name'])
                    ->select()
                    ->toArray();
                if (empty($navMenu[$key]['children'])) {
                    unset($navMenu[$key]['children']);
                }

            }
            return $navMenu;
        } else {
            $navMenu = Common::getMenuByUser($uid);
            $nav = [];
            foreach ($navMenu as $item) {
                if ($item['level'] == 2) {
                    $nav[] = $item;
                }
            }
            foreach ($nav as $key=>$value) {
                foreach ($navMenu as $item) {
                    if ($item['level'] == 3 && $item['pid'] == $nav[$key]['id']) {
                        $nav[$key]['children'][] = $item;
                    }
                }
                if (!isset($nav[$key]['children'])) {
                    unset($nav[$key]['children']);
                }
            }
            return $nav;
        }
    }

}