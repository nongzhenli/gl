<?php
namespace app\admin\model;

use think\Model;

class WechatMenu extends BaseModel
{
    // tp5 [模型]->[数据访问和转换]章节提到，解决模型查询toArray()方法报错
    protected $resultSetType = 'collection'; 

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
     * 更新微信配置项
     * @param wx_id|Number          微信公众号id
     * @param options|Array         更新配置项
     */
    public static function updataWxMenuOptionItem($options)
    {
        // var_dump($options['value']);
        if($options['key'] == "jsonstr"){
            $options['value'] = json_encode($options['value'], JSON_UNESCAPED_UNICODE);
        }
        $data[$options['key']] = $options['value'];
        $data['last_time'] = time();
        $result = new WechatMenu();
        $result ->save($data, [
            'id' => $options['id']
        ]);
        return $result;
    }

    /**
     * 获取微信公众号菜单所有配置项
     * @param wx_id|Number      微信id
     */
    public static function getWxMenuOptionAll($wx_id)
    {
        $parent_menu = WechatMenu::where("wechat_id=$wx_id AND type=0")
            ->field('id, name, type, jsonstr AS send_message, sort, last_time, create_time')
            ->select()
            ->toArray();
        foreach ($parent_menu as $key => $value) {
            $parent_menu[$key]['send_message'] = json_decode($value['send_message'], true);
            $parent_menu[$key]['sub_button_list'] = [];
        }
        return $parent_menu;
        // return "未做查询";
    }

    /**
     * 获取微信公众号菜单所有配置项
     * @param   wx_id|Number        微信公众号id
     * @param   msg_type|String     获取微信素材类型
     */
    public static function getWxMenuSendMsgContext($wx_id, $msg_type)
    {
    }
}
