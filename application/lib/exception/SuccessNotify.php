<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/27
 * Time: 16:55
 */

namespace app\lib\exception;


class SuccessNotify extends BaseException
{
    public $code = 200;
    public $errorCode = 0;
    public $msg = "操作成功";
}