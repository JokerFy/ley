<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/8
 * Time: 11:17
 */

namespace app\admin\model;
use think\Db;
use think\Model;

class Common extends Model
{
    public static function getMenuByUser($uid){

        $group = Db::name('auth_group_access')->where('uid',$uid)->find();
        $rules = Db::name('auth_group')->where('id',$group['group_id'])->find();
        $rules = explode(',',$rules['rules']);

        $authMenu = [];
        foreach ($rules as $item){
            $authMenu[] = Db::name('auth_rule')->where('id',$item)->find();
        }
        return $authMenu;
    }

    public function getNewsByNewsIdIn($table,$newsIds) {
        if(!is_array($newsIds)) {
            throw exception("参数不合法");
        }
        $data = array(

            'id' => array('in',implode(',', $newsIds)),
        );

        return Db::name($table)->where($data)->select();
    }

    /**
     * 获取排行的数据
     * @param array $data
     * @param int $limit
     * @return array
     */
    public static function getRank($data = array(), $limit = 100) {
        $list = Db::name('news')->where($data)->order('id desc')->limit($limit)->select()->toArray();
        return $list;
    }

}