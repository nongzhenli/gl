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


// 获取banner参数
Route::get('api/v1/banner/:id', 'api/v1.Banner/getBanner');

// 获取
Route::post('api/v1/user/:type', 'api/v1.User/login');
