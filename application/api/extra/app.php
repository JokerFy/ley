<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/16
 * Time: 15:44
 */
return [
    'password_pre_halt' => '$afaf3#157', //app端加密盐
    'aeskey' => 'daf#54@!4645.321k2o%k^1', //aes密钥，服务端和客户端必须保持一致
    'apptypes' => ['ios','android'],
    'app_sign_time' => 120000,
    'app_sign_cache_time'=>120000,
    'token_expire_in'=>7,
    'token_salt' => "FIadfiaji846@"
];