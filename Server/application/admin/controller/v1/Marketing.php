<?php
namespace app\admin\controller\v1;

use app\admin\model\Marketing as MarketingModel;

class Marketing
{
    // 获取营销活动列表
    public function getList()
    {
        $marketingList = MarketingModel::select();
        return $marketingList;
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
