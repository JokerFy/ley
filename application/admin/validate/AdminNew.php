<?php
namespace app\admin\validate;

class AdminNew extends BaseValidate{
    protected $rule=[
        'username'=>'require|isNotEmpty',
        'password'=>'require|isNotEmpty',
        'email' => 'require|email'
    ];

}