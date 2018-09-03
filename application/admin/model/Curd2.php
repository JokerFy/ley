<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/25
 * Time: 14:45
 */

namespace app\admin\model;
use think\Exception;
use think\Model;
use app\lib\exception\AddException;
class Curd extends Model
{
    private static $_instance = null;
    protected $autoWriteTimestamp = false;

    public static function getInstance(){
        if(!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct($data = [])
        {
            if(isset($data['table'])){
                $this->table = config('database.prefix').$data['table'];
            }else{
                $this->table = config('database.prefix').strtolower(request()->controller());
            }

            if(isset($data['autoWriteTimestamp'])){
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
        try{
            $this->data($data)->allowField(true)->save();
            return $this->id;
        }catch (Exception $e)
        {
            $exception = new AddException(
                [
                    // $this->error有一个问题，并不是一定返回数组，需要判断
                    'msg' => is_array($this->error) ? implode(
                        ';', $this->error) : $this->error,
                ]
            );
            throw $exception;
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
            $res = $this->where('id',$id)->update($data);
            return $res;
        }catch (Exception $e){
            throw $e;
        }
    }

    /**
     * 根据id获取一条数据
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * @throws Exception
     */
    public function getOne($id)
    {
        try{
            $res = $this->where('id',$id)->find();
            return $res;
        }catch (Exception $e){
            throw $e;
        }
    }

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
        }catch (Exception $e){
            throw $e;
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
        try{
            $res = $this->where('id',$id)->update(['status'=>0]);
            return $res;
        }catch (Exception $e){
            throw $e;
        }
    }

    /**
     * 获取列表数据分页
     * @return \think\Paginator
     */
    public function getList(){
        return $this->where('status',1)->order('id desc')->paginate(8);
    }

}