<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/25
 * Time: 14:45
 */

namespace app\admin\model;

use app\lib\exception\CurdException;
use think\Db;
use think\Exception;
use think\Model;
use app\lib\exception\AddException;

class Curd extends Model
{
    protected $autoWriteTimestamp = false;
    protected $tableStore;

    public function __construct($data = [])
    {
        if (isset($data['table'])) {
            $this->tableStore = $data['table'];
            $this->table = config('database.prefix') . $data['table'];
        } else {
            $this->table = config('database.prefix') . strtolower(request()->controller());
        }

        if (isset($data['autoWriteTimestamp'])) {
            $this->autoWriteTimestamp = $data['autoWriteTimestamp'];
        }
        parent::__construct($data);
    }


    public function listUpdate($id, $listid, $table)
    {
        $res = Db::name($table)->where('id', $id)->update(['listorder' => $listid]);
        return $res;
    }

    /**
     * 增加一条或多条操作
     * @param $data
     * @return \think\Request
     * @throws Exception
     */
    public function add($data)
    {
//        halt($this->table);
        self::data($data)->allowField(true)->save();
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

        return $this->where('id', $id)->update($data);

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
        try {
            $res = $this->where('id', $id)->delete();
            return $res;
        } catch (Exception $e) {
            throw new CurdException(
                [
                    'msg' => '删除失败'
                ]
            );
        }
    }

    /**
     * 软删除
     * @param $id
     * @return $this
     * @throws Exception
     */
    public function fakeDel($id)
    {
        try {
            $res = $this->where('id', $id)->update(['status' => 0]);
            return $res;
        } catch (Exception $e) {
            throw new CurdException(
                [
                    'msg' => '删除失败'
                ]
            );
        }
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