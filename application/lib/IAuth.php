<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 17/7/28
 * Time: 上午12:27
 */
namespace app\lib;
use app\lib\Aes;
use think\Cache;
/**
 * Iauth相关
 * Class IAuth
 */
class IAuth {

    /**
     * 设置密码
     * @param string $data
     * @return string
     */
    public static  function setPassword($data) {
        return md5($data.config('app.password_pre_halt'));
    }

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

    /**
     * 检查sign是否正常
     * @param array $data
     * @param $data
     * @return boolen
     */
    public static function checkSignPass($data) {
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

        // 唯一性判定
       /* if (Cache::get($data['sign'])) {
            return false;
        }*/
     /*   if(!config('app_debug')) {

            //echo Cache::get($data['sign']);exit;
            // 唯一性判定
            if (Cache::get($data['sign'])) {
                return false;
            }
        }*/
        return true;
    }


    /**
     * 设置登录的token，唯一性
     * @param string $phone
     * @return string
     */
    static public function setAppLoginToken($phone = ''){
        $str = md5(uniqid(md5(microtime(true)),true)); //uniqid第二个参数加true会带上一个额外的内容避免多机部署token重复
        $str = sha1($str.$phone);
        return $str;
    }
}