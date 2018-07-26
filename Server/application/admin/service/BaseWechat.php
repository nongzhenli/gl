<?php
/* BaseWechat微信公众号基础模块
 * @Author: big黑钦
 * @Date: 2018-05-22 12:02:38
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-07-04 12:24:32
 */
namespace app\admin\service;

use thikn\Exception;
use app\admin\model\User as UserModel;
use app\admin\model\FansRecord as FansRecordModel;
use app\admin\model\WxUser as WxUserModel;
use app\admin\model\CommonImages as CommonImagesModel;

class BaseWechat
{
    protected $wx_id;
    protected $act_id;

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
    public function newUser($wxResult)
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
                'source_actid' => $act_id,
            ]);
            // 会员id
            return $user->id;
        }
    }

}
