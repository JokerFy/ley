<?php
/**
 * Created by 七月
 * Author: 七月
 * 微信公号: 小楼昨夜又秋风
 * 知乎ID: 七月在夏天
 * Date: 2017/2/24
 * Time: 17:18
 */

namespace app\api\service;

use app\lib\exception\TokenException;
use app\lib\exception\ForbiddenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    //验证token是否合法或者是否过期
    //验证器验证只是token验证的一种方式
    //另外一种方式是使用行为拦截token，根本不让非法token
    //进入控制器
    public static function needPrimaryScope()
    {
        $uid = self::getCurrentTokenVar('uid');
        if (!$uid) {
            throw new TokenException();
        }
    }

    // 生成令牌
    public static function generateToken()
    {
        $str = md5(uniqid(md5(microtime(true)),true)); //uniqid第二个参数加true会带上一个额外的内容避免多机部署token重复
        $str = sha1($str.$tokenSalt = config('app.token_salt'));
        return $str;
    }

    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()
            ->header('token');
        $vars = Cache::get($token);
        if (!$vars)
        {
            throw new TokenException();
        }
        else {
            if(!is_array($vars))
            {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            }
            else{
                throw new Exception('尝试获取的Token变量并不存在');
            }
        }
    }

    public static function verifyToken($token)
    {
        $exist = Cache::get($token);
        if($exist){
            return true;
        }
        else{
            return false;
        }
    }


}