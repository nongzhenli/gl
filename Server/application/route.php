<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 引入类
use think\Route;
// Route::rule('路由表达式', '路由地址', '请求类型|类型2', '路由参数（数组）', '变量规则（数组）');

// Banner
Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');

// Login
Route::post('api/:version/user/login', 'api/:version.User/login');
Route::get('api/:version/user/author', 'api/:version.User/author');
Route::get('api/:version/user/:id', 'api/:version.User/uinfo');


// Token
Route::rule('api/:version/token/user', 'api/:version.Token/getToken', 'GET|POST');
Route::post('api/:version/token/verify', 'api/:version.Token/verifyToken');


// Lottery
Route::rule('api/:version/lottery/user/sign', 'api/:version.Lottery/sign', 'POST');
Route::rule('api/:version/lottery/user/get', 'api/:version.Lottery/get', 'POST');
