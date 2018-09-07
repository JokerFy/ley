<?php
namespace app\admin\controller\shop;
use app\admin\model\Product as ProductModel;
use app\admin\controller\Base;
use app\common\model\Common;
use think\Db;


class Product extends Base
{
    public function index(){
        //推荐位选择列表
        $positions = Db::name('position')
            ->select();

        $productlist = ProductModel::getProductList();

        $pages = $productlist->render();
        return $this->fetch('', ['list' => $productlist, 'pages' => $pages, 'position' => $positions]);
    }

    public function add()
    {
        $productCate = Db::name('product_category')->select();
        Common::addWithPost();
        return $this->fetch('', ['productCate' => $productCate]);
    }
}