<?php
/* Lottery抽奖算法业务处理控制器
 * @Author: big黑钦
 * @Date: 2018-06-05 15:51:56
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-05 15:56:00
 */
namespace app\api\service;

use app\api\model\LotteryRecord as RecordModel;

class Lottery
{
    // 依据算法返回中奖奖品索引
    public static function getIndex()
    {
        $arr = array(   
            array('id'=>1,'name'=>'特等奖','v'=>1),
            array('id'=>2,'name'=>'一等奖','v'=>5),
            array('id'=>3,'name'=>'二等奖','v'=>10),
            array('id'=>4,'name'=>'三等奖','v'=>12),
            array('id'=>5,'name'=>'四等奖','v'=>22),
            array('id'=>6,'name'=>'没中奖','v'=>40)
        ); 
        return self::get_rand($arr);

        // return self::totalPeople();
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
            $arr[$key] = $val['v'];
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
}
