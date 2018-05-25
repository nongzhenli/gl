<?php
/*
 * @Author: big黑钦
 * @Date: 2018-05-23 09:16:28
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-05-23 11:54:22
 */
namespace app\api\controller\v1;

use think\Controller;
use app\api\model\User as UserModel;
use app\api\validate\TokenGet;
use think\Request;

class User extends Controller
{
    public function login()
    {
        // /**
        //  * 获取指定的banner信息
        //  * @url   /banner/:id
        //  * @http  GET
        //  * @id    banner的id号
        //  */

        // // 自定义验证规则，校验如果返回false，则此处被拦截，之后的代码都不被执行
        // (new IDMustBePostiveINT())->goCheck();
        // /**
        //  * 模型：（查询结果返回一个对象，而不是一个数组）
        //  * 1.默认{模型名}对照{数据库表名}进行了操作
        //  * 2.关联模型
        //  */
        // $banner = BannerModel::getBannerByID($id);
        // // $banner = BannerModel::get($id);
        // if(!$banner){
        //     throw new BannerMissException();
        //     // throw new Exception ('内部错误');
        // }
        // return json($banner);

        $token = UserModel::getToken();
        var_dump($token);

        $uname = input('post.uname');
        $upassword = input('post.upassword');

        var_dump($uname, $upassword);
    }

    // 获取code
    public function wxCode()
    {
        // $request = Request::instance();
        // $redirect_uri = $request->path();
        // var_dump($request->module(), $request->controller(), $request->action());
        // exit();

        $this->wxAppID = config('wx.app_id');
        $this->wxRedirectUri = urlencode("http://gl.gxqqbaby.cn/api/v1/user/wxuinfo");
        $this->wxState = 'test';
        $this->wxCodeUrl = sprintf(config('wx.wx_code_url'), $this->wxAppID, $this->wxRedirectUri, $this->wxState);

        // 获取code码，用于和微信服务器申请token。 注：依据OAuth2.0要求，此处授权登录需要用户端操作
        // header('location:'.$this->wxCodeUrl);
        // exit;   // tp5此处跳转要执行exit退出
        $this->redirect($this->wxCodeUrl, 302);
    }

    // 获取微信用户信息
    public function wxUInfo($code = '')
    {   
        // 验证code参数
        $validatCode = (new TokenGet())->goCheck();
        if(!$validatCode){
<<<<<<< HEAD
            $this->redirect($this->wxCodeUrl, 302);
            exit();
=======
            // $this->redirect($this->wxCodeUrl, 302);
            // exit();
>>>>>>> e8bc92c6b4949927f5456c834e468cc9a98f6c9a
        }
        
        var_dump($code);
    }
}
