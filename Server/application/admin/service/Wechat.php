<?php
/* Wechat 微信公众号开发业务处理
 * @Author: big黑钦
 * @Date: 2018-06-05 15:51:56
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-07-30 17:33:32
 */
namespace app\admin\service;

use app\admin\model\CommonImages as CommonImagesModel;
use app\admin\model\Marketing as MarketingModel;
use app\admin\model\Wechat as WechatModel;
use app\api\model\FansRecord as FansRecordModel;
use app\api\model\User as UserModel;
use WechatSdk\Wechat as WechatSdk;
use think\Cache;

class Wechat extends BaseWechat
{

    /**
     * 获取公众号配置
     * @param   $wx_id   公众号id，非app_id
     */
    public static function get($wx_id)
    {
        if (!$wx_id) {
            throw new Exception('公众号开发信息不能为空！');
        }
        // 设置全局继承基础类变量$base_wx_id
        self::$base_wx_id = $wx_id;
        // 获取微信配置信息
        $wechatConfigArr = WechatModel::getWechat($wx_id);
        // 加密
        // $encrypt = self::passport_encrypt($wechatConfigArr['app_secret'], $wechatConfigArr['app_id']);
        // 解密
        $decrypt = self::passport_decrypt($wechatConfigArr['app_secret'], $wechatConfigArr['app_id']);
        // 重构返回数据
        $wechatConfigArr['app_secret'] = $decrypt;
        return $wechatConfigArr;
    }

    public static function set($wx_id)
    {
        if (!$wx_id) {
            throw new Exception('公众号开发信息不能为空！');
        }
        // 先获取公众号微信配置信息
        $config = self::get($wx_id);

        // 配置信息
        $options = array(
            'appid' => $config['app_id'],
            'appsecret' => $config['app_secret'],
            'token' => $config['token'],
            'encodingaeskey' => $config['encodingaeskey'],
        );
        $wxSDKObj = new WechatSdk($options);
        // token检验
        $wxSDKObj->valid();
        // 设置全局继承基础类变量$base_wxSDKObj
        self::$base_wxSDKObj = $wxSDKObj;
        // 当前微信号最新活动记录
        $wxNewMarketing = MarketingModel::getByWxId($wx_id);
        self::$base_act_id = $wxNewMarketing['id'];
        // 获取微信服务器返回类型
        $type = $wxSDKObj->getRev()->getRevType();
        // 获取用户openid
        $openid = $wxSDKObj->getRev()->getRevFrom();
        self::$openid = $openid; // 设置全局openid
        // 公众号规则处理
        switch ($type) {
            case WechatSdk::MSGTYPE_TEXT:
                self::handleTextMessage();
                break;
            case WechatSdk::MSGTYPE_EVENT:
                self::handleEventMessage($wxSDKObj);
                break;
            default:
                return true;
        }
    }

