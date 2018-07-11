<?php
namespace app\admin\controller\v1;

use app\admin\model\Wechat as WechatModel;

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
    
}
