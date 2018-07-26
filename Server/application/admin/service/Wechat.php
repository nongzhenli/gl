<?php
/* Wechat 微信公众号开发业务处理
 * @Author: big黑钦
 * @Date: 2018-06-05 15:51:56
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-07-25 15:39:56
 */
namespace app\admin\service;

use app\admin\model\Wechat as WechatModel;
class Wechat extends BaseWechat
{

    /**
     * 获取公众号配置
     * @param   $wx_id   公众号id，非app_id
     */
    public static function get($wx_id)
    {
        if (!$wx_id) {
            throw new Exception('公众号开发信息不能为空！');
        }

        // 获取微信配置信息
        $wechatConfigArr = WechatModel::getWechat($wx_id);
        // 加密
        // $encrypt = self::passport_encrypt($wechatConfigArr['app_secret'], $wechatConfigArr['app_id']);
        // 解密
        $decrypt = self::passport_decrypt($wechatConfigArr['app_secret'], $wechatConfigArr['app_id']);
        // 重构返回数据
        $wechatConfigArr['app_secret'] = $decrypt;
        return $wechatConfigArr;
    }

    public static function set($wx_id){
        if (!$wx_id) {
            throw new Exception('公众号开发信息不能为空！');
        }
        // 先获取公众号微信配置信息
        $config = self::get($wx_id);

        // 配置信息
        $options = array(
            'appid' => $config['app_id'],
            'appsecret' => $config['app_secret'],
            'token' => $config['token'],
            'encodingaeskey' => $config['encodingaeskey'],
        );
        $wxSDKObj = new WechatSdk($options);
        // token检验
        $wxSDKObj->valid();
        // 获取微信服务器返回类型
        $type = $wxSDKObj->getRev()->getRevType();
        // 公众号规则处理
        switch ($type) {
            case WechatSdk::MSGTYPE_TEXT:
                self::handleTextMessage($wxSDKObj, $config['app_id'], $config['app_secret']);
                break;
            case WechatSdk::MSGTYPE_EVENT:
                self::handleEventMessage($wxSDKObj);
                break;
            default:
                return true;
        }
    }

}
