<?php
namespace app\api\model;

use Firebase\JWT;
use think\Model;
use think\Exception;
use app\api\service\Token;
// use app\api\model\BaseModel;


// public 表示全局，类内部外部子类都可以访问；
// private 表示私有的，只有本类内部可以使用；
// protected 表示受保护的，只有本类或子类或父类中可以访问；

class User extends BaseModel
{

    /**
     * 获取用户信息
     * 存在返回uid，不存在返回0
     */
    public static function getUserInfo()
    {
        // 从缓存获取uid
        $uid = Token::getCurrentUid();
        $user = User::where('id', '=', $uid)
            ->find();
        return $user;
    }

    /**
     * 用户是否存在
     * 存在返回uid，不存在返回0
     */
    public static function getByOpenID($openid)
    {
        $user = User::where('openid', '=', $openid)
            ->find();
        return $user;
    }

    // 用户登录验证模块
    public static function getToken()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            define('KEY', '1gHuiop975cdashyex9Ud23ldsvm2Xq'); //密钥
            $nowtime = time();
            $token = [
                'iss' => 'http://www.glagbn.com/', //签发者
                'aud' => 'http://www.glagbn.com/', //jwt所面向的用户
                'iat' => $nowtime, //签发时间
                'nbf' => $nowtime + 10, //在什么时间之后该jwt才可用
                'exp' => $nowtime + 600, //过期时间-10min
                'data' => [ // 请勿防止敏感信息
                    'userid' => 1,
                ],
            ];

            $access_token = $token;
            $access_token['scopes'] = 'role_access'; //token标识，请求接口的token
            $access_token['exp'] = $nowtime + 7200; //access_token过期时间,这里设置2个小时

            $refresh_token = $token;
            $refresh_token['scopes'] = 'role_refresh'; //token标识，刷新access_token
            $refresh_token['exp'] = $nowtime + (86400 * 30); //access_token过期时间,这里设置30天

            $jsonList = [
                'access_token' => JWT::encode($access_token, KEY),
                'refresh_token' => JWT::encode($refresh_token, KEY),
                'token_type' => 'bearer', //token_type：表示令牌类型，该值大小写不敏感，这里用bearer
            ];
            Header("HTTP/1.1 201 Created");
            return json_encode($jsonList); //返回给客户端token信息

            // // 闭包法
            // // $result = Db::table('banner_item')
            // //     ->where(function ($query) use ($id) {
            // //         $query->where('banner_id', '=', $id);
            // //     })
            // //     ->select();
        }else {
            throw new Exception('请求错误');
        }

    }
}
