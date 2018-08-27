<?php
/* WechatMenu 微信公众号开发_自定义菜单
 * @Author: big黑钦
 * @Date: 2018-06-05 15:51:56
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-08-27 16:19:59
 */
namespace app\admin\service;
use app\admin\model\WechatMenu as WechatMenuModel;
use WechatSdk\Wechat as WechatSdk;

// extends Wechat
class WechatMenu extends Wechat
{
    // 公众号配置信息
    // private static $base_menu_wxconfig;
    // // 初始化函数【调用该类时，必须先实例化 (new Class)时，__construct()才被执行 】
    // public function __construct($wx_id)
    // {
    //     $param_post = input('post.');
    //     if (!empty($param_post['wx_id'])) {
    //         self::$base_menu_wxconfig = self::get($param_post['wx_id']);
    //     } else {
    //         throw new Exception('获取公众号id异常');
    //     }
    // }

    /**
     * wxCreateMenuCustom 创建微信自定义菜单
     * @param options|Array  菜单配置数组
     */
    public static function wxCreateMenuCustom($wx_id, $type, $options)
    {
        $wxMenuOptionItemIsEmpty = WechatMenuModel::isEmptyWxMenuOptionItem($wx_id, $type, $options['sort']);
        if(!$wxMenuOptionItemIsEmpty){
            $insertResult = WechatMenuModel::insertWxMenuOptionItem($wx_id, $options);
            return $insertResult;
        }else {
            // $insertResult = WechatMenuModel::insertWxMenuOptionItem($wx_id, $options);
            return $wxMenuOptionItemIsEmpty;
        }
    }


    /**
     * getForeverSendMsgList 获取永久素材列表(认证后的订阅号可用)
     * @param   wx_id|Number    公众号id
     * @param   type|String     图片（image）、视频（video）、语音 （voice）、图文（news）
     * @param   offset|Number   开始位置0
     * @param   count|String    返回数量
     */
    public static function getForeverSendMsgList($wx_id, $type, $offset = 0, $count = 4)
    {
        // 初始化微信公众号开发配置
        $config = self::get($wx_id);
        // 配置信息
        $options = array(
            'appid' => $config['app_id'],
            'appsecret' => $config['app_secret'],
            'token' => $config['token'],
            'encodingaeskey' => $config['encodingaeskey'],
        );
        $weObj = new WechatSdk($options);
        $result = $weObj->getForeverList($type, $offset, $count);
        return $result;
    }

    // getForeverMedia($media_id,$is_video=false) 获取永久素材
    public static function getForeverByMedia($sdk, $media_id, $is_video){
        $result = $sdk->getForeverByMedia($media_id, $is_video);
        return $result;
    }
}
