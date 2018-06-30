<?php
namespace app\admin\model;

use think\Model;

// public 表示全局，类内部外部子类都可以访问；
// private 表示私有的，只有本类内部可以使用；
// protected 表示受保护的，只有本类或子类或父类中可以访问；
class Marketing extends Model
{
    /**
     * getMarketingList 获取营销活动列表
     * @param $type 营销类型
     */
    public static function getMarketingList($type = '')
    {
        
    }
}
