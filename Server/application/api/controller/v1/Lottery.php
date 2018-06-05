<?php
/*
 * @Author: big黑钦
 * @Date: 2018-05-23 09:16:28
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-05 17:30:14
 */
namespace app\api\controller\v1;

use app\api\model\LotteryRecord as LotteryModel;
use app\api\model\LotteryPrize as PrizeModel;

use think\Controller;

class Lottery extends Controller
{
    // 获取报名结果
    public function get()
    {
        $recordInfo = LotteryModel::getRecordInfo();
        if (!$recordInfo) {
            throw new Exception('请求错误');
        } else {
            return $recordInfo;
        }
    }

    // 提交报名，更新信息
    public function sign()
    {
        // 拿到所有的http传来的参数
        // $request = Request::instance(); // 拿到所有的http传来的参数
        // $params = $request->param();
        // var_dump($params);
        // exit();

        $data['act_id'] = input('post.act_id');
        $data['sign_time'] = time();
        $data['status'] = 1; // 已报名

        $signInfo = LotteryModel::signRecordInfo($data);
        if (!$signInfo) {
            throw new Exception('请求错误');
        } else {
            return $signInfo;
        }
    }

    // 返回抽奖结果，index索引
    public function getPrizeIndex()
    {
        $prizeIndex = LotteryModel::getPrizeIndex();
        if (!$prizeIndex) {
            throw new Exception('请求错误');
        } else {
            return $prizeIndex;
        }
    }

    // 获取奖品数据
    public function getAllPrizeInfo()
    {
        $prizeInfo = PrizeModel::getAllPrizeInfo();

        if (!$prizeInfo) {
            throw new Exception('请求错误');
        } else {
            return $prizeInfo;
        }
    }
}
