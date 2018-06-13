<?php
/* Wxcaht 微信公众号开发业务处理
 * @Author: big黑钦
 * @Date: 2018-06-05 15:51:56
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-11 16:53:42
 */
namespace app\api\service;

use Firebase\JWT;
// 引入WechatSdk库
use WechatSdk\Wechat as WechatSdk;

class Wechat
{
    // 初始化函数
    public function __construct()
    {
        // 配置信息
        $options = array(
            'token' => 'nzhllt0323421', //填写你设定的key
            // 'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
            'appid' => 'wx0032b65859a2fe53', //填写高级调用功能的app id
            'appsecret' => '952fa7f0b7e740c0bb458562fdeee27f', //填写高级调用功能的密钥
        );
        $weObj = new WechatSdk($options);
        
        // token检验
        $weObj->valid();

        // 获取微信服务器返回类型
        $type = $weObj->getRev()->getRevType();

        switch ($type) {
            // case WechatSdk::MSGTYPE_TEXT:
            //     $weObj->text("hello, I'm wechat")->reply();
            //     exit;
            //     break;
            case WechatSdk::MSGTYPE_EVENT:

                $event = $weObj->getRev()->getRevEvent();
                $weObj->text($event['event'])->reply();
                break;
            case WechatSdk::MSGTYPE_IMAGE:
                break;
            default:
                $weObj->text("help info")->reply();
        }
    }

}
