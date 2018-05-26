<?php
/*
 * @Author: big黑钦
 * @Date: 2018-05-22 11:17:31
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-05-26 15:06:35
 */
namespace app\api\controller\v1;

use app\api\service\UserToken;
use app\api\validate\TokenGet;
use app\api\service\Token as TokenService;

class Token
{
    /**
     * 用户获取令牌（登陆）
     * @url /token
     * @POST code
     * @note 虽然查询应该使用get，但为了稍微增强安全性，所以使用POST
     */
    public function getToken($code = '')
    {
        (new TokenGet())->goCheck();
        $wx = new UserToken($code);
        $token = $wx->get();
        return [
            'token' => $token,
        ];
    }

    // 验证Token令牌
    public function verifyToken($token='')
    {
        if(!$token){
            throw new ParameterException([
                'token不允许为空'
            ]);
        }
        $valid = TokenService::verifyToken($token);
        return [
            'isValid' => $valid
        ];
    }
}
