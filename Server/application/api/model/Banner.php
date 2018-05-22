<?php
namespace app\api\model;

use think\Db;
use think\Model;

// public 表示全局，类内部外部子类都可以访问；
// private 表示私有的，只有本类内部可以使用；
// protected 表示受保护的，只有本类或子类或父类中可以访问；

// 继承Model模型的控制器Banner，本身已经成为一个Model模型，更针对性的处理业务逻辑
class Banner extends Model
{
    // 关联模型，可更改默认对照数据库表，此时这个模型sql查询了banner_item表
    protected $table = "banner_item";
    public static function getBannerByID($id)
    {
        /** 知识点：
         * 1.链式查询方法：表达式法、数组法【不建议】、闭包法
         * 2.sql查询语句应该被记录到日志中，在全局中调用（index.js入口文件）
         * 3.ORM 对象映射关系：面向对象编程思路，将数据表看做成{对象}进行操作
         * 4.模型：（业务功能逻辑）
         *
         */
        // $result = Db::table('banner_item')->where('banner_id', '=', $id)->select();
        // ->fetchSql()  链式条件只会返回sql查询语句，并不会执行查询

        // 闭包法
        $result = Db::table('banner_item')
            ->where(function ($query) use ($id) {
                $query->where('banner_id', '=', $id);
            })
            ->select();

        return $result;
    }
}
