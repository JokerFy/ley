<?php

namespace app\api\model;

use think\Model;

class User extends Base
{
    public static function check($ac, $se)
    {
        $app = self::where('username','=',$ac)
            ->where('password', '=',$se)
            ->find();
        return $app;

    }

    public static function generateName()
    {
        $str = '';
        for ($i = 1; $i <= 2; $i++) {
            $str .= chr(rand(97, 122));
        }
        $str .= chr(rand(65, 90));

        $uName =
            $str . strtoupper(dechex(date('m'))).date(
                'd') . substr(time(), -2) . substr(microtime(), 2, 3) . sprintf(
                '%02d', rand(0, 99));
        return $uName;
    }
}
