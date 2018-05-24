<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');

// 定义log日志目录
define('LOG_PATH', __DIR__ . '/../log/');

// 定义第三方类库引入目标路径
define('EXTEND_PATH', __DIR__ . '/../extend/');

// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';


// 全局定义开启sql语句记录日志
\think\Log::init([
    'type' => 'File',
    'path' => LOG_PATH,
    'level' => ['sql'],
]);