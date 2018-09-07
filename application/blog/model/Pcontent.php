<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/9/7
 * Time: 14:11
 */

namespace app\blog\model;
use think\Db;
use think\Model;

class Pcontent extends Model
{
    public $table = 'cms_position_content';

    public function getPositionContent()
    {
        $data['bigBanner'] = $this->getBigBanner();
        $data['Banner'] = $this->getBanner();
        $data['ArticleList'] = $this->getArticleList();
        return $data;
    }

    public function getBigBanner()
    {
        return self::where('position_id',15)
            ->order(['listorder'=>'desc','create_time'=>'desc'])
            ->limit(3)
            ->select();
    }

    public function getBanner()
    {
        return Db::name('news')
            ->order(['listorder'=>'desc','create_time'=>'desc'])
            ->find();
    }

    public function getArticleList()
    {
        /*return self::where('position_id',16)
            ->order(['listorder'=>'desc','create_time'=>'desc'])
            ->limit(6)
            ->select();*/
        return Db::name('news')
            ->order(['listorder'=>'desc','create_time'=>'desc'])
            ->limit(1,6)
            ->select();
    }
}