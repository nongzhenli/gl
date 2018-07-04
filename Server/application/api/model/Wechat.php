<?php
namespace app\api\model;

use think\Db;
use think\Exception;
use think\Model;

// public 表示全局，类内部外部子类都可以访问；
// private 表示私有的，只有本类内部可以使用；
// protected 表示受保护的，只有本类或子类或父类中可以访问；
class Wechat extends BaseModel
{
    /**
     * 获取公众号信息
     * @param   $app_id 公众号开发者id
     */
    public static function getWechat($id = "")
    {
        $data = Db::table('wechat')->where("id", "=", $id)->find();
        if (!$data) {
            throw new Exception('查找不到该公众号配置');
        } else {
            return $data;
        }
    }
}
