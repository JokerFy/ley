<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Db;

function  show($status,$message) {
    $reuslt = array(
        'code' => $status,
        'msg' => $message
    );
    exit(json_encode($reuslt));
}

/**
 * 通用化api接口数据输出
 * @param int $status 业务状态码
 * @param string $message 信息提示
 * @param array $data 数据
 * @param int $httpCode http状态码
 */
function  apiShow($status,$message,$data=[],$httpCode=200) {
    $reuslt = array(
        'status' => $status,
        'message' => $message,
        'data' => $data,
    );
    return json($reuslt,$httpCode);
}

function menuTree($menus, $level = 0)
{
    $tree = [];
    foreach ($menus as $menu) {
        if ($menu['pid'] == $level) {
            $tree[] = $menu;
            $tree = array_merge($tree, menuTree($menus, $menu['id']));
        }
    }
    return $tree;
}

/**
 * 根据长度生成随机数
 * @param $length
 * @return null|string
 */
function getRandChar($length)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) - 1;

    for ($i = 0;
         $i < $length;
         $i++) {
        $str .= $strPol[rand(0, $max)];
    }

    return $str;
}

function getMenuUrl($nav) {
    $url = '/admin/'.$nav['c'].'/'.$nav['a'];
    if($nav['f']=='index') {
        $url = '/admin.php?c='.$nav['c'];
    }
    return $url;
}

/**
 * kindeditor编辑器中处理图片的反馈信息
 * @param $status
 * @param $data
 */
function showKind($status,$data) {
    header('Content-type:application/json;charset=UTF-8');
    if($status===0) {
        exit(json_encode(array('error'=>0,'url'=>$data)));
    }
    exit(json_encode(array('error'=>1,'message'=>'上传失败')));
}

/**
 * 为菜单或规则设置前缀
 * @param $data
 * @param string $p
 * @return array
 */
function setPrefix($data, $p = '|---')
{
    $tree = [];
    $num = 1;
    $prefix = [0 => 1];
    while ($val = current($data)) {
        $key = key($data);
        if ($key > 0) {
            if ($data[$key - 1]['pid'] != $val['pid']) {
                $num++;
            }
        }
        if (array_key_exists($val['pid'], $prefix)) {
            $num = $prefix[$val['pid']];
        }
        $val['title'] = str_repeat($p, $num) . $val['title'];
        $prefix[$val['pid']] = $num;
        $tree[] = $val;
        next($data);
    }
    return $tree;
}

/**
 * 将传入菜单进行无限极递归分类
 * @param $menus
 * @param int $pid
 * @return array
 */
function getTree($menus, $pid = 0)
{
    $tree = [];
    foreach ($menus as $key=>$value) {
        if ($menus[$key]['pid'] == $pid) {
            $tree[] = $menus[$key];
            $tree = array_merge($tree, getTree($menus, $menus[$key]['id']));
        }
    }
    return $tree;
}


/**
 * 根据用户id获取用户组,返回值为数组
 * @param  uid int     用户id
 * return array       用户所属的用户组 [
 *     'uid'=>'用户id','group_id'=>'用户组id'],
 */
function getGroups($uid) {
    $group = Db::name('auth_group_access')->where('uid',$uid)->find();
    return $group['group_id'];
}