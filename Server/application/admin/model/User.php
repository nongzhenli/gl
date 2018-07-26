<?php
namespace app\admin\model;

use think\Model;

// public 表示全局，类内部外部子类都可以访问；
// private 表示私有的，只有本类内部可以使用；
// protected 表示受保护的，只有本类或子类或父类中可以访问；

class User extends BaseModel
{
    /**
     * 用户是否存在__通过 openid
     * 存在返回uid，不存在返回0
     */
    public static function getByOpenID($openid)
    {
        $user = User::where('openid', '=', $openid)
            ->find();
        return $user;
    }

    /**
     * 用户是否存在__通过 uid
     * 存在返回uid，不存在返回0
     */
    public static function getByUserID($uid)
    {
        $user = User::where('id', '=', $uid)->find();
        return $user;
    }
}
