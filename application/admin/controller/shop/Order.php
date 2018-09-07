<?php
namespace app\admin\controller\shop;
use app\admin\model\Product as ProductModel;
use app\admin\controller\Base;
use think\Db;


class Order extends Base
{
    public function index()
    {
        $orderList = Db::name('order')->order('id desc')
            ->paginate(10);;
        $pages = $orderList->render();
        return $this->fetch('', ['list' => $orderList, 'pages' => $pages]);
    }

}