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
use think\Exception;
use think\Model;

class Content extends Model
{
    protected $table = 'cms_news';
    protected $autoWriteTimestamp = true;

    /**
     * 从数据库中删除
     * @param $id
     * @return int
     * @throws Exception
     */
    public function realDel($id)
    {
        try{
            $res = $this->where('id',$id)->delete();
            return $res;
        }
        catch (Exception $e)
        {
            throw new CurdException(
                [
                    'msg'=>'删除失败'
                ]
            );
        }
    }

    public function add($data){
        try{
            $this->data($data)->allowField(true)->save();
            return $this->id;
        }catch (Exception $e)
        {
            throw new CurdException(
                [
                    'msg'=>'添加失败'
                ]
            );
        }
    }

    /**
     * 更新指定数据
     * @param $id
     * @param $data
     * @return $this
     * @throws Exception
     */
    public function refreshData($id,$data)
    {
        try{
            $this->where('id',$id)->update($data);
        }
        catch (Exception $e)
        {
            throw new CurdException(
                [
                    'msg'=>'更新失败'
                ]
            );
        }
    }

}