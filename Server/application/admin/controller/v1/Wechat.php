<?php
namespace app\admin\controller\v1;

use app\admin\model\Wechat as WechatModel;
use app\admin\model\WechatMenu as WechatMenuModel;
use app\admin\service\Wechat as WechatService;
use app\admin\service\WechatMenu as WechatMenuService;
use think\Exception;

class Wechat
{
    // 获取营销活动列表
    public function getList()
    {
        $result = WechatModel::getList();
        $data = array(
            "code" => 20000,
            "data" => array(
                "items" => $result,
            ),
        );
        return $data;
    }

    // 获取公众号详情信息
    public function getDetail($id)
    {
        $result = WechatModel::getDetail($id);
        $data = array(
            "code" => 20000,
            "data" => array(
                "options" => $result,
            ),
        );
        return $data;
    }

    // 获取关键回复规则
    public function getSmartRule($wx_id = 0)
    {
        if (!$wx_id) {
            throw new Exception('公众号不存在！');
        }
        $result = WechatModel::getWechatSmartRule($wx_id);
        $data = array(
            "code" => 20000,
            "data" => array($result),
        );
        return $data;
    }

    // 获取公众号配置信息
    public function getConfig($wx_id = 0)
    {
        if (!$wx_id) {
            throw new Exception('公众号不存在！');
        }
        $result = (new WechatService())->get($wx_id);
        if (!$result) {
            throw new Exception('公众号配置信息不存在！');
        }
        return $result;
    }

    // 公众号配置【自定义菜单、自动回复、关注回复、模板消息等】
    public function setConfig($wx_id = 0)
    {
        if (!$wx_id) {
            throw new Exception('公众号不存在！');
        }
        $result = (new WechatService())->set($wx_id);
        if (!$result) {
            throw new Exception('公众号配置信息不存在！');
        }
        return $result;
    }

    // 公众号配置【自定义菜单、自动回复、关注回复、模板消息等】
    public function createMenu($wx_id = 0)
    {
        if (!$wx_id) {
            throw new Exception('公众号不存在！');
        }
        $result = (new WechatService())->createMenu($wx_id);
        if (!$result) {
            throw new Exception('公众号配置信息不存在！');
        }
        return $result;
    }

    /**
     * 创建自定义菜单
     * @param   wx_id|Number
     * @param   options|String  前端传递菜单JSON配置数据
     * @author  bigheiqin
     */
    public function createMenuCustomItem($wx_id = 0, $type, $options)
    {
        if (empty($wx_id)) {
            throw new Exception('公众号不存在！');
        }
        // 转数组
        $options = json_decode($options, true);
        $result = (new WechatMenuService())->wxCreateMenuCustom($wx_id, $type, $options);
        $data = array(
            "code" => 20000,
            "data" => $result,
        );
        return $data;
    }

    /**
     * 更新自定义菜单
     * @param   wx_id|Number    公众号Id
     * @param   options|Number  菜单类型 0,1
     * @param   options|Number  排序sort
     * @param   options|String  菜单配置项JSON
     */
    public function updataMenuCustomItem($wx_id, $options)
    {
        if (empty($wx_id)) {
            throw new Exception('公众号不存在！');
        }
        // 转数组
        $options = json_decode($options, true);
        $result = WechatMenuModel::updataWxMenuOptionItem($options);
        $data = array(
            "code" => 20000,
            "data" => $result,
        );
        return $data;
    }

    /**
     * 获取全部自定义菜单
     * @param   wx_id|Number
     * @author  bigheiqin
     */
    public function getMenuCustomAll($wx_id)
    {
        if (empty($wx_id)) {
            throw new Exception('公众号不存在！');
        }
        // 转数组
        $result = WechatMenuModel::getWxMenuOptionAll($wx_id);
        $data = array(
            "code" => 20000,
            "data" => $result,
        );
        return $data;
    }
}
