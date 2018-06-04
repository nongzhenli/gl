<?php
/*
 * @Author: big黑钦
 * @Date: 2018-05-23 09:16:28
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-04 17:09:24
 */
namespace app\api\controller\v1;

use app\api\model\LotteryRecord as LotteryModel;
use think\Controller;
use think\Request;

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
}
