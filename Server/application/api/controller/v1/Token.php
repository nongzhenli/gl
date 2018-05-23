<?php
namespace app\api\controller\v1;

use app\api\service\UserToken;
use app\api\validate\TokenGet;

/*
 * @Author: big黑钦
 * @Date: 2018-05-22 11:17:31
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-05-23 11:34:45
 */
class Token
{
    /**
     * 用户获取令牌（登陆）
     * @url /token
     * @POST code
     * @note 虽然查询应该使用get，但为了稍微增强安全性，所以使用POST
     */
    public function getToken($code='')
    {
        (new TokenGet())->goCheck();

        var_dump($code);

        exit();

        $wx = new UserToken($code);
        $token = $wx->get();
        return [
            'token' => $token
        ];
    }
}