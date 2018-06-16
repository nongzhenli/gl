<?php
/* Wxcaht 微信公众号开发业务处理
 * @Author: big黑钦
 * @Date: 2018-06-05 15:51:56
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-16 17:05:40
 */
namespace app\api\service;

use app\api\model\User as UserModel;
use app\api\model\WxUser as WxUserModel;
use app\api\model\FansRecord as FansRecordModel;
use WechatSdk\Wechat as WechatSdk;

class Wechat
{
    protected $options;
    protected $wechatSDK;

    // 初始化函数
    public function __construct()
    {
        // 配置信息
        $this->options = array(
            'token' => 'nzhllt0323421', //填写你设定的key
            // 'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
            'appid' => 'wx0032b65859a2fe53', //填写高级调用功能的app id
            'appsecret' => '952fa7f0b7e740c0bb458562fdeee27f', //填写高级调用功能的密钥
            'debug' => true,
            'logcallback' => 'logdebug',
        );
        $this->wechatSDK = new WechatSdk($this->options);
        // token检验
        $this->wechatSDK->valid();

        // 获取微信服务器返回类型
        $type = $this->wechatSDK->getRev()->getRevType();

        switch ($type) {
            case WechatSdk::MSGTYPE_TEXT:
                $this->handleTextMessage();
                break;
            case WechatSdk::MSGTYPE_EVENT:
                $this->handleEventMessage();
                break;
            case WechatSdk::MSGTYPE_IMAGE:
                $this->handleImageMessage();
                break;
            default:
                $this->wechatSDK->text("help info")->reply();
        }
    }

    // 处理文本消息
    public function handleTextMessage()
    {
        // $mediaid= "FiMgR6R_GgJq-96ycgfvW_pPwZt9JVbfbA31s4Ioub4-9_XXg-4X8hsowIqGGSpi";

        // 上传临时素材
        $data['media'] = '@'.PUBLIC_PATH.'src/img/2/poster_bg.jpg';
        $result = $this->wechatSDK->uploadMedia($data, "image");
        $result = json_encode($result);
        $this->wechatSDK->text($result)->reply();
        // $this->wechatSDK->image($result)->reply();
    }

    // 处理事件消息
    public function handleEventMessage()
    {
        
        /** getRevEvent() 返回事件类型
         * @param event         类型
         * @param key           key
         * @return array|bool
         */
        $getRevEvent = $this->wechatSDK->getRev()->getRevEvent();
        $event = $getRevEvent['event'];
        $key = $getRevEvent['key'];

        // 获取用户openid
        $openid = $this->wechatSDK->getRev()->getRevFrom();

        // 关注事件
        if($event == "subscribe" && !$key){

            // 获取用户详细信息
            $wxUserInfoJson = json_encode($this->wechatSDK->getUserInfo($openid), JSON_UNESCAPED_UNICODE);
            /**
             * 验证用户表是否存在该用户
             * 1.如果存在，返回用户uid
             * 2.如果不存在，则新建用户并且返回uid
             */
            $user = UserModel::getByOpenID($openid);
            if (!$user) {
                $uid = $this->newUser($wxUserInfoJson);
            } else {
                $uid = $user->id;
            }
            return;
        }

        // 取消关注事件
        if($event == "unsubscribe"){
            return;
        }

        // 未关注扫描带参数二维码事件
        if($event == "subscribe" && $key){
            return;
        }

        // 已关注扫描带参数二维码事件
        if($event == "SCAN" && $key){
            return;
        }
        


        // // 用户openid
        // $openid = $event['FromUserName'];
        // //获取关注者详细信息
        // $wxResult = json_encode($this->wechatSDK->getUserInfo($openid), JSON_UNESCAPED_UNICODE);

        // /**
        //  * 验证用户表是否存在该用户
        //  * 1.如果存在，返回用户uid
        //  * 2.如果不存在，则新建用户并且返回uid
        //  */
        // $user = UserModel::getByOpenID($openid);
        // if (!$user) {
        //     $uid = $this->newUser($wxResult);
        // } else {
        //     $uid = $user->id;
        // }



        // $this->wechatSDK->text($uid)->reply();
    }

    // 处理图片消息
    public function handleImageMessage($type)
    {
        $type = json_encode($type);
        $mediaid= "FiMgR6R_GgJq-96ycgfvW_pPwZt9JVbfbA31s4Ioub4-9_XXg-4X8hsowIqGGSpi";
        $this->wechatSDK->image($mediaid)->reply();

    }

    // 创建新用户
    private function newUser($wxResult)
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
            'create_time' => time()
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
                'source_actid' => 2,
            ]);
            // 会员id
            $uid = $user->id;

            /**
             * 此处应该封装一个通用函数用来判断会员参与活动进行入库
             * 现在仅限对抽奖报名LotteryRecord进行入库
             */
            // 插入一条报名记录
            $status = 1;    // 1已关注
            $act_id = 2;    // 活动id，实际上应该从Url参数获取
            $parent_id = 1; // 推荐人id，实际上应该从URL参数获取

            $record = FansRecordModel::insertFansRecord($uid, $wxUserInfo['openid'], $status = 1, $act_id, $parent_id);
            if (!$record) {
                throw new Exception('参与吸粉报名失败');
            }

            // 并返回会员id
            return $uid;
        }
    }

}
