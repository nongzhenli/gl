<?php
/* Wxcaht 微信公众号开发业务处理
 * @Author: big黑钦
 * @Date: 2018-06-05 15:51:56
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-08-09 17:55:21
 */
namespace app\api\service;

use app\api\model\CommonImages as CommonImagesModel;
use app\api\model\FansRecord as FansRecordModel;
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
            'token' => 'glagbn', //填写你设定的key
            'encodingaeskey' => 'GlsKegpYm1rHmCnwS410b1C7kKMvF6RPwXNIpTPmkSD', //填写加密用的EncodingAESKey
            'appid' => 'wxcdc9d1e517b30d81', //填写高级调用功能的app id
            'appsecret' => '8bb6f9d81b321b11df12c17989f19fde', //填写高级调用功能的密钥
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
                // $this->wechatSDK->text('')->reply();
                return true;
        }
    }

    // 处理文本消息
    public function handleTextMessage()
    {
        $openid = $this->wechatSDK->getRev()->getRevFrom();
        if($openid == "oc5301RvDlrwZeaGG5Mi-BN0Oyxc"){
            $wxUserInfoArr = $this->wechatSDK->getUserInfo($openid);
            $tmpStr = userTextEncode($wxUserInfoArr['nickname']);

            $this->sendSupporterTel(userTextDecode($tmpStr), userTextDecode($tmpStr), $openid, 1);
            $this->wechatSDK->text(userTextDecode($tmpStr."\ue419"))->reply();
        }
        // 获取菜单
        // $menu = $this->wechatSDK->getMenu();
        // // 自定义菜单栏设置
        // $newmenu = array(
        //     "button" => array(
        //         // 0 => array(
        //         //     "type" => "view",
        //         //     "name" => "幸运抽奖",
        //         //     "url" => "http://gl.gxqqbaby.cn/#/action/aid/1",
        //         // ),
        //         0 => array(
        //             "name" => "近期活动",
        //             "sub_button" => array(
        //                 0 => array(
        //                     "type" => "click",
        //                     "name" => "查看我的人气",
        //                     "key" => "LOOK_MY_NUM",
        //                 ),
        //                 1 => array(
        //                     "type" => "click",
        //                     "name" => "获取推广海报",
        //                     "key" => "GET_POSTER_IMAGES",
        //                 ),
        //                 2 => array(
        //                     "type" => "view",
        //                     "name" => "填写领取信息",
        //                     "url" => "http://gl.gxqqbaby.cn/#/action/aid/2",
        //                 ),
        //             ),
        //         ),
        //     ),
        // );
        // $newmenu_result = $this->wechatSDK->createMenu($newmenu);
        // $this->wechatSDK->text($newmenu_result)->reply();
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
        $act_id = 2; // 活动id
        // $key = $getRevEvent['key'];

        // 获取用户openid
        $openid = $this->wechatSDK->getRev()->getRevFrom();

        // 普通关注事件、未关注扫描带参数二维码事件
        if ($event == "subscribe") {
            // ****************************共用区域*************************************
            // 获取用户详细信息
            $wxUserInfoArr = $this->wechatSDK->getUserInfo($openid);
            $wxUserInfoJson = json_encode($wxUserInfoArr, JSON_UNESCAPED_UNICODE);
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
                 */
                $user = $this->newUser($openid, $wxUserInfoArr['nickname'], $wxUserInfoJson);
                $uid = $user->id;
            } else {
                $uid = $user->id;
            }
            
            // ****************************共用区域 end**********************************
            // 判断该微信用户是否存在未关注记录（表示该用户曾经关注过此公众号）
            $fansRecor = FansRecordModel::getByUserId($uid, $act_id);
            // 如果存在记录，且字段parent_id大于0
            if ($fansRecor && $fansRecor['parent_id'] > 0) {
                $parent_id = $fansRecor['parent_id'];
            } else {
                // 如果不存在记录或字段parent_id等于0
                $parent_id = $this->wechatSDK->getRevSceneId();
                if (!$parent_id) {
                    $parent_id = 0;
                }
            }
            // 自定义一个局部媒体id变量
            $media_id = "";
            if (!$fansRecor) {
                // *********** 1、生成二维码图片 *******************************
                // $scene_id = $uid; // 参数可以是推荐人id
                $type = 0; // 临时二维码
                $expire = 2592000; // 二维码有效期时长
                $getQRcodeInfo = $this->getQRcodeInfo($uid, $type, $expire);
                // $this->wechatSDK->text(json_encode($getQRcodeInfo, JSON_UNESCAPED_UNICODE))->reply();
                // 海报背景图
                $posterBackground = PUBLIC_PATH . '/src/img/2/poster_bg.jpg';
               
                // *********** 生成二维码图片 end *****************************
                // *********** 2、海报生成，并返回服务器保存地址 *******************************
                $config = array(
                    // 文字
                    'text' => array(),
                    'image' => array(
                        // 二维码
                        array(
                            'path' =>  $getQRcodeInfo['QRurl'],
                            'start_x' => 135,
                            'start_y' => -650,
                            'width' => 165,
                            'height' => 165,
                        ),
                    ),
                    'background' => $posterBackground,
                );
                // 海报相对路径（存放数据库，站点静态资源访问）
                $relative_filename = '/src/img/' . $act_id . '/qrcode/qrcode_' . $act_id . '_' . $uid . '.jpg';
                // 海报保存路径（绝对路径，用作上传媒体文件）
                $filename = PUBLIC_PATH . $relative_filename;
                // 调用生成海报函数
                $poster_url = createPoster($config, $filename);
                // *********** 海报生成，并返回服务器保存地址 end *******************************
                // *********** 4、上传临时素材 **************************************
                $data['media'] = '@' . $poster_url;
                $mediaInfo = $this->wechatSDK->uploadMedia($data, "image");
                $media_id = $mediaInfo['media_id'];
                // $this->wechatSDK->text(json_encode($media_id, JSON_UNESCAPED_UNICODE))->reply();
                // exit();
                if ($media_id) {
                    /** 添加海报图片记录
                     * @param  int       $act_id            活动id
                     * @param  int       $uid               用户uid
                     * @param  string    $poster_url        海报URL绝对路径
                     * @param  string    $relative_filename 海报URL相对路径
                     * @param  int       $media_id          海报媒体id
                     * @return int                          返回记录id
                     */
                    $images_record = CommonImagesModel::insertCommonImages($act_id, $uid, $relative_filename, $media_id);
                    if (!$images_record) {
                        // $this->wechatSDK->text("数据异常1")->reply();
                        // throw new Exception('推广海报图片资源入库失败');
                    } else {
                        // 新增记录
                        $status = 1; // 1已关注
                        $poster_id = $images_record->id;

                        $record = FansRecordModel::insertFansRecord($uid, $openid, $status = 1, $poster_id, $parent_id, $act_id);
                        if (!$record) {
                            // $this->wechatSDK->text("数据异常2")->reply();
                            // throw new Exception('微信公众号吸粉入库失败');
                        }
                    }
                }
                // *********** 上传临时素材 end *************************************

            } else {
                // 假如已经存在过，状态satus: 0 取消关注
                if ($fansRecor['status'] == 0) {
                    /**
                     * 细节优化：
                     * 再判断一步$parent_id 是否等于当前用 uid，如果是，则$parent_id = 0
                     * 这种情形出现在 用户取消关注，然后再通过扫自己的推广二维码进入，如此把自己的名单也算进推广量
                     * 同时也防范了互刷推广量的行为
                     */
                    if ($parent_id == $fansRecor['user_id']) {
                        $parent_id = 0;
                    }

                    // 更新字段，关注状态
                    $result = (new FansRecordModel())->save([
                        'status' => 1,
                        'parent_id' => $parent_id, // 如上已对$parent_id，如果存在源数据，且字段parent_id等于0，如存在参数则变更未参数值
                        'last_follow_unfollow_time' => time(),
                    ], [
                        'id' => $fansRecor['id'],
                    ]);

                    if ($result) {
                        // 查询对应图片资源记录
                        $imagesRecor = CommonImagesModel::getById($fansRecor['poster_id']);
                        if ($imagesRecor) {
                            if (time() >= $imagesRecor['media_expire_time']) {
                                // 此处拼接 PUBLIC_PATH保证图片资源绝对路径
                                $data['media'] = '@' . PUBLIC_PATH . $imagesRecor['images_url'];
                                $mediaInfo = $this->wechatSDK->uploadMedia($data, "image");

                                // 重新更新 媒体id
                                (new CommonImagesModel())->save([
                                    'media_id' => $mediaInfo['media_id'],
                                    'media_expire_time' => $mediaInfo['created_at'] + 259200,
                                    'last_time' => time(),
                                ], [
                                    'id' => $fansRecor['poster_id'],
                                ]);

                                $media_id = $mediaInfo['media_id'];
                            } else {
                                $media_id = $imagesRecor['media_id'];
                            }
                        } else {
                            throw new Exception('找不到推广海报记录');
                        }

                    } else {
                        throw new Exception('用户非首次关注发生异常');
                    }
                }
            }

            // 发送客服消息，提醒作用
            $customArr = array(
                "touser" => $openid,
                "msgtype" => "text",
                "text" => array(
                    "content" => "感谢您对安格贝妮儿童摄影的支持！\n\n完成以下4步操作\n即可免费领走价值\n--------\n第一步：点击保存二维码海报\n第二步：分享给10位好友进行扫码关注\n第三步：完成任务后【点击详情】提交联系方式\n第四步：耐心等待客服通知，即可来店领取\n--------\n海报生成中，请等待1-2秒\n\n快去邀请好友吧！儿童卡通不锈钢套碗等着你！",
                ),
            );
            $this->wechatSDK->sendCustomMessage($customArr);
            // 推送海报图片消息
            $this->wechatSDK->image($media_id)->reply();

            // **************************** 推荐拉人模板消息 **********************************
            // 用户每次关注，都对上级推广人的数据进行统计、消息推送
            $where_count = 10; // 完成条件
            if($parent_id != 0){
                $parent_count = FansRecordModel::where([
                    'parent_id' => $parent_id,
                    'act_id' => $act_id,
                ])->count();
                
                // 获取推荐人用户信息
                $parent_user = UserModel::getByUserID($parent_id);
            }elseif($parent_id == 0) {
                // 将推荐数设置0，方便代码过渡
                $parent_count = 0;
            }
            // 完成通知（仅做一次的提示，避免违反模板通知规则，后期拓展改进）
            if ($parent_count >= $where_count) {
                // 记录上级推荐人完成时间
                $complete_time = time();
                $updata_complete_time = (new FansRecordModel())->save([
                    'status' => 2,
                    'complete_time' => $complete_time,
                ], [
                    'act_id' => $act_id,
                    'user_id' => $parent_id,
                ]);
                // 跳转url
                $url = "http://gl.gxqqbaby.cn/#/action/aid/2";
                $this->sendReachSupporterTel($parent_user['openid'], $url, $complete_time);

            } elseif ($parent_count > 0 && $parent_count < $where_count) { // 好友助力通知
                // $this->sendSupporterTel($user['nickname'], $parent_user['nickname'], $openid, $where_count - $parent_count);
                $this->sendSupporterTel($user['nickname'], $parent_user['nickname'], $parent_user['openid'], $where_count - $parent_count);
            }
            // **************************** 推荐拉人模板消息 end ********************************

            return;
        }

        // 取消关注事件
        if ($event == "unsubscribe") {
            $act_id = 2;
            // 获取用户表记录
            $user = UserModel::getByOpenID($openid);
            if ($user) {
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
            return;
        }

        // 已关注扫描带参数二维码事件
        if ($event == "SCAN") {
            // TODO
        }
        
        // 自定义菜单点击事件
        if($event == "CLICK"){
            // 查看我的人气
            if($getRevEvent['key'] == "LOOK_MY_NUM"){
                $this->getCurrentUserPNum($openid, $act_id);
            }elseif($getRevEvent['key'] == "GET_POSTER_IMAGES"){ // 获取推广海报
                // $this->wechatSDK->text($openid)->reply();
                $this->getPosterImageMessage($openid, $act_id);
            }
            return;
        }

    }

    // 处理图片消息
    public function handleImageMessage($type)
    {
        // $type = json_encode($type);
        // $mediaid = "FiMgR6R_GgJq-96ycgfvW_pPwZt9JVbfbA31s4Ioub4-9_XXg-4X8hsowIqGGSpi";
        // $this->wechatSDK->image($mediaid)->reply();

    }

    // 创建新用户
    private function newUser($openid, $nickName='', $wxResult)
    {
        // 有可能会有异常，如果没有特别处理
        // 这里不需要try——catch
        // 全局异常处理会记录日志
        // 并且这样的异常属于服务器异常
        // 也不应该定义BaseException返回到客户端

        // 微信昵称emoji字符转码处理
        $wxUserInfo = json_decode($wxResult, true);
        // if(!empty($nickName)){
        //     $nickName = userTextEncode($nickName);
        // }else {
        //     throw new Exception('获取用户微信昵称异常');
        // }
        
        // 在微信信息表创建一个微信记录
        $wx_user = WxUserModel::create([
            'openid' => $openid,
            // 'nickname' => $nickName,
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
                'openid' => $openid,
                // 'nickname' => $nickName,
                'nickname' => $wxUserInfo['nickname'],
                'last_update_time' => time(),
                'create_time' => time(),
                'source_actid' => 2,
            ]);
            // 会员id
            return $user;
        }
    }

    /**
     * getQRcodeInfo() 获取推广二维码数据
     * @return array('QRcode'=>'生成二维码信息','QRurl'=>二维码图片url,'expire_time'=>'二维码过期时间')
     */
    public function getQRcodeInfo($scene_id = 0, $type = 0, $expire = 2592000)
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
     * sendSupporterTel() 发送支持消息模板
     * @param string    $openid         接收模板消息的用户
     * @param string    $name           接收模板消息的用户昵称或姓名
     * @param string    $parent_name    上级推荐人昵称或姓名
     * @param string    $url            跳转url
     * @param array     $data           模板数据
     */
    public function sendSupporterTel($name = '', $parent_name = '', $openid = '', $balance = 0, $url = '')
    {
        // 消息模板id
        $template_id = "I3caJoSngdTHWByuHgZ5r-NoFVYXJxZMusit7n_z-As";
        // 模板消息
        $data = array(
            "touser" => $openid,
            "template_id" => $template_id,
            "url" => $url,
            "data" => array(
                "first" => array(
                    "value" => "您有一位新朋友支持你啦！",
                    "color" => "#f44336",
                ),
                "keyword1" => array(
                    "value" => $name,
                ),
                "keyword2" => array(
                    "value" => $parent_name,
                ),
                "keyword3" => array(
                    "value" => date('Y年m月d日 H:i:s', time()),
                ),
                "remark" => array(
                    "value" => "您还差".$balance."位小伙伴的支持可获得儿童卡通不锈钢套碗一份，快快喊上你的好友来为你助力吧！",
                    "color" => "#f44336",
                ),
            ),
        );
        $this->wechatSDK->sendTemplateMessage($data);
    }

    /**
     * sendReachSupporterTel() 发送达到推荐数模板消息
     * @param string    $openid         接收模板消息的用户
     * @param string    $url            跳转url
     * @param int       $complete_time  完成时间，由入库时间传参
     * @param array     $data           模板数据
     */
    public function sendReachSupporterTel($openid = '', $url = '', $complete_time = 0)
    {
        // 消息模板id
        $template_id = "PrLAd3hXlzigbKIEi96NrUZBfGQxtcJSGQIUMhknnzI";
        // 模板消息
        $data = array(
            "touser" => $openid,
            "template_id" => $template_id,
            "url" => $url,
            "topcolor" => "#FF0000",
            "data" => array(
                "first" => array(
                    "value" => "恭喜你已完成10人支持活动",
                    "color" => "#173177",
                ),
                "keyword1" => array(
                    "value" => "收集10人活动",
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
        $this->wechatSDK->sendTemplateMessage($data);
    }

    /**
     * followEventUnified() 集中处理用户关注业务
     * @param string    $type  事件类型，此处针对：subscribe关注、unsubscribe取消关注、SCAN已关注扫码
     * @param string    $key   参数，仅扫带参数二维码存在值，否则空对象
     */
    public static function followEventUnified($type = 0, $key = null)
    {

    }

    /**
     * getPosterImageMessage 获取推广海报图片消息
     * @param string    $openid 用户openid
     */
    public function getPosterImageMessage($openid, $act_id=2)
    {
        // 获取用户信息
        $user = UserModel::getByOpenID($openid);
        if(!$user){
            $this->wechatSDK->text('找不到当前用户信息')->reply();
        }else {
            // 查询粉丝关注记录详情
            $fansRecor = FansRecordModel::getByUserId($user->id, $act_id);
            // 查询对应图片资源记录
            $imagesRecor = CommonImagesModel::getById($fansRecor['poster_id']);
            if ($imagesRecor) {
                if (time() >= $imagesRecor['media_expire_time']) {
                    // 每次获取海报，先判断海报文件是否存在（手动删除文件，进行更新海报背景图）
                    if(!is_file(PUBLIC_PATH.$imagesRecor['images_url'])){
                        $data['media'] = '@'.$this->createNewQRcodePosterImg($user->id, $act_id);
                    }else {
                        // 此处拼接 PUBLIC_PATH保证图片资源绝对路径
                        $data['media'] = '@' . PUBLIC_PATH . $imagesRecor['images_url'];
                    }
                    $mediaInfo = $this->wechatSDK->uploadMedia($data, "image");
                    // 重新更新 媒体id
                    (new CommonImagesModel())->save([
                        'media_id' => $mediaInfo['media_id'],
                        'media_expire_time' => $mediaInfo['created_at'] + 259200,
                        'last_time' => time(),
                    ], [
                        'id' => $fansRecor['poster_id'],
                    ]);

                    $media_id = $mediaInfo['media_id'];
                } else {
                    $media_id = $imagesRecor['media_id'];
                }
                // 回复图片消息
                $this->wechatSDK->image($media_id)->reply();
            } else {
                // 如果获取不到海报记录，则重新插入一条信息的记录
                
                
                
                throw new Exception('找不到推广海报记录');
            }
        }
    }

    /**
     * getCurrentUserPNum 获取当前用户推荐人数
     * @param string    $openid 用户openid
     */
    public function getCurrentUserPNum($openid, $act_id){
        $user = UserModel::getByOpenID($openid);
        if(!$user){
            $this->wechatSDK->text('找不到当前用户信息')->reply();
            exit();
        }
        $people_count = FansRecordModel::where([
            'parent_id' => $user->id,
            'act_id' => $act_id,
        ])->count();
        if($people_count == 0){
            $this->wechatSDK->text('您还没有朋友支持哦，加油~')->reply(); 
        }elseif($people_count > 0) {
            $this->wechatSDK->text('已经有'.$people_count.'位朋友支持您了~ 棒棒的，加油！')->reply();
        }
        
    }

    /**
     * createQRcodePosterImg 合成二维码海报
     * @param string    $openid 用户openid
     * 独立一个函数，方便重新生成海报图
     */
    public function createNewQRcodePosterImg($uid, $act_id=2){
        // $scene_id = $uid; // 参数可以是推荐人id
        $type = 0; // 临时二维码
        $expire = 2592000; // 二维码有效期时长
        $getQRcodeInfo = $this->getQRcodeInfo($uid, $type, $expire);
        // *********** 生成二维码图片 end *****************************
        // 海报背景图
        $posterBackground = PUBLIC_PATH . '/src/img/2/poster_bg.jpg';
        // *********** 2、海报生成，并返回服务器保存地址 *******************************
        $config = array(
            // 文字
            'text' => array(),
            'image' => array(
                // 二维码
                array(
                    'path' =>  $getQRcodeInfo['QRurl'],
                    'start_x' => 135,
                    'start_y' => -650,
                    'width' => 165,
                    'height' => 165,
                ),
            ),
            'background' => $posterBackground,
        );
        // 海报相对路径（存放数据库，站点静态资源访问）
        $relative_filename = '/src/img/' . $act_id . '/qrcode/qrcode_' . $act_id . '_' . $uid . '.jpg';
        // 海报保存路径（绝对路径，用作上传媒体文件）
        $filename = PUBLIC_PATH . $relative_filename;
        // 调用生成海报函数
        $poster_url = createPoster($config, $filename);
        return $poster_url;
    }
    
}
