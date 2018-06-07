<?php
/* LotteryPrize 抽奖奖品数据控制器
 * @Author: big黑钦
 * @Date: 2018-06-04 13:44:19
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-05 17:32:56
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

    public static function getAllPrizeInfo()
    {
        $db_prizeInfo = self::where('act_id', '=', 1)->select();
        $db_prizeInfo = self::convert_arr_key($db_prizeInfo, 'id');

        /**
         * 重构排序 [id,...]
         * [1, 2, 3, 7, btn, 4, 6, 1, 5]
         * @param  $db_prizeInfo    源奖品数据
         * @param  $prizeInfo       重新构造的数组数据
         * @param  $sortArr         排序规则
         * @return $result
         */
        $sortArr = [1, 2, 3, 7, null, 4, 6, 1, 5];
        $prizeInfo = array();

        // 循环重构
        foreach ($sortArr as $key => $value) {
            $data = $value ? $db_prizeInfo[$value] : null;
            $prizeInfo[$key] = $data;
        }

        $result = array(
            "prizeInfo" => $prizeInfo,
            "sort" => $sortArr,
            "roll" => [0, 1, 2, 5, 8, 7, 6, 3],
        );
        return $result;
    }
}
