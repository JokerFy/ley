<?php
/**
 * Created by 七月.
 * Author: 七月
 * 微信公号：小楼昨夜又秋风
 * 知乎ID: 七月在夏天
 * Date: 2017/2/25
 * Time: 17:21
 */

namespace app\api\service;
use app\api\model\User;
use app\lib\Aes;
use app\lib\exception\TokenException;

class AppToken extends Token
{
    public function get($ac, $se)
    {
        $app = User::check($ac, $se);
        if(!$app)
        {
            throw new TokenException([
                'msg' => '授权失败',
                'errorCode' => 10004
            ]);
        }
        else{
            $scope = $app->scope;
            $uid = $app->id;
            $values = [
                'scope' => $scope,
                'uid' => $uid
            ];
            $token = $this->saveToMysql($values);
            //返回给客户端的token先进行加密处理
            $token = (new Aes())->encrypt($token."||".$uid);
            return apiShow(config('code.success'), '授权成功', $token);
        }
    }
    
   /* private function saveToCache($values){
        $token = self::generateToken();
        $expire_in = config('app.token_expire_in');
        $result = cache($token, json_encode($values), $expire_in);
        if(!$result){
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $token;
    }*/

    private function saveToMysql($values){
        $token = self::generateToken();
        $data['time_out'] = time()+config('app.token_expire_in');
        $data['token'] = $token;
        $result = (new User())->save($data,['id'=>$values['uid']]);
        if(!$result){
            throw new TokenException([
                'msg' => '服务器异常',
                'errorCode' => 10005
            ]);
        }
        return $token;
    }
}