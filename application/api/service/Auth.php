<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 17/7/28
 * Time: 上午12:27
 */
namespace app\api\service;

use app\lib\Aes;
use think\Cache;
use app\lib\exception\ParameterException;

/**
 * 对数据进行AES加解密相关操作
 * Class IAuth
 */
class Auth {

    public static $header;
    /**
     * 生成每次请求的sign
     * @param array $data
     * @return string
     */
    public static function setSign($data = []) {
        // 1 按字段排序
        ksort($data);
        // 2拼接字符串数据  &
        $string = http_build_query($data);
        // 3通过aes来加密
        $string = (new Aes())->encrypt($string);

        return $string;
    }


    public static function decSign($data = []) {
        $string = (new Aes())->decrypt($data);
        parse_str($string,$arr);
        return $arr;
    }

    /**
     * 检查每次app请求的数据是否合法
     * sign 加密需要 客户端工程师 ， 解密：服务端工程师
     * body仿照header做一个bodySign做参数的加解密（只要不是get类型）
     * 没必要每个数据进行加密，只需要每个部位（header,body）生成一个sign进行解密对照验证即可
     * 身份证，手机号，验证码等敏感信息应该进行单独加密
     */
    public static function checkRequestAuth($header,$body,$flag=true) {
        $bodyVali = empty($body)==$flag?true:false; //如果$body为空并且$flag为要检测body则返回true；
        // 基础参数校验
        if(empty($header['hsign'])||$bodyVali) {
            throw new ParameterException([
                'msg'=>'非法的sign参数'
            ]);
        }

        if(!self::checkSignPass($header,$body,$flag)) {
            throw new ParameterException([
                'code'=>'401',
                'msg'=>'sign授权失败'
            ]);
        }
        // 1、文件  2、mysql 3、redis（多机时推荐），一个sign生成后在配置时间内有效且只能调用一次保证唯一性与时效性
        Cache::set($header['hsign'], 1, config('app.app_sign_cache_time'));

        self::$header = $header;
        return true;
    }


    /**
     * 如果请求不是get类型
     * 检验header和body中的sign参数加密后是否正常
     * @param array $header,$body,flag
     * @param $data
     * @return boolen
     */
    public static function checkSignPass($header,$body=[],$flag=true)
    {

        //获取header头中自定义的固定参数进行加密，然后与两个sign参数做对比
        $headerArr = array(
            'app_type' => $header['app_type'],
            'version' => $header['version'],
            'did' => $header['did'],
            'time' => $header['time'],
        );

        $hSign = $header['hsign'];
        $hSignValidate = Auth::setSign($headerArr)==$hSign?true:false;
        //flag为true时代表body中有值，则需要进行body中的sign验证，反之则不用
        if($flag){
            $bSign = $body['bsign'];
            unset($body['bsign']);
            $bSignValidate = Auth::setSign($body)==$bSign?true:false;
        }else{
            $bSignValidate = true;
        }

        if(!$hSignValidate || !$bSignValidate){
            return false;
        }

        if(!config('app_debug')) {
            //此处参数中的时间是13位时间戳所以要除以1000
            if ((time() - ceil($headerArr['time']/1000)) > config('app.app_sign_time')) {
                return false;
            }
            //echo Cache::get($data['sign']);exit;
            // 唯一性判定
               if (Cache::get($hSign)){
                   return false;
               }
        }

        return true;
    }

    /**
     * 获取13位时间戳
     * @return int
     */
    public static function get13TimeStamp() {
        //将microtime函数获取的时间分配到t1,t2中然后再进行拼接获取13位时间戳
        list($t1, $t2) = explode(' ', microtime());
        return $t2 . ceil($t1 * 1000);
    }

/*    public static function checkSignPassbackup($data) {
        $str = (new Aes())->decrypt($data['sign']);

        if(empty($str)) {
            return false;
        }

        // diid=xx&app_type=3
        parse_str($str, $arr);
        if(!is_array($arr) || empty($arr['did']) || $arr['did'] != $data['did']) {
            return false;
        }

        if ((time() - ceil($arr['time'] / 1000)) > config('app.app_sign_time')) {
            return false;
        }

           if(!config('app_debug')) {
               //echo Cache::get($data['sign']);exit;
               // 唯一性判定
               if (Cache::get($data['sign'])) {
                   return false;
               }
           }
        return true;
    }*/



}