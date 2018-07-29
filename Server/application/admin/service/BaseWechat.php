<?php
/* BaseWechat微信公众号基础模块
 * @Author: big黑钦
 * @Date: 2018-05-22 12:02:38
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-07-28 14:11:11
 */
namespace app\admin\service;

use app\admin\model\User as UserModel;
use app\admin\model\WxUser as WxUserModel;
use thikn\Exception;

class BaseWechat
{
    // 类全局微信id
    protected static $base_wx_id;
    // 类全局活动id
    protected static $base_act_id;
    // 类全局用户openid
    protected static $openid;
    // 类全局微信SDK
    protected static $base_wxSDKObj;

    // 加密
    public static function passport_encrypt($txt, $key = 'www.glagbn.com')
    {
        srand((double) microtime() * 1000000);
        $encrypt_key = md5(rand(0, 32000));
        $ctr = 0;
        $tmp = '';
        for ($i = 0; $i < strlen($txt); $i++) {
            $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
            $tmp .= $encrypt_key[$ctr] . ($txt[$i] ^ $encrypt_key[$ctr++]);
        }
        return urlencode(base64_encode(self::passport_key($tmp, $key)));
    }

    // 解密
    public static function passport_decrypt($txt, $key = 'www.glagbn.com')
    {
        $txt = self::passport_key(base64_decode(urldecode($txt)), $key);
        $tmp = '';
        for ($i = 0; $i < strlen($txt); $i++) {
            $md5 = $txt[$i];
            $tmp .= $txt[++$i] ^ $md5;
        }
        return $tmp;
    }

    // md5随机编码
    public static function passport_key($txt, $encrypt_key)
    {
        $encrypt_key = md5($encrypt_key);
        $ctr = 0;
        $tmp = '';
        for ($i = 0; $i < strlen($txt); $i++) {
            $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
            $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
        }
        return $tmp;
    }

    // 关联微信创建新用户
    public static function newUser($wxResult)
    {
        // 有可能会有异常，如果没有特别处理
        // 这里不需要try——catch
        // 全局异常处理会记录日志
        // 并且这样的异常属于服务器异常
        // 也不应该定义BaseException返回到客户端

        // $wxUserInfo_str = WxUser::getWxUserInfo($wxResult['access_token'], $wxResult['openid']);
        // 转成数组
        $wxUserInfo = json_decode($wxResult, true);

        // 在微信信息表创建一个微信记录
        $wx_user = WxUserModel::create([
            'openid' => $wxUserInfo['openid'],
            'nickname' => $wxUserInfo['nickname'],
            'wx_info' => $wxResult,
            'last_update_time' => time(),
            'create_time' => time(),
        ]);

        // 判断是否创建成功
        if (!$wx_user) {
            throw new Exception('微信公众号用户信息入库失败');
            // throw new TokenException([
            //     'msg' => '微信公众号用户信息入库',
            //     'errorCode' => 10008,
            // ]);
        } else {
            // 暂时将活动标记2
            // 创建成功，对照生成会员信息
            $user = UserModel::create([
                'openid' => $wxUserInfo['openid'],
                'nickname' => $wxUserInfo['nickname'],
                'last_update_time' => time(),
                'create_time' => time(),
                'source_actid' => self::$base_act_id,
            ]);
            // 返回新会员信息
            return $user;
        }
    }

    /**
     * getQRcodeInfo() 获取推广二维码数据
     * @return array('QRcode'=>'生成二维码信息','QRurl'=>二维码图片url,'expire_time'=>'二维码过期时间')
     */
    public static function getQRcodeInfo($scene_id = 0, $type = 0, $expire = 2592000)
    {
        /**
         * getQRCode 创建二维码ticket
         * @param int|string $scene_id 自定义追踪id,临时二维码只能用数值型
         * @param int $type 0:临时二维码；1:数值型永久二维码(此时expire参数无效)；2:字符串型永久二维码(此时expire参数无效)
         * @param int $expire 临时二维码有效期，最大为604800秒
         * @return array('ticket'=>'qrcode字串','expire_seconds'=>604800,'url'=>'二维码图片解析后的地址')
         */
        $getQRCodeArray = self::$base_wxSDKObj->getQRCode($scene_id, $type, $expire);

        /**
         * getQRUrl() 获取二维码图片地址
         * @param ticket|string     获取推广二维码ticket字串
         */
        $getQRUrlStr = self::$base_wxSDKObj->getQRUrl($getQRCodeArray['ticket']);

        return array(
            "QRcode" => $getQRCodeArray,
            "QRurl" => $getQRUrlStr,
            "expire_time" => time() + $getQRCodeArray['expire_seconds'],
        );

    }

    /**
     * sendReachSupporterTel() 发送达到推荐数模板消息
     * @param string    $openid         接收模板消息的用户
     * @param string    $url            跳转url
     * @param int       $complete_time  完成时间，由入库时间传参
     * @param array     $data           模板数据
     */
    public static function sendReachSupporterTel($template_id = '', $openid = '', $url = '', $complete_time = 0)
    {
        // 模板消息
        $data = array(
            "touser" => $openid,
            "template_id" => $template_id,
            "url" => $url,
            "topcolor" => "#FF0000",
            "data" => array(
                "first" => array(
                    "value" => "恭喜你已完成28人支持活动",
                    "color" => "#173177",
                ),
                "keyword1" => array(
                    "value" => "收集28人活动",
                    "color" => "#333",
                ),
                "keyword2" => array(
                    "value" => date('Y-m-d H:i:s', $complete_time),
                    "color" => "#333",
                ),
                "remark" => array(
                    "value" => "感谢您的参与，点击详情填写领取信息吧！",
                    "color" => "#f44336",
                ),
            ),
        );
        self::$base_wxSDKObj->sendTemplateMessage($data);
    }

    /**
     * sendSupporterTel() 发送支持消息模板
     * @param string    $openid         接收模板消息的用户
     * @param string    $name           接收模板消息的用户昵称或姓名
     * @param string    $parent_name    上级推荐人昵称或姓名
     * @param string    $url            跳转url
     * @param array     $data           模板数据
     */
    public static function sendSupporterTel($template_id = '', $name = '', $parent_name = '', $openid = '', $balance = 0, $url = '')
    {
        // 模板消息
        $data = array(
            "touser" => $openid,
            "template_id" => $template_id,
            "url" => $url,
            "topcolor" => "#FF0000",
            "data" => array(
                "first" => array(
                    "value" => "您有一位新朋友支持你啦！",
                    "color" => "#333",
                ),
                "keyword1" => array(
                    "value" => $name,
                    "color" => "#333",
                ),
                "keyword2" => array(
                    "value" => $parent_name,
                    "color" => "#333",
                ),
                "keyword3" => array(
                    "value" => date('Y-m-d H:i:s', time()),
                    "color" => "#333",
                ),
                "remark" => array(
                    "value" => "您还差" . $balance . "位小伙伴的支持可获得ins风顽皮粉红豹礼物一份，快快喊上你的好友来为你助力吧！",
                    "color" => "#f44336",
                ),
            ),
        );
        self::$base_wxSDKObj->sendTemplateMessage($data);
    }

}
