<?php
namespace app\admin\model;

use think\Model;

class WechatMenu extends BaseModel
{
    /**
     * 判断该是自定义菜单配置项是否存在
     * @param wx_id|Number  微信id
     * @param type|Number   配置项类型 0父菜单，1子菜单
     * @param sort|Number   配置项排序
     */
    public static function isEmptyWxMenuOptionItem($wx_id, $type, $sort)
    {
        $result = self::where([
            "wechat_id" => $wx_id,
            "type" => $type,
            "sort" => $sort,
        ])->find();
        return $result;
    }

    /**
     * 插入微信配置项
     * @param wx_id|Number      微信id
     * @param options|Array    配置项类型 0父菜单，1子菜单
     */
    public static function insertWxMenuOptionItem($wx_id, $options)
    {
        $result = self::create([
            'wechat_id' => $wx_id,
            'name' => $options['name'],
            'type' => $options['type'],
            'sort' => $options['sort'],
            'jsonstr' => json_encode($options['send_message'], JSON_UNESCAPED_UNICODE),
            'create_time' => time(),
        ]);
        return $result;
    }


    /**
     * 获取微信配置项
     * @param wx_id|Number      微信id
     */
    public static function getWxMenuOptionAll($wx_id)
    {
        // self::where()
        return "未做查询";
    }
}
