<?php
/*
 * @Author: big黑钦
 * @Date: 2018-05-22 11:17:31
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-05-30 11:43:17
 */
namespace app\api\controller\v1;
use think\Controller;
use think\Cookie;

use app\api\service\UserToken;
use app\api\validate\TokenGet;
use app\lib\exception\ParameterException;
use app\api\service\Token as TokenService;

class Token extends Controller
{
    /**
     * 用户获取令牌（登陆）
     * @url /token
     * @POST code
     * @note 虽然查询应该使用get，但为了稍微增强安全性，所以使用POST
     */
    public function getToken($code = '', $state= '')
    {
        (new TokenGet())->goCheck();
        $wx = new UserToken($code, $state);
        $token = $wx->get();

        $setCookie = Cookie::set('loginToken', $token, 7200);
        $redirect_uri = Cookie::has('beforeLoginUrl');
        
        $this->redirect('http://gl.gxqqbaby.cn/#'.$redirect_uri, 200);
        exit;
            
        // echo json_encode($result_ar, true);
        // eixt();
        // return $result_ar;
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
