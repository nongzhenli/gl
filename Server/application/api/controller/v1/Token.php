<?php
/*
 * @Author: big黑钦
 * @Date: 2018-05-22 11:17:31
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-05-27 20:48:24
 */
namespace app\api\controller\v1;

use app\api\service\UserToken;
use app\api\validate\TokenGet;
use app\lib\exception\ParameterException;
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
        $wx = new UserToken();
        $token = $wx->get($code);
        
        $result_ar = array(
            'token' => $token, 
        );

        var_dump($result_ar);
        exit();
        return json_decode($result_ar, true);
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
