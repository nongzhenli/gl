<?php
/*
 * @Author: big黑钦
 * @Date: 2018-06-04 13:44:19
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-04 17:07:51
 */
namespace app\api\model;

use app\api\service\Token;
use app\api\service\Lottery;
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
        $uid = Token::getCurrentUid();
        $user = self::where('user_id', '=', $uid)
            ->find();
        return $user;
    }

    /**
     * 活动报名，更新信息
     * @param $data|Array 更新数据
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
     */
    public static function getPrizeIndex()
    {
        $uid = Token::getCurrentUid();
        $totalPeople = Lottery::getIndex();

        $data['prize_id'] = 2;
        $data['draw_time'] = time();

        $result = (new LotteryRecord())->save($data, [
            'user_id' => $uid,
            'prize_id' => NULL,
        ]);

        if (!$result) {
            throw new Exception('数据更新失败');
        } else {
            $result = array(
                "statu" => $result,
                "prizeIndex" => 2,
                "totalPeople" => $totalPeople
            );
        }

        return $result;
    }

}
