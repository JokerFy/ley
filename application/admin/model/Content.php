<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/30
 * Time: 14:49
 */

namespace app\admin\model;

use app\lib\exception\AddException;
use app\lib\exception\CurdException;
use think\Db;
use think\Exception;
use think\Model;

class Content extends Model
{
    protected $table = 'cms_news';
    protected $autoWriteTimestamp = true;

    public function addNews($data)
    {

        try {
            Db::startTrans();
            self::data($data)->allowField(true)->save();//插入主表
            $newsContent = [
                'content' => $data['content'],
                'news_id' => $this->id,
            ];
            Db::name('news_content')->insert($newsContent); //插入副表
            Db::commit();
        } catch (Exception $ex) {
            Db::rollback();
            throw $ex;
        }
    }

    public function editNews($id,$data)
    {
        try {
            Db::startTrans();
            $this->allowField(true)->save($data, ['id' => $id]);//更新主表
            Db::name('news_content')->where('news_id', $id)->update(['content'=>$data['content']]);  //更新副表
            Db::commit();
        } catch (Exception $ex) {
            Db::rollback();
            throw $ex;
        }
    }


}