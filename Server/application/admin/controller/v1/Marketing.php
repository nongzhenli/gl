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
        return $data;
    }

    /**
     * 获取指定的marketing信息
     * @param id    marketing的id号
     * @http        GET
     * @type        Fans 公众号吸粉活动
     */
    public function getFansById($id, $p=1)
    {
        $result = MarketingModel::getFansById($id, $p);
        $data = array(
            "code" => 20000,
            "data" => $result
        );
        return $data;
    }

    /**
     * 获取指定的marketing信息
     * @param id    marketing的id号
     * @http        GET
     * @type        Lottery 抽奖活动
     */
    public function getLotteryById($id)
    {
        $result = MarketingModel::getLotteryById($id);
        $data = array(
            "code" => 20000,
            "data" => array(
                "items" => $result,
            ),
        );
        return $data;
    }
}
