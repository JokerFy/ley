<?php
namespace app\admin\validate;

class LoginCheck extends BaseValidate{
    protected $rule=[
        'username'=>'require|isNotEmpty',
        'password'=>'require|isNotEmpty',
    ];
}