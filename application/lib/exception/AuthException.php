<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/27
 * Time: 16:55
 */

namespace app\lib\exception;


class AuthException extends BaseException
{
    public $code = 400;
    public $errorCode = 20000;
    public $msg = "权限不足";
}