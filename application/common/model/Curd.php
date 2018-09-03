<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/25
 * Time: 14:45
 */

namespace app\common\model;

use think\Exception;
use think\Model;

class Curd extends Model
{
    protected $autoWriteTimestamp = false;

    public function __construct($data = [])
    {
        if (isset($data['table'])) {
            $this->table = config('database.prefix') . $data['table'];
        } else {
            $this->table = config('database.prefix') . strtolower(request()->controller());
        }

        if (isset($data['autoWriteTimestamp'])) {
            $this->autoWriteTimestamp = $data['autoWriteTimestamp'];
        }

        parent::__construct($data);
    }

    /**
     * 增加一条或多条操作
     * @param $data
     * @return \think\Request
     * @throws Exception
     */
    public function add($data)
    {
        $this->data($data)->allowField(true)->save();
        return $this->id;
    }

    /**
     * 更新指定数据
     * @param $id
     * @param $data
     * @return $this
     * @throws Exception
     */
    public function refreshData($id, $data)
    {
        $res = $this->where('id', $id)->update($data);
        return $res;

    }

    /**
     * 根据id获取一条数据
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * @throws Exception
     */
    public function getOne($id)
    {
        $res = $this->where('id', $id)->find();
        return $res;
    }

    /**
     * 从数据库中删除
     * @param $id
     * @return int
     * @throws Exception
     */
    public function realDel($id)
    {
        $res = $this->where('id', $id)->delete();
        return $res;

    }

    /**
     * 软删除
     * @param $id
     * @return $this
     * @throws Exception
     */
    public function fakeDel($id)
    {
        $res = $this->where('id', $id)->update(['status' => 0]);
        return $res;

    }

    /**
     * 获取列表数据分页
     * @return \think\Paginator
     */
    public function getList()
    {
        return $this->where('status', 1)->order('id desc')->paginate(8);
    }

}