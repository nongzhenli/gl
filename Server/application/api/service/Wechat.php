<?php
/* Wxcaht 微信公众号开发业务处理
 * @Author: big黑钦
 * @Date: 2018-06-05 15:51:56
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-16 17:05:40
 */
namespace app\api\service;

use app\api\model\FansRecord as FansRecordModel;
use app\api\model\ActionImages as ActionImagesModel;
use app\api\model\User as UserModel;
use app\api\model\WxUser as WxUserModel;
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
                $this->wechatSDK->text('')->reply();
        }
    }

    // 处理文本消息
    public function handleTextMessage()
    {
        // $mediaid= "FiMgR6R_GgJq-96ycgfvW_pPwZt9JVbfbA31s4Ioub4-9_XXg-4X8hsowIqGGSpi";
        // 上传临时素材
        // $data['media'] = '@'.PUBLIC_PATH.'src/img/2/poster_bg.jpg';
        // $media_result = $this->wechatSDK->uploadMedia($data, "image");
        // $media_result = json_encode($media_result);
        // $this->wechatSDK->text($media_result)->reply();
        // $this->wechatSDK->image($result)->reply();

        // $scene_id = 1;
        // $type = 0;
        // $expire = 2592000;
        // $str = json_encode($this->getQRcodeInfo($scene_id, $type, $expire));
        // $this->wechatSDK->text($str)->reply();
        $act_id = 2;
        $uid = 1;
        $poster_url = "/home/wwwroot/glagbn/public/src/img/2/qrcode/qrcode_2_1.jpg";
        $images_id = ActionImagesModel::insertActionImages($act_id, $uid, $poster_url);
        $images_id = json_encode($images_id);
        $this->wechatSDK->text($images_id)->reply();
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
        // $key = $getRevEvent['key'];

        // 获取用户openid
        $openid = $this->wechatSDK->getRev()->getRevFrom();

        // 普通关注事件、未关注扫描带参数二维码事件
        if ($event == "subscribe") {
            // ****************************共用区域*************************************
            // 获取推荐人，如果参数没有，则为0
            $parent_id = $this->wechatSDK->getRevSceneId();
            if(!$parent_id){
                $parent_id = 0;
            }
            // 获取用户详细信息
            $wxUserInfoJson = json_encode($this->wechatSDK->getUserInfo($openid), JSON_UNESCAPED_UNICODE);
            /**
             * 验证用户表是否存在该用户
             * 1.如果存在，返回用户uid
             * 2.如果不存在，则新建用户并且返回uid
             */
            $user = UserModel::getByOpenID($openid);
            if (!$user) {
                /**
                 * 创建新用户，并添加活动记录
                 * @param string    $wxUserInfoJson 微信用户信息
                 * @param string    $wxUserInfoJson 微信用户信息
                 */
                $uid = $this->newUser($wxUserInfoJson);
            } else {
                $uid = $user->id;
            }
            // ****************************共用区域 end**********************************
            

            // 判断该微信用户是否存在未关注记录（表示该用户曾经关注过此公众号）
            $fansRecor = FansRecordModel::getByUserId($uid);
            if(!$fansRecor){
                // *********** 1、生成二维码图片 *******************************
                // $scene_id = $uid; // 参数可以是推荐人id
                $type = 0;  // 临时二维码
                $expire = 2592000;  // 二维码有效期时长
                $getQRcodeInfo = $this->getQRcodeInfo($uid, $type, $expire);
                // 海报背景图
                $posterBackground = PUBLIC_PATH . 'src/img/2/poster_bg.jpg';
                // *********** 生成二维码图片 end *****************************
                // *********** 2、海报生成，并返回服务器保存地址 *******************************
                $config = array(
                    // 文字
                    'text' => array(),
                    'image' => array(
                        // 二维码
                        array(
                            'url' => $getQRcodeInfo['QRurl'],
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
                    'background' => $posterBackground,
                );
                // 海报保存路径
                $act_id = 2; // 自定义活动id
                $filename = PUBLIC_PATH.'src/img/2/qrcode/qrcode_'.$act_id.'_'.$uid.'.jpg';
                // 调用生成海报函数
                $poster_url = createPoster($config, $filename);
                // *********** 海报生成，并返回服务器保存地址 end *******************************
                // *********** 4、上传临时素材 **************************************
                $data['media'] = '@'.$poster_url;
                $mediaInfo = $this->wechatSDK->uploadMedia($data, "image");
                $media_id = $mediaInfo['media_id'];
                if($media_id){
                    /** 添加海报图片记录
                     * @param  int       $act_id     活动id
                     * @param  int       $uid        用户uid
                     * @param  string    $poster_url 海报url
                     * @param  int       $media_id   海报url
                     * @return int                   返回记录id
                     */
                    $images_record = ActionImagesModel::insertActionImages($act_id, $uid, $poster_url, $media_id);
                    if(!$images_record){
                        throw new Exception('推广海报图片资源入库失败');
                    }else {
                        // 新增记录
                        $status = 1; // 1已关注
                        $act_id = 2; // 活动id，实际上应该从Url参数获取
                        $poster_id = $images_record->id;

                        $record = FansRecordModel::insertFansRecord($uid, $openid, $status = 1, $poster_id, $parent_id, $act_id);
                        if (!$record) {
                            throw new Exception('参与吸粉报名失败');
                        }
    

                    }
                }
                // *********** 上传临时素材 end *************************************

                // 推送海报图片消息
                $this->wechatSDK->image($media_id)->reply();
            }else {
                // 假如已经存在过，状态satus: 0 取消关注
                if($fansRecor['status'] == 0){

                    // 更新字段，取消关注状态
                    $result = (new FansRecordModel())->save([
                        'status' => 1,
                        'last_follow_unfollow_time' => time(),
                    ], [
                        'id' => $fansRecor['id'],
                    ]);

                    if($result){
                        // 自定义一个局部媒体id变量
                        $media_id = "";
                        // 查询对应图片资源记录
                        $imagesRecor = ActionImagesModel::getById($fansRecor['poster_id']);
                        if(time() > $imagesRecor['media_expire_time']){
                            $data['media'] = '@'.$imagesRecor['images_url'];
                            $mediaInfo = $this->wechatSDK->uploadMedia($data, "image");

                            // 重新更新 媒体id
                            (new ActionImagesModel())->save([
                                'media_id' => $mediaInfo['media']
                            ], [
                                'id' => $fansRecor['poster_id'],
                                'images_url' => ['!=', NULL]
                            ]);
                            
                            $media_id = $mediaInfo['media_id'];
                        }else {
                            $media_id = $imagesRecor['media_id'];
                        }
                        
                    }
                   
                    // 推送海报图片消息
                    $this->wechatSDK->image($media_id)->reply();
                }
            }

            return;
        }

        // 取消关注事件
        if ($event == "unsubscribe") {
            $act_id =2;
            // 获取用户表记录
            $user = UserModel::getByOpenID($openid);
            if($user){
                // 更新字段，取消关注状态
                $result = (new FansRecordModel())->save([
                    'status' => 0,
                    'last_follow_unfollow_time' => time(),
                ], [
                    'act_id' => $act_id,
                    'user_id' => $user->id,
                ]);
                return $result;
            }

            $this->wechatSDK->text('用户取消关注')->reply();
            
        }

        // 未关注扫描带参数二维码事件
        if ($event == "subscribe" && $key) {

            $this->wechatSDK->text('打印个牛逼试试看')->reply();
            return;
        }

        // 已关注扫描带参数二维码事件
        if ($event == "SCAN" && $key) {
            return;
        }
      
    }

    // 处理图片消息
    public function handleImageMessage($type)
    {
        $type = json_encode($type);
        $mediaid = "FiMgR6R_GgJq-96ycgfvW_pPwZt9JVbfbA31s4Ioub4-9_XXg-4X8hsowIqGGSpi";
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
                'source_actid' => 2,
            ]);
            // 会员id
            $uid = $user->id;

            /**
             * 此处应该封装一个通用函数用来判断会员参与活动进行入库
             * 现在仅限对抽奖报名LotteryRecord进行入库
             */
            // // 插入一条报名记录
            // $status = 1; // 1已关注
            // $act_id = 2; // 活动id，实际上应该从Url参数获取

            // $record = FansRecordModel::insertFansRecord($uid, $wxUserInfo['openid'], $status = 1, $act_id, $parent_id);
            // if (!$record) {
            //     throw new Exception('参与吸粉报名失败');
            // }

            // 并返回会员id
            return $uid;
        }
    }

    /**
     * getQRcodeInfo() 获取推广二维码数据
     * @return array('QRcode'=>'生成二维码信息','QRurl'=>二维码图片url,'expire_time'=>'二维码过期时间')
     */
    public function getQRcodeInfo($scene_id = 0, $type=0, $expire=2592000)
    {
        /**
         * getQRCode 创建二维码ticket
         * @param int|string $scene_id 自定义追踪id,临时二维码只能用数值型
         * @param int $type 0:临时二维码；1:数值型永久二维码(此时expire参数无效)；2:字符串型永久二维码(此时expire参数无效)
         * @param int $expire 临时二维码有效期，最大为604800秒
         * @return array('ticket'=>'qrcode字串','expire_seconds'=>604800,'url'=>'二维码图片解析后的地址')
         */
        $getQRCodeArray = $this->wechatSDK->getQRCode($scene_id, $type, $expire);

        /**
         * getQRUrl() 获取二维码图片地址
         * @param ticket|string     获取推广二维码ticket字串
         */
        $getQRUrlStr = $this->wechatSDK->getQRUrl($getQRCodeArray['ticket']);

        return array(
            "QRcode" => $getQRCodeArray,
            "QRurl" => $getQRUrlStr,
            "expire_time" => time() + $getQRCodeArray['expire_seconds'],
        );

    }

    /**
     * followEventUnified() 集中处理用户关注业务
     * @param string    $type  事件类型，此处针对：subscribe关注、unsubscribe取消关注、SCAN已关注扫码
     * @param string    $key   参数，仅扫带参数二维码存在值，否则空对象
     * @param string    $type  事件类型，此处针对：subscribe关注、unsubscribe取消关注、SCAN已关注扫码
     */
    public static function followEventUnified($type=0, $key = NULL){

    }

}
