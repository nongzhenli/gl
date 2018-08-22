<?php
/* WechatMenu 微信公众号开发_自定义菜单
 * @Author: big黑钦
 * @Date: 2018-06-05 15:51:56
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-08-22 16:43:49
 */
namespace app\admin\service;
use app\admin\model\WechatMenu as WechatMenuModel;

// extends Wechat
class WechatMenu extends Wechat
{
    // 公众号配置信息
    private static $base_menu_wxconfig;
    // 初始化函数【调用该类时，必须先实例化 (new Class)时，__construct()才被执行 】
    public function __construct()
    {
        $param_post = input('post.');
        if (!empty($param_post['wx_id'])) {
            self::$base_menu_wxconfig = self::get($param_post['wx_id']);
        } else {
            throw new Exception('获取公众号id异常');
        }

    }


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
     * getWxMenuOptions 获取微信自定义菜单配置信息
     */
    public static function getWxMenuCustomOptions()
    {
        return self::$base_menu_wxconfig;
    }
}
