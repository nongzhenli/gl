<?php
namespace app\api\controller\wechat;

use app\api\controller\wechat\BaseWechat;
use app\api\model\Wechat as WechatModel;
use think\Exception;
use WechatSdk\Wechat as WechatSdk;

class Config extends BaseWechat
{
    protected static $wx_id;
    /**
     * 获取公众号配置
     * @param   $wechat_id   公众号id，非app_id
     */
    public static function get($wechat_id = 0)
    {
        if (!$wechat_id) {
            throw new Exception('公众号开发信息不能为空！');
        }
        self::$wx_id = $wechat_id;

        // 获取微信配置信息
        $wechatConfigArr = WechatModel::getWechat($wechat_id);
        // 加密
        // $encrypt = self::passport_encrypt($wechatConfigArr['app_secret'], $wechatConfigArr['app_id']);
        // 解密
        $decrypt = self::passport_decrypt($wechatConfigArr['app_secret'], $wechatConfigArr['app_id']);
        // 重构返回数据
        $wechatConfigArr['app_secret'] = $decrypt;
        return $wechatConfigArr;
    }

    /**
     * 公众号设置
     * @param   $wechat_id   公众号id，非app_id
     */
    public static function set($wechat_id = 0)
    {
        if (!$wechat_id) {
            throw new Exception('公众号开发信息不能为空！');
        }
        // 先获取公众号微信配置信息
        $config = self::get($wechat_id);
        // 配置信息
        $options = array(
            'appid' => $config['app_id'],
            'appsecret' => $config['app_secret'],
            'token' => $config['token'],
            'encodingaeskey' => $config['encodingaeskey'],
        );
        $weObj = new WechatSdk($options);
        // token检验
        $weObj->valid();
        // 获取微信服务器返回类型
        $type = $weObj->getRev()->getRevType();
        // 公众号规则处理
        switch ($type) {
            case WechatSdk::MSGTYPE_TEXT:
                self::handleTextMessage($weObj, $config['app_id'], $config['app_secret']);
                break;
            case WechatSdk::MSGTYPE_EVENT:
                self::handleEventMessage($weObj);
                break;
            default:
                return true;
        }
    }

    // 文本回复处理集中方法
    public static function handleTextMessage($weObj, $app_id, $app_secret)
    {
        // $str = $weObj->checkAuth($app_id, $app_secret);
        // $weObj->text($str)->reply();
    }

    // 事件处理集中方法
    public static function handleEventMessage($weObj)
    {
        $getRevEvent = $weObj->getRev()->getRevEvent();
        $event = $getRevEvent['event'];
        // 获取用户openid
        $openid = $weObj->getRev()->getRevFrom();

        // 普通关注事件、未关注扫描带参数二维码事件
        if ($event == "subscribe" || $event == "SCAN") {
            if(self::$wx_id == 1){
                $weObj->text("够品质/够实力/够美好!\n在线打卡签到，点击链接：<a href='https://jinshuju.net/f/bXyUsD'>https://jinshuju.net/f/bXyUsD</a>")->reply();
            }elseif(self::$wx_id == 3) {
                $weObj->text("与你共度趣味亲子时光！\n够品质 / 够实力 / 够美好！!\n在线打卡签到，点击链接：<a href='https://jinshuju.net/f/bXyUsD'>https://jinshuju.net/f/bXyUsD</a>")->reply();
            }
        }
    }

    /**
     * 自定义菜单
     * #只需要调用一次，应该单独作为事件调用
     */
    public static function createMenu($wechat_id = 0)
    {
        if (!$wechat_id) {
            throw new Exception('公众号开发信息不能为空！');
        }
        // 先获取公众号微信配置信息
        $config = self::get($wechat_id);
        // 配置信息
        $options = array(
            'appid' => $config['app_id'],
            'appsecret' => $config['app_secret'],
            'token' => $config['token'],
            'encodingaeskey' => $config['encodingaeskey'],
        );

        $weObj = new WechatSdk($options);

        if(self::$wx_id == 3){
            $url = "https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzUyNzQ5NTUwMQ==&scene=126#wechat_redirect";
        }elseif (self::$wx_id == 1) {
            $url = "https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzI1MjUxMjUzMw==&scene=126#wechat_redirect";
        }

        // 创建自定义菜单
        $data = array(
            "button" => array(
                0 => array(
                    "type" => "view",
                    "name" => "往期活动回看",
                    "url" => $url
                ),
            ),
        );
        $result = $weObj->createMenu($data);
        return $result;
    }
}
