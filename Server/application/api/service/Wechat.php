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
    protected $options;
    protected $wechatSDK;

    // 初始化函数
    public function __construct()
    {
        // 配置信息
        $this->options = array(
            'token' => 'nzhllt0323421', //填写你设定的key
            // 'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
            'appid' => 'wx0032b65859a2fe53', //填写高级调用功能的app id
            'appsecret' => '952fa7f0b7e740c0bb458562fdeee27f', //填写高级调用功能的密钥
        );
        $this->wechatSDK = new WechatSdk($this->options);
        // token检验
        $this->wechatSDK->valid();
        // 获取微信服务器返回类型
        $type = $this->wechatSDK->getRev()->getRevType();

        switch ($type) {
            case WechatSdk::MSGTYPE_TEXT:
                $this->msgtypeText();
                break;
            case WechatSdk::MSGTYPE_EVENT:
                $event = $this->wechatSDK->getRev()->getRevEvent();
                $this->wechatSDK->text($event['event'])->reply();
                break;
            case WechatSdk::MSGTYPE_IMAGE:
                break;
            default:
                $this->wechatSDK->text("help info")->reply();
        }
    }

    // 文字消息回复控制器
    public function msgtypeText()
    {
        $this->wechatSDK->text("hello, I'm wechat")->reply();
    }
}
