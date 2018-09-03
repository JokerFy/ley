<?php
/**
 * Created by 七月.
 * Author: 七月
 * 微信公号：小楼昨夜又秋风
 * 知乎ID: 七月在夏天
 * Date: 2017/3/5
 * Time: 17:59
 */

namespace app\api\controller;

use app\api\service\Token;
use think\Controller;
use app\api\service\Auth;


class BaseController extends Controller
{
    public function _initialize() {
        $flag = true;
        $headers = request()->header();
        $method = request()->method();
        $body = request()->$method();
        if($method=='GET'||$method=='get'){
            $flag = false;
        }
        //接口参数校验
        Auth::checkRequestAuth($headers,$body,$flag);


    }

    /**
     * 用户接口权限检测
     */
    protected function checkPrimaryScope()
    {
        Token::needPrimaryScope();
    }


    /**
     * 获取13位时间戳
     * @return int
     */
    public static function get13TimeStamp() {
        list($t1, $t2) = explode(' ', microtime());
        return $t2 . ceil($t1 * 1000);
    }
}