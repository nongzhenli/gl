<?php
namespace app\admin\controller\v1;

use app\admin\model\Wechat as WechatModel;
use app\admin\service\Wechat as WechatService;
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
                "items" => $result,
            ),
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
        if(!$result){
            throw new Exception('公众号配置信息不存在！');
        }
        return $result;
    }


    // 公众号配置【自定义菜单、自动回复、关注回复、模板消息等】
    public function setConfig($wx_id = 0) {
        
    }
}
