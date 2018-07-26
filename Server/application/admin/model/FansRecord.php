<?php
/* FansRecord 微信公众号吸粉活动
 * @Author: big黑钦
 * @Date: 2018-06-04 13:44:19
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-21 15:27:44
 */
namespace app\admin\model;
use think\Model;
use think\Exception;


// public 表示全局，类内部外部子类都可以访问；
// private 表示私有的，只有本类内部可以使用；
// protected 表示受保护的，只有本类或子类或父类中可以访问；

class FansRecord extends BaseModel
{

    /**
     * insertFansRecord() 微信公众号关注吸粉活动记录入库
     * @param int       $user_id        用户id
     * @param string    $open_id        用户openid
     * @param int       $status         状态，0取消关注、1已关注、2已完成、3已领取
     * @param int       $act_id         活动id
     * @param int       $poster_id      海报图id
     * @param int       $parent_id      推荐人id，没有默认0
     */
    public static function insertFansRecord($user_id, $open_id, $status = 1, $poster_id, $parent_id = 0, $act_id = 2)
    {
        $result_record = self::create([
            'user_id' => $user_id,
            'open_id' => $open_id,
            'status' => $status,
            'poster_id' => $poster_id,
            'parent_id' => $parent_id,
            'act_id' => $act_id,
            'last_follow_unfollow_time' => time(),
            'create_time' => time(),
        ]);
        return $result_record;
    }

    /**
     * 检查这条图片资源是否存在__通过 id
     * 存在返回uid，不存在返回0
     */
    public static function getById($id)
    {
        $images = FansRecord::where('id', '=', $id)->find();
        return $images;
    }

    /**
     * 检查这条图片资源是否存在__通过 user_id
     * 存在返回uid，不存在返回0
     */
    public static function getByUserId($uid)
    {
        $images = FansRecord::where('user_id', '=', $uid)->find();
        return $images;
    }

    /**
     * 检查用户状态
     * @param int   $act_id    活动id
     */
    public static function getUserStatu($act_id){
        $uid = Token::getCurrentUid();
        $user = FansRecord::where([
            'user_id' => $uid,
            'act_id' => $act_id
        ])->field('open_id', true)->find();
        if(!$user){
            throw new Exception('用户不存在');
        }else {
            return $user;
        }
    }
}
