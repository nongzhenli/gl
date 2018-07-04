<?php
namespace app\admin\controller\v1;

use app\admin\model\Marketing as MarketingModel;

class Marketing
{
    // 获取营销活动列表
    public function getList()
    {
        $data = array(
            "code"=> 20000,
            "data" => array(
                "items" => array(
                    array(
                        "id" => "1",
                        "name" => "桂林九宫格抽奖活动",
                        "type" => "报名抽奖",
                        "status" => 0,
                        "pageviews" => 786,
                        "sigin_num" => 1232,
                        "pay_num" => 890,
                        "pay_total" => 158715.00,
                        "author" => "cc",
                        "start_time" => "2018-04-13 21:14",
                        "end_time" => "2018-04-13 21:14",
                        "create_time" => "2018-04-13 21:14"
                    ),
                    array(
                        "id" => "2",
                        "name" => "桂林安格贝妮公众号吸粉",
                        "type" => "公众号吸粉",
                        "status" => 1,
                        "sigin_num" => 147815,
                        "pay_num" => 0,
                        "pay_total" => 0,
                        "author" => "cc",
                        "start_time" => "2018-04-13 21:14",
                        "end_time" => "2018-04-13 21:14",
                        "create_time" => "2018-04-13 21:14"
                    )
                )
            )
        );
        return json($data);
        // $marketingList = MarketingModel::select();
        // return $marketingList;
    }

    /**
     * 获取指定的marketing信息
     * @param id    marketing的id号
     * @url         /banner/:id
     * @http        GET
     */
    public function marketing($id)
    {
        // 自定义验证规则，校验如果返回false，则此处被拦截，之后的代码都不被执行
        (new IDMustBePostiveINT())->goCheck();
        /**
         * 模型：（查询结果返回一个对象，而不是一个数组）
         * 1.默认{模型名}对照{数据库表名}进行了操作
         * 2.关联模型
         */
        $banner = BannerModel::getBannerByID($id);
        // $banner = BannerModel::get($id);
        if (!$banner) {
            throw new BannerMissException();
            // throw new Exception ('内部错误');
        }
        return json($banner);

    }
}
