<?php
/* WechatMedia 微信公众号开发_素材管理
 * @Author: big黑钦
 * @Date: 2018-06-05 15:51:56
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-08-29 14:09:31
 */
namespace app\admin\service;
use WechatSdk\Wechat as WechatSdk;

// extends Wechat
class WechatMedia extends Wechat
{
    /**
     * 初始化函数，生成公共静态变量：
     * @var base_wx_id|Number       公众号id
     * @var base_wx_config|Array    公众号服务器配置信息
     * @var base_wxSDKObj|Object    实例化公众号SDK
     * 
     */
    public function __construct($wx_id)
    {
        if(empty($wx_id)){
            throw new Exception('获取公众号id异常');
        }
        $config = self::get($wx_id);
        // 配置信息
        $options = array(
            'appid' => $config['app_id'],
            'appsecret' => $config['app_secret'],
            'token' => $config['token'],
            'encodingaeskey' => $config['encodingaeskey'],
        );
        self::$base_wxSDKObj = new WechatSdk($options);
    }

    /**
     * getMediaForeverList 获取永久素材列表(认证后的订阅号可用)
     * @param   type|String     图片（image）、视频（video）、语音 （voice）、图文（news）
     * @param   offset|Number   开始位置0
     * @param   count|String    返回数量
     */
    public static function getMediaForeverList($type, $offset, $count)
    {
        // 初始化微信公众号开发配置
        $result = self::$base_wxSDKObj->getForeverList($type, $offset, $count);
        foreach ($result['item'] as $key => $value) {
            $news_item['title'] = $value['content']['news_item'][0]['title'];
            $news_item['thumb_url'] = $value['content']['news_item'][0]['thumb_url'];

            //正则替换图片资源头文件，更改为http://mpt.135editor.com，成功解决微信图片防盗链。（#猜测：可能不是使用135编辑器的素材资源不能正常获取）
            $reg = '/(http):\/\/([^\/]+)/i';
            $new_url_ = "http://mpt.135editor.com";
            $news_item['new_thumb_url'] = preg_replace($reg, $new_url_, $news_item['thumb_url']);

            $result['item'][$key]['content']['news_item'] = $news_item;
            unset($news_item);
        }
        return $result;
    }

    /**
     * getForeverMedia  获取永久素材
     * @param   media_id|Number   素材媒体id
     * @param   is_video|Bool     是否为视频素材，默认false
     */
    public static function getForeverByMedia($media_id, $is_video){
        $strImg = self::$base_wxSDKObj->getForeverMedia($media_id, $is_video);
        // 保存图片
        $imgURl = saveImgFile($strImg, 'jpg', $savePath);
        // return $result;
    }
}
