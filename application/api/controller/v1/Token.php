<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 17/8/5
 * Time: 下午4:37
 */
namespace app\api\controller\v1;
use app\lib\Aes;
use app\api\service\AppToken;
use app\api\service\Token as TokenService;
use app\lib\exception\ParameterException;

class Token {

    /**
     * 第三方应用获取令牌
     * @url /app_token?
     * @POST ac=:ac se=:secret
     */
    public function getAppToken($ac='', $se='')
    {
        $app = new AppToken();
        $token = $app->get($ac, $se);
        return [
            'token' => $token
        ];
    }

    public function verifyToken($token='')
    {
        if(!$token){
            throw new ParameterException([
                'token不允许为空'
            ]);
        }
        $valid = TokenService::verifyToken($token);
        return [
            'isValid' => $valid
        ];
    }

/*    public function save(){
        if(!request()->post()){
            return apiShow(config('code.error'), '您没有权限', '', 403);
        }

        $param = input('param.');

        if(empty($param['phone'])){
            return apiShow(config('code.error'), '手机号不合法', '', 404);
        }

        if(empty($param['code'])){
            return apiShow(config('code.error'), '手机短信验证码不存在', '', 404);
        }
        //第一次登录 注册数据
        $token = IAuth::setAppLoginToken($param['phone']);
        $data = [
            'token' => $token,
            'scope' => ScopeEnum::User,
            'time_out' => strtotime('+'.config('app.token_expire_in').'days'),
            'username' => User::generateName(),
            'status' => 1,
            'phone' => $param['phone']
        ];

        $id = (new User())->add($data);
        $obj = new Aes();

        if($id){
            $result = [
                'token' => $obj->encrypt($token."||".$id),
            ];
            return apiShow(config('code.success'), 'Ok', $result);
        }
    }*/

}