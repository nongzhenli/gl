<?php
/* Wechat 微信公众号开发
 * @Author: big黑钦
 * @Date: 2018-05-23 09:16:28
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-21 15:27:31
 */
namespace app\api\controller\v1;

use app\api\service\Wechat as WechatService;
use app\api\model\FansRecord as FansRecordModel;

class Wechat
{
    // 微信公众号开发
    public function wx()
    {
        $result = new WechatService();
    }

    /**
     * 查看活动状态
     * @param int   $act_id    活动id
     */
    public function verifyUser($act_id = 0)
    {
        $result = FansRecordModel::getUserStatu($act_id);
        return $result;
    }


    /**
     * 提交联系方式
     */
    public function updataNameMobile()
    {
        // 服务器端未做手机号码验证
        $data['custname'] = input('post.custname');
        $data['mobile'] = input('post.mobile');
        $data['sign_time'] = time();
        $data['status'] = 4; // 已填写联系方式报名

        // 活动id
        $act_id = input('post.act_id');

        $signInfo = FansRecordModel::updataNameMobile($data, $act_id);
        if (!$signInfo) {
            throw new Exception('请求错误');
        } else {
            return $signInfo;
        }
    }

    // 海报图生成
    public function test()
    {
        $config = array(
            'text' => array(),
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
            ),
            'background' => PUBLIC_PATH . '/src/img/2/poster_bg.jpg',
        );
        posterImages($config);
    }
}
