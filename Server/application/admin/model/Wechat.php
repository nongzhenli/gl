<?php
namespace app\admin\model;

use app\admin\model\BaseWechat;
use think\Db;
use think\Model;

// public 表示全局，类内部外部子类都可以访问；
// private 表示私有的，只有本类内部可以使用；
// protected 表示受保护的，只有本类或子类或父类中可以访问；
class Wechat extends BaseWechat
{
    /**
     * getList 获取公众号列表
     */
    public static function getList()
    {
        $data = self::field('app_secret', true)->select();
        return $data;
    }

    /**
     * getList 获取公众号详情
     */
    public static function getDetail($id)
    {
        $data = self::where('id', $id)->field('app_secret', true)->find();
        return $data;
    }

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

    /**
     * getWechatSmartRule 获取公众号关键字回复规则
     * @param   $app_id 公众号开发者id
     */
    public static function getWechatSmartRule($wx_id = "")
    {
            
        $rule_keywords = Db::view('wechat_rule', ['id'=>'rule_id'])
            ->view('wechat_keywords', 'id,key_name, key_type', 'wechat_keywords.rule_id=wechat_rule.id')
            ->where('wechat_rule.wx_id', '=', $wx_id)
            // ->field('rule_id', true)
            ->select();
        $rule_replys = Db::view('wechat_rule', ['id'=>'rule_id'])
            ->view('wechat_replys', 'id,send_type,json_str', 'wechat_replys.rule_id=wechat_rule.id')
            ->where('wx_id', '=', $wx_id)
            ->select();
        $rule_find = Db('wechat_rule')->where('wx_id', '=', $wx_id)->field('last_time, delete_time, create_by', true)->find();
        // var_dump($rule_find);
        // exit();

        $data = array(
            "id" => $rule_find['id'],
            "name" => $rule_find['name'],
            "wx_id" => $rule_find['wx_id'],
            "type" => $rule_find['type'],
            "keywords" => $rule_keywords,
            "send_content" => $rule_replys,
            "create_time" => $rule_find['create_time'],
        );
        return $data;
    }

}
