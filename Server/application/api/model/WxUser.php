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

class WxUser extends BaseModel
{

    /**
     * 拉取用户微信信息
     * 存在返回uid，不存在返回0
     */
    public static function getWxUserInfo($access_token, $openid)
    {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $result= curl_get($url);
        return $result;
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

}
