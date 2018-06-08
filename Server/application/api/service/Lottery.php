<?php
/* Lottery抽奖算法业务处理控制器
 * @Author: big黑钦
 * @Date: 2018-06-05 15:51:56
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-05 15:56:00
 */
namespace app\api\service;

use app\api\model\LotteryPrize as PrizeModel;
use app\api\model\LotteryRecord as RecordModel;

class Lottery
{
    // 依据算法返回中奖奖品索引
    public static function getIndex()
    {
        $where = array(
            "act_id" => ["=", 1],
            "weight" => [">", 0]
        );
        $arr = PrizeModel::where($where)
                ->order('weight desc')
                ->select();

        return self::get_rand($arr);
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
            "weight" => [">", 0]
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
}
