<?php
/* FansRecord 微信公众号吸粉活动
 * @Author: big黑钦
 * @Date: 2018-06-04 13:44:19
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-16 11:19:08
 */
namespace app\api\model;
use think\Model;

// public 表示全局，类内部外部子类都可以访问；
// private 表示私有的，只有本类内部可以使用；
// protected 表示受保护的，只有本类或子类或父类中可以访问；

class FansRecord extends BaseModel
{

    /**
     * 微信公众号关注吸粉活动记录入库
     * @param $user_id    |int      用户id
     * @param $open_id    |string   用户openid
     * @param $status     |int      状态，0取消关注、1已关注、2已完成、3已领取
     * @param $act_id     |int      活动id
     * @param $parent_id  |int      推荐人id，没有默认0
     */
    public static function insertFansRecord($user_id, $open_id, $status = 1, $act_id = 2, $parent_id = 0)
    {
        $result_record = self::create([
            'user_id' => $user_id,
            'open_id' => $open_id,
            'status' => $status,
            'parent_id' => $parent_id,
            'act_id' => $act_id,
            'last_follow_unfollow_time' => time(),
            'create_time' => time(),
        ]);
        return $result_record;
    }

}
