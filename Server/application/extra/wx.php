<?php
/*
 * @Author: big黑钦
 * @Date: 2018-05-22 12:50:26
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-05-22 17:45:44
 */

return [
    //  +---------------------------------
    //  微信相关配置
    //  +---------------------------------

    // 公众号app_id
    'app_id' => 'your AppID',
    // 公众号app_secret
    'app_secret' => 'you AppSecret',
    // 验证code码【微信获取code回调地址】
    'verifyCode' => "api/v1/verifyCode",

    // 1、微信获取code授权地址
    'wx_code_url' => "https://open.weixin.qq.com/connect/oauth2/authorize?" .
    "appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_userinfo&state=%s#wechat_redirect",
    // 2、依据code码去获取openid和access_token，自己的后台服务器直接向微信服务器申请即可
    'access_token_url' => "https://api.weixin.qq.com/sns/oauth2/access_token?" .
    "appid=%s&secret=%s&code=%s&grant_type=authorization_code",
    // 3、依据申请到的access_token和openid，申请Userinfo信息。
    'wx_userinfo_url' => "https://api.weixin.qq.com/sns/userinfo?" .
    "access_token=%s&openid=%s&lang=zh_CN",

];
