<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 17/8/5
 * Time: 下午4:37
 */
namespace app\api\controller\v1;
use app\api\controller\BaseController;
use app\api\model\News;
use app\api\model\AppActive;
use app\api\model\Version;
use app\lib\exception\ParameterException;

class Index extends BaseController {

    /**
     * 获取首页接口
     * 1、头图  4-6
     * 2、推荐位列表 默认40条
     */
    public function index() {

        $News = new News();
        $heads =  $News->getIndexHeadNormalNews();
        $heads = $this->getDealNews($heads);

        $positions = $News->getPositionNormalNews();
        $positions = $this->getDealNews($positions);

        $result = [
            'heads' => $heads,
            'positions' => $positions,
        ];


        return apiShow(config('code.success'), 'OK', $result, 200);
    }


    /**
     * 客户端初始化接口
     * 1、检测APP是否需要升级
     */
    public function init() {
        // app_type 去ent_version 查询
        $ver = new version();

        $version = $ver->getLastNormalVersionByAppType($this->headers['app_type']);

        if(empty($version)) {
            throw new ParameterException([
                'code'=>'404',
                'msg'=>'error'
            ]);
        }

        if($version->version > $this->headers['version']) {
            $version->is_update = $version->is_force == 1 ? 2 : 1;
        }else {
            $version->is_update = 0;  // 0 不更新 ， 1需要更新, 2强制更新
        }

        // 记录用户的基本信息 用于统计
        $actives = [
            'version' => $this->headers['version'],
            'app_type' => $this->headers['app_type'],
            'did' => $this->headers['did'],
        ];
        try {
            (new AppActive())->add($actives);
        }catch (\Exception $e) {
            // todo
            //Log::write();
        }

        return apiShow(config('code.success'), 'OK', $version, 200);
    }

}