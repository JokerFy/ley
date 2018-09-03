<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/27
 * Time: 16:55
 */

namespace app\lib\exception;


class CurdException extends BaseException
{
    public $code = 400;
    public $errorCode = 3000;
    public $msg = "Curd method has error";
}