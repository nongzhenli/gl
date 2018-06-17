<?php
/* Wechat 微信公众号开发
 * @Author: big黑钦
 * @Date: 2018-05-23 09:16:28
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-16 15:46:47
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

    // 海报图生成
    public function test()
    {
        $config = array(
            'text' => array(
                // 微信昵称
                // array(
                //     'text' => '微信昵称',
                //     'left' => 182,
                //     'top' => 105,
                //     'fontPath' => APP_PATH . 'fonst/simkai.ttf', //字体文件
                //     'fontSize' => 18, //字号
                //     'fontColor' => '255,0,0', //字体颜色
                //     'angle' => 0,
                // ),
            ),
            'image' => array(
                // 二维码
                array(
                    'url' => 'https://qr.api.cli.im/qr?data=http%253A%252F%252Fbaidu.com&level=H&transparent=false&bgcolor=%23ffffff&forecolor=%23000000&blockpixel=12&marginblock=1&logourl=&size=280&kid=cliim&key=d44c420220c50c0a9fbbb91ddb1a769e', //图片资源路径
                    'left' => 135,
                    'top' => -165,
                    'stream' => 0, //图片资源是否是字符串图像流
                    'right' => 0,
                    'bottom' => 0,
                    'width' => 165,
                    'height' => 165,
                    'opacity' => 100,
                ),
                // 微信头像
                // array(
                //     'url' => 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eofD96opK97RXwM179G9IJytIgqXod8jH9icFf6Cia6sJ0fxeILLMLf0dVviaF3SnibxtrFaVO3c8Ria2w/0',
                //     'left' => 120,
                //     'top' => 70,
                //     'right' => 0,
                //     'stream' => 0,
                //     'bottom' => 0,
                //     'width' => 50,
                //     'height' => 50,
                //     'opacity' => 100,
                // ),
            ),
            'background' => PUBLIC_PATH . 'src/img/2/poster_bg.jpg',
        );
        posterImages($config);
    }
}
