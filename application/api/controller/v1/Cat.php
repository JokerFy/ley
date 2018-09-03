<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 17/8/5
 * Time: 下午4:37
 */
namespace app\api\controller\v1;

use app\api\controller\BaseController;

class Cat extends BaseController {

    /**
     * 栏目接口
     */
    public function read() {
        $cats = config('cat.lists');

        $result[] = [
            'catid' => 0,
            'catname' => '首页',
        ];

        foreach($cats as $catid => $catname) {
            $result[] = [
                'catid' => $catid,
                'catname' => $catname,
            ];
        }

        return apiShow(config('code.success'), 'OK', $result, 200);
    }

}