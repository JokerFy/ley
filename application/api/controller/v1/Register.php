<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/21
 * Time: 17:33
 */

namespace app\api\controller\v1;
use app\api\service\Token as Tokenservice;
use app\lib\enum\ScopeEnum;
use app\api\controller\BaseController;
use app\api\model\User;
use app\lib\Aes;

class Register
{
    public function phone(){
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
        $token = Tokenservice::generateToken();
        $data = [
            'token' => $token,
            'scope' => ScopeEnum::User,
            'time_out' => strtotime('+'.config('app.token_expire_in').'days'),
            'username' => User::generateName(),
            'status' => 1,
            'phone' => $param['phone']
        ];

        $id = (new User())->add($data);

        if($id){
            $result = [
                'token' => (new Aes())->encrypt($token."||".$id),
            ];
            return apiShow(config('code.success'), 'ok', $result);
        }

        return apiShow(config('code.failed'), '手机注册失败');
    }
}