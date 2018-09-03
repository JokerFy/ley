<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/9/3
 * Time: 14:34
 */

namespace app\common\model;


use app\common\Params;
use app\lib\exception\SuccessNotify;

class Common
{
    protected static $curd;

    static function init($config){
        $config = [
            'table' => $config['table'],
            'autoWriteTimestamp' =>$config['autoWriteTimestamp']
        ];
        self::$curd = new Curd($config);
    }

    /**
     * 判断是否是POST请求，并且保存数据
     * @throws SuccessNotify
     */
    static function addWithPost(){
        $data = Params::postCheck();
        if ($data) {
            self::$curd->add($data);
            throw new SuccessNotify([
                'msg'=>'添加成功'
            ]);
        }
    }

    static function editWithId(){
        $id = Params::idParams();
        if (Params::postCheck()) {
            self::$curd->refreshData($id, Params::dataParams());
            throw new SuccessNotify([
                'msg'=>'编辑成功'
            ]);
        }
    }

    static function delWithId(){
        self::$curd->realDel(Params::idParams());
        throw new SuccessNotify([
            'msg'=>'删除成功'
        ]);
    }

}