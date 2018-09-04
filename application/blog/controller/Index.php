<?php
namespace app\blog\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $result = [
            'catId'=>0,
            ];
        return $this->fetch('',$result);
    }

}
