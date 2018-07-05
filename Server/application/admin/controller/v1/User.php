<?php
namespace app\admin\controller\v1;

class User
{
    // 用户登录
    public function login()
    {
        $data = array(
            "code" => 20000,
            "data" => array(
                "token" => "admin",
            ),
        );
        return $data;
    }

    // 用户登出
    public function logout()
    {
        $data = array(
            "code" => 20000,
            "data" => "success",
        );
        return $data;
    }

    // 获取用户信息
    public function info()
    {
        $data = array(
            "code" => 20000,
            "data" => array(
                "roles" => array("admin"),
                "name" => "admin",
                "avatar" => "https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif",
            ),
        );
        return $data;
    }

}
