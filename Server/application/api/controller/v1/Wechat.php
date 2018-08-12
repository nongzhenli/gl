<?php
/* Wechat 微信公众号开发
 * @Author: big黑钦
 * @Date: 2018-05-23 09:16:28
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-08-01 17:01:17
 */
namespace app\api\controller\v1;

use app\api\model\FansRecord as FansRecordModel;
use app\api\service\Wechat as WechatService;
use Picture\Picture as PictureSDK;

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

    /**
     * 更新领取礼品状态
     */
    public function updataUserGood()
    {
        // 活动id
        $act_id = input('post.act_id');
        $userGoodInfo = FansRecordModel::updataUserGood($act_id);
        if (!$userGoodInfo) {
            throw new Exception('请求错误');
        } else {
            return $userGoodInfo;
        }
    }



    // 海报图生成
    public function test()
    {
        // $config = array(
        //     'text' => array(
        //         // 微信昵称
        //         array(
        //             'text' => '微信昵称',
        //             'left' => 360,
        //             'top' => 56,
        //             'fontPath' => APP_PATH . 'fonst/simkai.ttf', //字体文件
        //             'fontSize' => 14, //字号
        //             'fontColor' => '255,0,0', //字体颜色
        //             'angle' => 0,
        //         ),
        //     ),
        //     'image' => array(
        //         // 二维码
        //         array(
        //             'url' => 'https://qr.api.cli.im/qr?data=http%253A%252F%252Fbaidu.com&level=H&transparent=false&bgcolor=%23ffffff&forecolor=%23000000&blockpixel=12&marginblock=1&logourl=&size=280&kid=cliim&key=d44c420220c50c0a9fbbb91ddb1a769e', //图片资源路径
        //             'left' => 135,
        //             'top' => -165,
        //             'stream' => 0, //图片资源是否是字符串图像流
        //             'right' => 0,
        //             'bottom' => 0,
        //             'width' => 165,
        //             'height' => 165,
        //             'opacity' => 100,
        //         ),
        //         // 微信头像
        //         array(
        //             'url' => 'http://thirdwx.qlogo.cn/mmopen/yCIMP5iaBvmBqGcVRp8Qnknpx2TfDdiabef9ialQypNIia3icTzvicvyWTyh0uooLZyaVzHxrUnahZvpFc1Uq3usbe1x5KQHGdY39N/132',
        //             'left' => 300,
        //             'top' => 20,
        //             'right' => 0,
        //             'stream' => 0,
        //             'bottom' => 0,
        //             'width' => 46,
        //             'height' => 46,
        //             'opacity' => 100,
        //             'circ' => true
        //         ),
        //     ),
        //     'background' => PUBLIC_PATH . '/src/img/3/poster_bg.jpg',
        // );
        // posterImages($config);

        // Cache::store('redis')->set('keyTest', 1, 60);
        // $hasWxFCKey = Cache::store('redis')->get('key_test');
        // var_dump($hasWxFCKey);
        $config = array(
            'image' => array(
                array(
                    'start_x' => 135, //图片摆放横坐标
                    'start_y' => -650, //纵坐标
                    'width' => 165,
                    'height' => 165,
                    'path' => 'https://qr.api.cli.im/qr?data=http%253A%252F%252Fbaidu.com&level=H&transparent=false&bgcolor=%23ffffff&forecolor=%23000000&blockpixel=12&marginblock=1&logourl=&size=280&kid=cliim&key=d44c420220c50c0a9fbbb91ddb1a769e',
                ),
                array(
                    'start_x' => 300, //图片摆放横坐标
                    'start_y' => 20, //纵坐标
                    'width' => 46,
                    'height' => 46,
                    'path' => 'http://thirdwx.qlogo.cn/mmopen/yCIMP5iaBvmBqGcVRp8Qnknpx2TfDdiabef9ialQypNIia3icTzvicvyWTyh0uooLZyaVzHxrUnahZvpFc1Uq3usbe1x5KQHGdY39N/132',
                    'circ' => true
                ),
            ),
            'text' => array(
                // 微信昵称
                array(
                    'str' => '这是什么鬼啊啊',
                    'fontPath' => APP_PATH . 'fonst/simkai.ttf',
                    'x' => 360,
                    'y' => 52,
                    'fontSize' => 14,
                    'fontColor' => '51,51,51',
                    'angle' => 0,
                ),
            ),
            'background' => PUBLIC_PATH . '/src/img/3/poster_bg.jpg',
        );
        createPoster($config, PUBLIC_PATH.'/src/img/3/qrcode/1.jpg');
    }
}
