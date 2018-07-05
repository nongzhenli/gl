<?php
namespace app\admin\controller\v1;

use app\admin\model\Marketing as MarketingModel;

class Marketing
{
    // 获取营销活动列表
    public function getList()
    {
        $result = MarketingModel::getList();
        $data = array(
            "code" => 20000,
            "data" => array(
                "items" => $result,
            ),
        );
        return $result;
        // $data = array(
        //     "code" => 20000,
        //     "data" => array(
        //         "items" => array(
        //             array(
        //                 "id" => "1",
        //                 "name" => "桂林九宫格抽奖活动",
        //                 "type" => "报名抽奖",
        //                 "page_url" => "lottery",
        //                 "status" => 0,
        //                 "pageviews" => 786,
        //                 "sigin_num" => 1232,
        //                 "pay_num" => 890,
        //                 "pay_total" => 158715.00,
        //                 "author" => "cc",
        //                 "start_time" => "2018-04-13 21:14",
        //                 "end_time" => "2018-04-13 21:14",
        //                 "create_time" => "2018-04-13 21:14",
        //             ),
        //             array(
        //                 "id" => "2",
        //                 "name" => "桂林安格贝妮公众号吸粉",
        //                 "type" => "公众号吸粉",
        //                 "page_url" => "fans",
        //                 "status" => 1,
        //                 "sigin_num" => 147815,
        //                 "pay_num" => 0,
        //                 "pay_total" => 0,
        //                 "author" => "cc",
        //                 "start_time" => "2018-04-13 21:14",
        //                 "end_time" => "2018-04-13 21:14",
        //                 "create_time" => "2018-04-13 21:14",
        //             ),
        //         ),
        //     ),
        // );
        // return json($data);
    }

    /**
     * 获取指定的marketing信息
     * @param id    marketing的id号
     * @http        GET
     */
    public function getById($id)
    {
        return $id;
    }
}
