<?php
/**
 * Created by 七月
 * User: 七月
 * Date: 2017/2/15
 * Time: 13:40
 */

namespace app\api\controller\v1;
use app\api\service\Auth;
use app\api\controller\BaseController as Base;

class Test
{
    public function test()
    {
        $header = request()->header();
        $headerArr = array(
            'app_type' => $header['app_type'],
            'version' => $header['version'],
            'did' => $header['did'],
//            'time' => Base::get13TimeStamp(),
            'time' => $header['time'],
        );
        $body = request()->post();
        $headerSign = Auth::setSign($headerArr);
        $bodySign = Auth::setSign($body);

        /*$headerSign = '6DlwgdIUB4LhOc3AOQ2ool7fY7KXHvX6EkNno9XTOCE4jLtIUN3+IHz2W/y8aG+ZGKrU27jOmM0v8LePeZRtyQ==';
        $bodySign = "Lcg0NsxMn+Mbu/0eGATEUA==";*/


//        print_r($header = Auth::decSign($headerSign));exit;
//        print_r($body = Auth::decSign($bodySign));exit;
        echo($headerSign.'<br>');
        echo($bodySign);
        exit;
    }

    public function ttt()
    {
        $header = request()->header();
        $body = request()->post();

        //获取header头中自定义的固定参数进行加密，然后与两个sign参数做对比
        $headerArr = array(
            'app_type' => $header['app_type'],
            'version' => $header['version'],
            'did' => $header['did'],
            'time' => $header['time'],
        );

        $hSign = $header['hsign'];
        $bSign = $body['bsign'];
        unset($body['bsign']);

        $hSignValidate = Auth::setSign($headerArr);
        $bSignValidate = Auth::setSign($body);

        if($hSign != $hSignValidate || $bSign != $bSignValidate){
            return apiShow(config('code.failed'),'接口授权失败','',401);
        }

        return apiShow(config('code.success'),'成功','',200);
    }
}