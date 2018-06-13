<?php
/*
 * @Author: big黑钦
 * @Date: 2018-05-23 09:16:28
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-09 16:27:35
 */
namespace app\api\controller\v1;

use app\api\model\LotteryPrize as PrizeModel;
use app\api\model\LotteryRecord as RecordModel;
use app\api\service\Lottery as LotteryService;

use think\Controller;
use think\Exception;

class Lottery extends Controller
{
    // 获取报名结果
    public function get()
    {
        $recordInfo = RecordModel::getRecordInfo();
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

        $data['custname'] = input('post.custname');
        $data['mobile'] = input('post.mobile');
        $data['sign_time'] = time();
        $data['status'] = 1; // 已报名

        $signInfo = RecordModel::signRecordInfo($data);
        if (!$signInfo) {
            throw new Exception('请求错误');
        } else {
            return $signInfo;
        }
    }

    // 返回抽奖结果，index索引
    public function getPrizeIndex()
    {
        // 奖品摆放顺序，id标识
        $sortArr = [1, 2, 3, 7, null, 4, 6, 1, 5];
        $prizeIndex = RecordModel::getPrizeIndex($sortArr);
        if (!$prizeIndex) {
            throw new Exception('请求错误');
        } else {
            return $prizeIndex;
        }
    }

    // 获取全部奖品数据
    public function getAllPrizeInfo()
    {
        // 奖品摆放顺序，id标识
        $sortArr = [1, 2, 3, 7, null, 4, 6, 1, 5];
        $prizeInfo = PrizeModel::getAllPrizeInfo($sortArr);

        if (!$prizeInfo) {
            throw new Exception('请求错误');
        } else {
            return $prizeInfo;
        }
    }


    // 测试抽奖结果
    public function test()
    {
        $prizeInfo = LotteryService::test();

        if (!$prizeInfo) {
            throw new Exception('请求错误');
        } else {
            return $prizeInfo;
        }
    }
}
