<?php
/* Lottery抽奖核心业务处理控制器
 * @Author: big黑钦
 * @Date: 2018-06-05 15:51:56
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-09 17:04:39
 */
namespace app\api\service;

use app\api\model\LotteryPrize as PrizeModel;
use app\api\model\LotteryRecord as RecordModel;

class Lottery
{
    // 依据算法返回中奖奖品索引
    public static function getIndex($sortArr)
    {
        $where = array(
            "act_id" => ["=", 1],
            "weight" => [">", 0],
        );
        $arr = PrizeModel::where($where)
            ->order('weight desc')
            ->select();
        $prize = self::get_rand($arr);
        $result = array(
            "id" => $prize['id'],
            "index" => array_search($prize['id'], $sortArr),
            "name" => $prize['name']
        );

        return $result;
    }

    // 抽奖人数
    public static function totalPeople()
    {
        $peopleCount = (new RecordModel())->count();
        return $peopleCount;
    }

    // 中奖概率
    public static function get_rand($proArr)
    {
        $result = array();
        foreach ($proArr as $key => $val) {
            $arr[$key] = $val['weight'];
        }
        $proSum = array_sum($arr); // 计算总权重
        $randNum = mt_rand(1, $proSum);
        $d1 = 0;
        $d2 = 0;
        for ($i = 0; $i < count($arr); $i++) {
            $d2 += $arr[$i];
            if ($i == 0) {
                $d1 = 0;
            } else {
                $d1 += $arr[$i - 1];
            }
            if ($randNum >= $d1 && $randNum <= $d2) {
                $result = $proArr[$i];
            }
        }
        unset($arr);
        return $result;
    }

    // 测试抽奖结果
    public static function test()
    {
        // 基数
        $num = 2000;
        $where = array(
            "act_id" => ["=", 1],
            "weight" => [">", 0],
        );
        $arr = PrizeModel::where($where)
            ->order('weight desc')
            ->select();

        $result = array();

        for ($i = 0; $i < $num; $i++) {
            $prize = self::get_rand($arr);
            if (array_key_exists($prize['name'], $result)) {
                $result[$prize['name']]['num'] = $result[$prize['name']]['num'] + 1;
            } else {
                $result[$prize['name']] = array(
                    "id" => $prize['id'],
                    "num" => 1,
                );
            }
            unset($prize);
        }
        return $result;
    }

    /**
     * 用户抽奖结果处理
     * @param   uid         会员uid
     * @param   data        入库更新数据
     * @param   sortArr     奖品摆放顺序，标识id
     * @var     user_id     会员uid
     * @var     prize_id    奖品id
     * @return  result      返回请求结果
     */
    public static function userPrizeInser($uid, $data, $sortArr)
    {
        // 返回奖品id、奖品索引index、奖品名称name
        $prize = self::getIndex($sortArr);

        /**
         * 保存抽奖结果，多表联查 where("user_id = $uid AND prize_id = NULL AND lottery_prize.id = $prize['id'] AND lottery_prize.balance != 0")
         * @var updata   更新数据返回结果，成功1，失败0
         * 
         */



        // 2018/6/9 备注，下步需要做：入库更新条件多表联查




        
        $updata = (new LotteryRecord())->save($data, [
            'user_id' => $uid,
            'prize_id' => null,
        ]);

        if (!$updata) {
            /**
             * 数据更新失败情形分析：
             * 1 已经参与抽奖
             * 2 消耗奖品库存已经没有了，返回【参与奖】
             */
            throw new Exception('数据更新失败');
        } else {
            $result = array(
                "statu" => $updata,
                "prizeIndex" => 2,
                "totalPeople" => $totalPeople,
            );
        }

        return $result;
    }
}
