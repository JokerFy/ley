<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/6
 * Time: 9:44
 */

namespace app\admin\controller\cms;

use app\admin\controller\Base;
use app\common\model\Common;
use app\lib\exception\ParameterException;
use app\lib\exception\SuccessNotify;
use app\admin\model\Menu as Menu;
use app\common\Params;
use think\Request;
use think\Db;

class Content extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $config = [
            'table' => 'news',
            'autoWriteTimestamp' => true
        ];
        Common::init($config);
    }

    public function index()
    {
        //推荐位选择列表
        $positions = Db::name('position')
            ->select();

        //文章列表
        $articleList = Db::table('cms_news')->where(['status' => 1])
            ->order('listorder desc,id desc')
            ->paginate(10);

        $pages = $articleList->render();
        return $this->fetch('', ['list' => $articleList, 'position' => $positions, 'pages' => $pages]);
    }

    public function add()
    {
        $webSiteMenu = Menu::getBarMenus();
        Common::addWithPost();
        return $this->fetch('', ['webSiteMenu' => $webSiteMenu]);
    }

    public function edit()
    {
        $id = Params::idParams();
        Common::editWithId();
        $webSiteMenu = Menu::getBarMenus();
        $result = Db::table('cms_news')->where('id', $id)->find();
        return $this->fetch('', ['news' => $result, 'webSiteMenu' => $webSiteMenu]);

    }

    public function push()
    {
        $data = Params::dataParams();
        $positonId = intval($data['position_id']);
        $newsId = $data['push'];

        if(!$newsId||!$positonId){
            throw new ParameterException([
                'msg'=>'推荐位或者推送文章不能为空'
            ]);
        }

        $commonModel = new Common();
        $news = $commonModel->getNewsByNewsIdIn('news', $newsId);

        foreach ($news as $new) {
            $data = array(
                'position_id' => $positonId,
                'title' => $new['title'],
                'thumb' => $new['thumb'],
                'news_id' => $new['id'],
                'status' => 1,
                'create_time' => $new['create_time'],
            );
            $this->curd->add($data);
        }

        throw new SuccessNotify([
            'msg' => '推送成功'
        ]);

    }


    public function delete()
    {
        Common::delWithId();
    }
}