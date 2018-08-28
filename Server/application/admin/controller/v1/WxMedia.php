<?php
namespace app\admin\controller\v1;

use app\admin\model\Wechat as WechatModel;
use app\admin\model\WechatMenu as WechatMenuModel;
use app\admin\service\Wechat as WechatService;
use app\admin\service\WechatMedia as WechatMediaService;
use think\Exception;

class WxMedia
{
    /**
     * 获取永久素材列表(认证后的订阅号可用)
     * @param   wx_id|Number        公众号id
     * @param   msg_type|String     获取素材类型
     * @param   offset|String       开始位置
     * @param   count|String        获取数据总量，最大20
     */
    public function getMediaForeverList($wx_id, $msg_type, $offset = 0, $count = 20)
    {
        if (empty($wx_id)) {
            throw new Exception('公众号不存在！');
        }
        // 转数组
        $result = (new WechatMediaService($wx_id))->getMediaForeverList($msg_type, $offset, $count);
        $data = array(
            "code" => 20000,
            "data" => $result,
        );
        return $data;
    }

    /**
     * 获取公众号永久素材
     * @param   wx_id|Number        微信公众号id
     * @param   msg_type|String     获取微信素材类型
     * @author  bigheiqin
     */
    public function getForeverByMedia($wx_id, $media_id, $is_video = false)
    {
        if (empty($wx_id)) {
            throw new Exception('公众号不存在！');
        }
        $result = (new WechatMediaService($wx_id))->getForeverByMedia($media_id, $is_video);
        $data = array(
            "code" => 20000,
            "data" => $result,
        );
        return $data;
    }

}
