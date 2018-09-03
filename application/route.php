<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;


//Image
Route::post('api/:version/image/toupload', 'api/:version.Image/upload');
Route::post('api/:version/image/kindupload', 'api/:version.Image/kindupload');

Route::get('api/:version/cat','api/:version.Cat/read');

//app首页接口
Route::post('api/:version/index','api/:version.Index/index');

//app升级接口
Route::post('api/:version/init', 'api/:version.index/init');

//app注册接口
Route::post('api/:version/register', 'api/:version.Register/phone');

//app登录接口
Route::post('api/:version/token/app', 'api/:version.Token/getAppToken');


//app测试用接口
Route::get('api/:version/test', 'api/:version.test/test');
Route::post('api/:version/tour', 'api/:version.test/ttt');