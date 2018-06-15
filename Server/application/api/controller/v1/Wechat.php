<?php
/* Wechat 微信公众号开发
 * @Author: big黑钦
 * @Date: 2018-05-23 09:16:28
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-15 19:31:16
 */
namespace app\api\controller\v1;

use app\api\service\Wechat as WechatService;

class Wechat
{
    // 微信公众号开发
    public function wx()
    {
        $result = new WechatService();
        var_dump($result);
    }

    // // 微信公众号开发
    // public function test()
    // {
    //     $result = (new WechatService())->test();
    //     var_dump($result);
    // }
}