    // 事件推送集中处理方法
    public static function handleEventMessage($wxSDKObj)
    {
        $getRevEvent = self::$base_wxSDKObj->getRev()->getRevEvent();
        $event = $getRevEvent['event'];

        // 普通关注事件、未关注扫描带参数二维码事件
        if ($event == "subscribe") {
            // 防止微信响应三次，使用redis缓存设置key判断
            $wxFUName = self::$base_wxSDKObj->getRev()->getRevFrom();
            $wxCtime = self::$base_wxSDKObj->getRev()->getRevCtime();
            $hasWxFCKey = Cache::store('redis')->get($wxCtime.$wxFUName);
            if(!$hasWxFCKey) {
                // 不存在则设置并且继续执行代码
                Cache::store('redis')->set($wxCtime.$wxFUName, 1, 30);
            }else {
                // 存在则中断，防止微信服务响应三次
                return;
            }
            // ****************************共用区域*************************************
            // 发送客服消息，提醒作用
            $customArr = array(
                "touser" => self::$openid,
                "msgtype" => "text",
                "text" => array(
                    "content" => "感谢您对麦琪儿童摄影的支持！\n\n完成以下4步操作\n即可免费领走价值49元的智能酸奶机（限宝妈领取哟）\n--------\n第一步：点击保存二维码海报\n第二步：分享给10位好友进行扫码关注\n第三步：完成任务后【点击详情】提交联系方式\n第四步：耐心等待客服通知，即可来店领取\n--------\n海报生成中，请等待1-2秒\n\n快去邀请好友吧！全自动智能酸奶机等着你！\n\n感谢您对麦琪儿童摄影的支持！",
                ),
            );
            self::$base_wxSDKObj->sendCustomMessage($customArr);
            // 获取用户详细信息
            $wxUserInfoArr = self::$base_wxSDKObj->getUserInfo(self::$openid);
            $wxUserInfoJson = json_encode($wxUserInfoArr, JSON_UNESCAPED_UNICODE);
            /**
             * 验证用户表是否存在该用户
             * 1.如果存在，返回用户uid
             * 2.如果不存在，则新建用户并且返回uid
             */
            $user = UserModel::getByOpenID(self::$openid);
            if (!$user) {
                /**
                 * 创建新用户，并添加活动记录
                 * @param string    $wxUserInfoJson 微信用户信息
                 */
                $user = self::newUser($wxUserInfoJson);
                $uid = $user->id;
            } else {
                $uid = $user->id;
            }
            // ****************************共用区域 end**********************************
            // 判断该微信用户是否存在未关注记录（表示该用户曾经关注过此公众号）
            $fansRecor = FansRecordModel::getByUserId($uid, self::$base_act_id);
            // 如果存在记录，且字段parent_id大于0
            if ($fansRecor && $fansRecor['parent_id'] > 0) {
                $parent_id = $fansRecor['parent_id'];
            } else {
                // 如果不存在记录或字段parent_id等于0
                $parent_id = self::$base_wxSDKObj->getRevSceneId();
                if (!$parent_id) {
                    $parent_id = 0;
                }
            }
            // 自定义一个局部媒体id变量
            $media_id = "";
            if (!$fansRecor) {
                // *********** 1、生成二维码图片 *******************************
                // $uid; // 参数可以是推荐人id
                $type = 0; // 临时二维码
                $expire = 2592000; // 二维码有效期时长
                $getQRcodeInfo = self::getQRcodeInfo($uid, $type, $expire);
                // 海报背景图
                $posterBackground = PUBLIC_PATH . '/src/img/' . self::$base_act_id . '/poster_bg.jpg';
                // *********** 生成二维码图片 end *****************************
                // *********** 2、海报生成，并返回服务器保存地址 *******************************
                $config = array(
                    // 文字
                    'text' => array(
                        // 微信昵称
                        array(
                            'text' => $user['nickname'],
                            'left' => 360,
                            'top' => 56,
                            'fontPath' => APP_PATH . 'fonst/simkai.ttf', //字体文件
                            'fontSize' => 14, //字号
                            'fontColor' => '255,0,0', //字体颜色
                            'angle' => 0,
                        ),
                    ),
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
                        // // 微信头像
                        array(
                            'url' => $wxUserInfoArr['headimgurl'],
                            'left' => 300,
                            'top' => 20,
                            'right' => 0,
                            'stream' => 0,
                            'bottom' => 0,
                            'width' => 46,
                            'height' => 46,
                            'opacity' => 100,
                            'circ' => true,    // 暂时关闭圆形头像裁剪，因为时间太久，还没有找到解决排重的问题
                        ),
                    ),
                    'background' => $posterBackground,
                );
                // 海报相对路径（存放数据库，站点静态资源访问）
                $relative_filename = '/src/img/' . self::$base_act_id . '/qrcode/qrcode_' . self::$base_act_id . '_' . $uid . '.jpg';
                // 海报保存路径（绝对路径，用作上传媒体文件）
                $filename = PUBLIC_PATH . $relative_filename;
                // 调用生成海报函数
                $poster_url = createPoster($config, $filename);
                // *********** 海报生成，并返回服务器保存地址 end *******************************
                // *********** 4、上传临时素材 **************************************
                $data['media'] = '@' . $poster_url;
                $mediaInfo = self::$base_wxSDKObj->uploadMedia($data, "image");
                $media_id = $mediaInfo['media_id'];
                if ($media_id) {
                    /** 添加海报图片记录
                     * @param  int       $base_act_id 活动id
                     * @param  int       $uid               用户uid
                     * @param  string    $poster_url        海报URL绝对路径
                     * @param  string    $relative_filename 海报URL相对路径
                     * @param  int       $media_id          海报媒体id
                     * @return int                          返回记录id
                     */

                    $images_record = CommonImagesModel::insertCommonImages(self::$base_act_id, $uid, $relative_filename, $media_id);
                    self::$base_wxSDKObj->sendCustomMessage($customArr);
                    if (!$images_record) {
                        // TODO
                        // throw new Exception('推广海报图片资源入库失败');
                    } else {
                        // 新增记录
                        $status = 1; // 1已关注
                        $poster_id = $images_record->id;

                        $record = FansRecordModel::insertFansRecord($uid, self::$openid, $status = 1, $poster_id, $parent_id, self::$base_act_id);
                        if (!$record) {
                            // TODO
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
                                $mediaInfo = self::$base_wxSDKObj->uploadMedia($data, "image");

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
                            // TODO 此处应该做插入海报记录
                            // throw new Exception('找不到推广海报记录');
                        }
                    } else {
                        // throw new Exception('用户非首次关注发生异常');
                    }
                }
            }
            // 推送海报图片消息
            self::$base_wxSDKObj->image($media_id)->reply();

            // **************************** 推荐拉人模板消息 **********************************
            // 用户每次关注，都对上级推广人的数据进行统计、消息推送
            $where_count = 10; // 完成条件
            // 【情况分析：仅有在非首次关注且或扫同推荐人二维码进来，则出现$parent_id与记录user_id一样时，推荐人为0】
            // 必须推荐人uid不能等于0，不存在这个uid，默认官方
            if ($parent_id != 0) {
                $parent_count = FansRecordModel::where([
                    'parent_id' => $parent_id,
                    'act_id' => self::$base_act_id,
                ])->count();

                // 获取推荐人用户信息
                $parent_user = UserModel::getByUserID($parent_id);
            } elseif ($parent_id == 0) {
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
                    'act_id' => self::$base_act_id,
                    'user_id' => $parent_id,
                ]);
                // 跳转url
                $url = "http://gl.gxqqbaby.cn/#/action/aid/" . self::$base_act_id;
                // 消息模板id
                $template_id = "iU84hYFOKttuOevYhLNrRHqvd-dXOj1hwxZabhVRy5g";
                self::sendReachSupporterTel($template_id, $parent_user['openid'], $url, $complete_time);

            } elseif ($parent_count > 0) { // 好友助力通知
                // 消息模板id
                $template_id = "QSCm0WQRy-lWblVdEgEZlZAz4qSzlor3K3hzLpssNb4";
                self::sendSupporterTel($template_id, $user['nickname'], $parent_user['nickname'], $parent_user['openid'], $where_count - $parent_count);
            }
            // **************************** 推荐拉人模板消息 end ********************************

            return;
        }

        // 取消关注事件
        if ($event == "unsubscribe") {
            // 获取用户表记录
            $user = UserModel::getByOpenID(self::$openid);
            if ($user) {
                // 更新字段，取消关注状态
                $result = (new FansRecordModel())->save([
                    'status' => 0,
                    'last_follow_unfollow_time' => time(),
                ], [
                    'act_id' => self::$base_act_id,
                    'user_id' => $user->id,
                ]);
                return $result;
            }
            self::$base_wxSDKObj->text('用户取消关注')->reply();
            return;
        }

        // 已关注扫描带参数二维码事件【避免以关注，但是扫描二维码进入报错的问题】
        if ($event == "SCAN") {
            // TODO
            exit();
        }
    }
    // 文本消息推送集中处理方法
    public static function handleTextMessage()
    {
        self::$base_wxSDKObj->text("http://gl.gxqqbaby.cn/#/action/aid/" . self::$base_act_id)->reply();
    }

    /**
     * 自定义菜单
     * #只需要调用一次，应该单独作为事件调用
     */
    public static function createMenu($wx_id = 0)
    {
        if (!$wx_id) {
            throw new Exception('公众号开发信息不能为空！');
        }
        // 先获取公众号微信配置信息
        $config = self::get($wx_id);
        // 配置信息
        $options = array(
            'appid' => $config['app_id'],
            'appsecret' => $config['app_secret'],
            'token' => $config['token'],
            'encodingaeskey' => $config['encodingaeskey'],
        );
        $weObj = new WechatSdk($options);
        // 创建自定义菜单
        $data = array(
            "button" => array(
                0 => array(
                    "name" => "10秒询价",
                    "sub_button" => array(
                        0 => array(
                            "type" => "view",
                            "name" => "查询优惠报价",
                            "url" => "https://jinshuju.net/f/eBK12Q",
                        ),
                        1 => array(
                            "type" => "view",
                            "name" => "100元秒杀孕照",
                            "url" => "https://jinshuju.net/f/K555ow",
                        ),
                    ),
                ),
                1 => array(
                    "name" => "童模大赛",
                    "sub_button" => array(
                        0 => array(
                            "type" => "view",
                            "name" => "立即报名",
                            "url" => "http://modelbaby.xianyuan.net/phone/dist/module/homePage.html?id=162&empid=728",
                        ),
                    ),
                ),
                2 => array(
                    "name" => "关于我们",
                    "sub_button" => array(
                        0 => array(
                            "type" => "view",
                            "name" => "口碑见证",
                            "url" => "https://ludanmall.com/webApps/newMobile/dist/module/microPage.html?pageid=13292&shopId=1268&merchantId=1352",
                        ),
                        1 => array(
                            "type" => "view",
                            "name" => "品牌介绍",
                            "url" => "https://ludanmall.com/webApps/newMobile/dist/module/microPage.html?pageid=14001&shopId=1268&merchantId=1352",
                        ),
                    ),
                ),
            ),
        );
        $result = $weObj->createMenu($data);
        return $result;
    }
}
