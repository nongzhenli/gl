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

// Token
Route::rule('api/:version/token/user', 'api/:version.Token/getToken', 'GET|POST');
Route::post('api/:version/token/verify', 'api/:version.Token/verifyToken');

// Lottery
Route::get('api/:version/lottery/prize/info', 'api/:version.Lottery/getAllPrizeInfo');
Route::post('api/:version/lottery/user/sign', 'api/:version.Lottery/sign');
Route::post('api/:version/lottery/user/get', 'api/:version.Lottery/get');
Route::post('api/:version/lottery/user/prize', 'api/:version.Lottery/getPrizeIndex');
Route::get('api/:version/lottery/prize/test', 'api/:version.Lottery/test'); // 模拟抽奖测试

// Wxcaht
Route::rule('api/:version/wechat/wx', 'api/:version.Wechat/wx', 'GET|POST');
Route::rule('api/:version/wechat/verifyUser', 'api/:version.Wechat/verifyUser', 'POST');
Route::rule('api/:version/wechat/updataNameMobile', 'api/:version.Wechat/updataNameMobile', 'POST');
Route::rule('api/:version/wechat/updataUserGood', 'api/:version.Wechat/updataUserGood', 'POST');

Route::rule('api/:version/wechat/test', 'api/:version.Wechat/test', 'GET|POST');    // 测试



/**
 * Admin后台管理 API数据接口
 */
Route::rule('admin/:version/user/login', 'admin/:version.User/login', 'POST');
Route::rule('admin/:version/user/logout', 'admin/:version.User/logout', 'POST');
Route::rule('admin/:version/user/info', 'admin/:version.User/info', 'GET');
Route::rule('admin/:version/marketing/list', 'admin/:version.Marketing/getList', 'GET');
// -抽奖活动
Route::rule('admin/:version/marketing/get/lottery', 'admin/:version.Marketing/getLotteryById', 'GET'); // 抽奖类活动详情
// -吸粉活动
Route::rule('admin/:version/marketing/get/fans', 'admin/:version.Marketing/getFansById', 'GET');    // 公众号吸粉类活动详情
Route::rule('admin/:version/marketing/fans/export-exce', 'admin/:version.Marketing/fansDataExcel', 'GET');


// -公众号
Route::rule('admin/:version/wechat/list', 'admin/:version.Wechat/getList', 'GET');
Route::rule('admin/:version/wechat/detail', 'admin/:version.Wechat/getDetail', 'GET');
Route::rule('admin/:version/wechat/getconf/:wx_id', 'admin/:version.Wechat/getConfig', 'GET');
Route::rule('admin/:version/wechat/setconf/:wx_id', 'admin/:version.Wechat/setConfig', 'GET|POST');
// --关键字回复
Route::rule('admin/:version/wechat/getsmartrule', 'admin/:version.Wechat/getSmartRule', 'GET');  // 关键字回复规则
Route::rule('admin/:version/wechat/createmenu', 'admin/:version.Wechat/createMenu', 'POST'); // 自定义菜单
// --自定义菜单
Route::rule('admin/:version/wechat/menu/create', 'admin/:version.Wechat/createMenuCustomItem', 'POST'); // 创建自定义菜单
Route::rule('admin/:version/wechat/menu/get', 'admin/:version.Wechat/getMenuCustomAll', 'GET'); // 获取菜单
Route::rule('admin/:version/wechat/menu/updata', 'admin/:version.Wechat/updataMenuCustomItem', 'POST'); // 更新菜单
Route::rule('admin/:version/wechat/menu/sendmsg', 'admin/:version.Wechat/getWxMenuSendMsgContext', 'GET'); // 获取微信菜单【发送消息】素材内容
// --素材管理 【WxMedia】
Route::rule('admin/:version/wxmedia/getList', 'admin/:version.WxMedia/getMediaForeverList', 'GET');    // 获取永久素材列表
Route::rule('admin/:version/wxmedia/get', 'admin/:version.WxMedia/getForeverByMedia', 'POST');        // 获取永久素材


/**
 * 微信公众号接入开发配置口 【待更新替换】
 */
Route::rule('api/:version/get/:wechat_id', 'api/:version.Config/get', 'GET|POST');
Route::rule('api/:version/set/:wechat_id', 'api/:version.Config/set', 'GET|POST');
Route::rule('api/:version/menu/create', 'api/:version.Config/createMenu', 'POST');

