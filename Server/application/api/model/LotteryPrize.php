<?php
/* LotteryPrize 抽奖奖品数据控制器
 * @Author: big黑钦
 * @Date: 2018-06-04 13:44:19
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-09 16:24:43
 */
namespace app\api\model;

use think\Model;

// public 表示全局，类内部外部子类都可以访问；
// private 表示私有的，只有本类内部可以使用；
// protected 表示受保护的，只有本类或子类或父类中可以访问；

class LotteryPrize extends BaseModel
{

    /**
     * 将数据库中查出的列表以指定的 id 作为数组的键名
     * @param $arr
     * @param $key_name
     * @return array
     */
    public static function convert_arr_key($arr, $key_name)
    {
        $result = array();
        foreach ($arr as $key => $val) {
            $result[$val[$key_name]] = $val;
        }
        return $result;
    }

    /**
     * 获取奖品数据，并进行重构排序
     * 重构排序 [id,...]
     * @param  $db_prizeInfo    源奖品数据，抽离id键值数组
     * @param  $prizeInfo       重新构造的数组数据
     * @param  $sortArr         奖品摆放顺序
     * @param  $roll            抽奖滚动顺序
     * @return $result
     */
    public static function getAllPrizeInfo($sortArr)
    {
        // 查询数据，并返回指定键名值[id]
        $db_prizeInfo = self::where('act_id', '=', 1)->select();
        $db_prizeInfo = self::convert_arr_key($db_prizeInfo, 'id');

        $roll = [0, 1, 2, 5, 8, 7, 6, 3];
        $prizeInfo = array();

        // 循环重构
        foreach ($sortArr as $key => $value) {
            $data = $value ? $db_prizeInfo[$value] : null;
            $prizeInfo[$key] = $data;
        }

        $result = array(
            "prizeInfo" => $prizeInfo,
            "sort" => $sortArr,
            "roll" => $roll,
        );
        return $result;
    }

}
