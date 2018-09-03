<?php

namespace app\api\controller\v1;

use think\Controller;
use think\Request;

class Image extends Controller
{
    public function upload() {
        $file=Request::instance()->file('file');
        $info=$file->move('upload');
        if($info&&$info->getPathname()){
            return apiShow(1,'success',$info->getPathname());
        }
        return show(0,'upload is fail');
    }

    public function kindupload(){
        $file=Request::instance()->file('imgFile');
        $info=$file->move('upload');
        if($info === false) {
            return showkind(1,'上传失败');
        }
        return showkind(0,'../../'.$info->getPathname());
    }

}
