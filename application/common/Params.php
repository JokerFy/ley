<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/31
 * Time: 14:19
 */

namespace app\common;

use app\lib\exception\CurdException;
use app\lib\exception\ParameterException;

class Params
{
    /**
     * 如果flag为true，则强制post数据不能为空
     * @param bool $flag
     * @return bool
     */
    public static function postCheck()
    {
        $data = request()->post();
        if (!$data) {
            return false;
        }
        return $data;
    }

    public static function idCheck()
    {
        $id = request()->get('id');
        if (!$id) {
            return false;
        }
        return $id;
    }

    public static function idParams()
    {
        $params = request()->param();
        if (!isset($params['id']) || empty($params['id'])) {
            throw new ParameterException([
                'msg' => 'id不能为空'
            ]);
        }
        return $params['id'];
    }

    public static function dataParams()
    {
        $data = request()->post();
        if (!$data) {
            throw new ParameterException([
                'msg' => '数据不能为空'
            ]);
        }
        return $data;
    }
}