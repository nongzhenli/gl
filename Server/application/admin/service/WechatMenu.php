<?php
/* WechatMenu 微信公众号开发_自定义菜单
 * @Author: big黑钦
 * @Date: 2018-06-05 15:51:56
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-09-05 10:43:43
 */
namespace app\admin\service;
use app\admin\model\WechatMenu as WechatMenuModel;
use WechatSdk\Wechat as WechatSdk;

// extends Wechat
class WechatMenu extends Wechat
{
    private static $base_menu_wxconfig;
    private static $base_menu_wxsdk;
    private static $base_menu_wx_id;
    // 初始化函数【调用该类时，必须先实例化 (new Class)时，__construct()才被执行 】
    public function __construct($wx_id)
    {
        if(empty($wx_id)){
            throw new Exception('获取公众号id异常');
        }
        self::$base_menu_wx_id = $wx_id;
        self::$base_menu_wxconfig = self::get($wx_id);
        // 配置信息
        $options = array(
            'appid' => self::$base_menu_wxconfig['app_id'],
            'appsecret' => self::$base_menu_wxconfig['app_secret'],
            'token' => self::$base_menu_wxconfig['token'],
            'encodingaeskey' => self::$base_menu_wxconfig['encodingaeskey'],
        );
        self::$base_menu_wxsdk = new WechatSdk($options);
    }

    /**
     * wxCreateMenuCustom 创建微信自定义菜单
     * @param options|Array  菜单配置数组
     */
    public static function wxCreateMenuCustom($type, $options)
    {
        $wxMenuOptionItemIsEmpty = WechatMenuModel::isEmptyWxMenuOptionItem(self::$base_menu_wx_id, $type, $options['sort']);
        if(!$wxMenuOptionItemIsEmpty){
            $insertResult = WechatMenuModel::insertWxMenuOptionItem(self::$base_menu_wx_id, $options);
            return $insertResult;
        }else {
            // $insertResult = WechatMenuModel::insertWxMenuOptionItem(self::$base_menu_wx_id, $options);
            return $wxMenuOptionItemIsEmpty;
        }
    }
}
