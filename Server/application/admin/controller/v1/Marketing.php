<?php
namespace app\admin\controller\v1;

use app\admin\model\Marketing as MarketingModel;
use app\admin\model\FansRecord as FansRecordModel;
use app\admin\service\Excel as ExcelService;

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
    public function getFansById($id, $p = 1)
    {
        $result = MarketingModel::getFansById($id, $p);
        $data = array(
            "code" => 20000,
            "data" => $result,
        );
        return $data;
    }

    /** 导出数据吸粉活动数据明细 【异步请求无法下载文件，只能通过跳转方式下载。所以前端windows.href形式跳转】
     * @param expTitle| String      文件标题
     * @param expCellName| Array    表格单元格标题
     * @param expTableData| Array   表格单元格内容
     */
    public function fansDataExcel($id = 0, $expTitle = "吸粉活动数据")
    {
        $result = FansRecordModel::exportExcel($id, $expTitle);
        $data = array(
            "code" => 20000,
            "statu" => $result,
            "id" => $id,
            "expTitle" => $expTitle,
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
