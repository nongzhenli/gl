<?php
/* LotteryPrize 抽奖奖品数据控制器
 * @Author: big黑钦
 * @Date: 2018-06-04 13:44:19
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-05 17:32:56
 */
namespace app\api\model;

use app\api\service\Token;
use think\Model;

// public 表示全局，类内部外部子类都可以访问；
// private 表示私有的，只有本类内部可以使用；
// protected 表示受保护的，只有本类或子类或父类中可以访问；

class LotteryPrize extends BaseModel
{
    public static function getAllPrizeInfo(){
        $prizeInfo = LotteryPrize::where('act_id', '=', 1)
            ->select();
        return $prizeInfo;
    }
}
