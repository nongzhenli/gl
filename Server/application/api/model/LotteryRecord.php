<?php
/* LotteryRecord抽奖参与报名控制器
 * @Author: big黑钦
 * @Date: 2018-06-04 13:44:19
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-11 15:19:18
 */
namespace app\api\model;

use app\api\service\Lottery;
use app\api\service\Token;
use think\Exception;
use think\Model;

// public 表示全局，类内部外部子类都可以访问；
// private 表示私有的，只有本类内部可以使用；
// protected 表示受保护的，只有本类或子类或父类中可以访问；

class LotteryRecord extends BaseModel
{

    /**
     * 微信授权后uid报名入库
     */
    public static function insertWxRecord($user_id, $open_id)
    {
        $result_record = self::create([
            'user_id' => $user_id,
            'open_id' => $open_id,
            'act_id' => 1,
            'create_time' => time(),
        ]);
        return $result_record;
    }

    /**
     * 获取用户信息
     */
    public static function getRecordInfo()
    {
        // 奖品摆放顺序，id标识
        $sortArr = [1, 2, 3, 7, null, 4, 6, 1, 5];
        
        $uid = Token::getCurrentUid();
        $user = self::where('user_id', '=', $uid)->find();
        
        // 奖品索引位置
        $user['prize_index'] = null;
        if($user['prize_id']){
            $user['prize_index'] = array_search($user['prize_id'], $sortArr);
        }

        return $user;
    }

    /**
     * 活动报名，更新信息
     * @param data|Array 更新数据
     */
    public static function signRecordInfo($data)
    {
        $uid = Token::getCurrentUid();

        $record = new LotteryRecord;
        $record->save($data, ['user_id' => $uid]);

        return $record;
    }

    /**
     * 抽奖结果返回奖品位置索引
     * @param sortArr   奖品摆放顺序，标识id
     */
    public static function getPrizeIndex($sortArr)
    {
        $uid = Token::getCurrentUid();
        $result = Lottery::userPrizeInser($uid, $sortArr);

        // $result = array(
        //     "statu" => 1,
        //     "prizeIndex" => 2,
        //     "totalPeople" => $totalPeople,
        // );

        return $result;
    }

}
