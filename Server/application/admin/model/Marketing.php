<?php
namespace app\admin\model;

use think\Db;
use think\Model;

// public 表示全局，类内部外部子类都可以访问；
// private 表示私有的，只有本类内部可以使用；
// protected 表示受保护的，只有本类或子类或父类中可以访问；
class Marketing extends Model
{
    const MARKETING_TYPE = array('0' => "报名抽奖", '1' => "公众号吸粉");
    /**
     * getList 获取营销活动列表
     * @param $type 营销类型
     */
    public static function getList()
    {
        $data = self::select();
        foreach ($data as $key => $value) {

            // Db::view('User', 'id,name')
            //     ->view('Profile', 'truename,phone,email', 'Profile.user_id=User.id')
            //     ->view('Score', 'score', 'Score.user_id=Profile.id')
            //     ->where('score', '>', 80)
            //     ->select();

            $value['type'] = self::MARKETING_TYPE[$value['type']];
        }
        return $data;
    }
}
