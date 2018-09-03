<?php
/**
 * Created by PhpStorm.
 * User: finley
 * Date: 2018/6/9
 * Time: 13:58
 */

namespace app\admin\controller\auth;

use app\admin\controller\Base;
use app\admin\model\AuthModel;
use app\common\Params;
use app\lib\exception\SuccessNotify;
use think\Db;
use app\admin\model\Curd;

class Rules extends Base
{
    protected $authModel;
    protected $Curd;
    public function _initialize()
    {
        parent::_initialize();
        $this->authModel = new AuthModel();
        $this->Curd = new Curd(array('table'=>'auth_rule'));
    }
    public function index()
    {
        $tree = $this->authModel->ruleTree();
        $treeList = setPrefix($tree);
        return $this->fetch('', ['field' => $treeList]);
    }

    public function add(){
        $tree = $this->authModel->ruleTree();
        $treeList = setPrefix($tree);
        $data = Params::postCheck();
        if($data){     //TODO 判断是否更新操作
            $this->Curd->add($data);
            throw new SuccessNotify();
        }
        return $this->fetch('', ['field' => $treeList]);
    }

    public function edit()
    {
        if (Params::idParams()) {
            $result = Db::name('auth_rule')->find(Params::idParams());
            $tree = $this->authModel->ruleTree();
            $treeList = setPrefix($tree);

            $data = Params::postCheck();
            if($data&&isset($data['id'])){     //TODO 判断是否更新操作
                $this->Curd->refreshData($data['id'],$data);
                throw new SuccessNotify([
                    'msg'=>'更新成功'
                ]);
            }
            return $this->fetch('', ['selectlist' => $treeList,'rule'=>$result]);
        }
    }


    public function delete(){
        $data = request()->post();
        $this->Curd->realDel($data['id']);
        throw new SuccessNotify([
            'msg'=>'删除成功'
        ]);
    }


}