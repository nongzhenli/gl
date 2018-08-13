<?php
namespace app\admin\model;

use think\Db;
use think\Model;
use think\Paginator;

// public 表示全局，类内部外部子类都可以访问；
// private 表示私有的，只有本类内部可以使用；
// protected 表示受保护的，只有本类或子类或父类中可以访问；
class Marketing extends Model
{
    // const MARKETING_TYPE = array('0' => "报名抽奖", '1' => "公众号吸粉");
    /**
     * getList 获取营销活动列表
     * @param $type 营销类型
     */
    public static function getList()
    {
        $data = self::select();
        foreach ($data as $key => $value) {
            $count = Db::query("select count(*) as total from ( select act_id from fans_record  UNION ALL select act_id from lottery_record ) as A where act_id=".$value['id']);
            $value['total'] = $count[0]['total'];
            // $value['type'] = self::MARKETING_TYPE[$value['type']];
        }
        return $data;
    }

    /**
     * 公众号吸粉活动获取活动详情
     * 通过活动Id
     */
    public static function getFansById($id, $p)
    {
        // 每页显示数据
        $pageCount = 10;
        // DB::table()返回的是一个对象数据集，下面需要对数据重构，使用each()遍历每个元素（详情可查看thinkphp5【数据集】章节）
        $data = Db::table('fans_record')->where('act_id',$id)
            ->field('open_id', true)
            ->order("id DESC")
            ->paginate($pageCount, false, [
                "page" => $p
            ])->each(function($item, $key){
                $item['people'] = Db::table('fans_record')->where("parent_id", $item['user_id'])->count();
                return $item;
            });
        return $data;
    }
    /**
     * 公众号吸粉活动获取活动详情
     * 通过活动微信Id
     */
    public static function getByWxId($wx_id='0')
    {
        $data = Db::table('marketing')->where('source',$wx_id)->find();
        return $data;
    }

    /**
     * 抽奖活动获取活动详情
     */
    public static function getLotteryById($id)
    {
        $data = Db::table('lottery_record')->where('act_id',$id)->field('open_id', true)->select();
        return $data;
    }
}
