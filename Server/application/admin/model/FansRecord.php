<?php
/* FansRecord 微信公众号吸粉活动
 * @Author: big黑钦
 * @Date: 2018-06-04 13:44:19
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-08-14 17:10:54
 */
namespace app\admin\model;
use think\Model;
use think\Exception;
use think\Db;
use app\admin\service\Excel as ExcelService;


// public 表示全局，类内部外部子类都可以访问；
// private 表示私有的，只有本类内部可以使用；
// protected 表示受保护的，只有本类或子类或父类中可以访问；

class FansRecord extends BaseModel
{

    /**
     * insertFansRecord() 微信公众号关注吸粉活动记录入库
     * @param int       $user_id        用户id
     * @param string    $open_id        用户openid
     * @param int       $status         状态，0取消关注、1已关注、2已完成、3已领取
     * @param int       $act_id         活动id
     * @param int       $poster_id      海报图id
     * @param int       $parent_id      推荐人id，没有默认0
     */
    public static function insertFansRecord($user_id, $open_id, $status = 1, $poster_id, $parent_id = 0, $act_id = 0)
    {
        // 判断是否存在
        $getFansResult =FansRecord::where([
            'user_id' =>  $user_id,
            'act_id' =>  $act_id,
            'poster_id' =>  $poster_id
        ])->find();
        if(!$getFansResult){
            $result_record = self::create([
                'user_id' => $user_id,
                'open_id' => $open_id,
                'status' => $status,
                'poster_id' => $poster_id,
                'parent_id' => $parent_id,
                'act_id' => $act_id,
                'last_follow_unfollow_time' => time(),
                'create_time' => time(),
            ]);
            return $result_record;
        }
        return false;
        
    }

    /**
     * 查询数据表导出Excel
     */
    public static function exportExcel($id, $xlsName="导出数据"){

        $xlsCell  = array(
            array('id','编号'),
            array('custname','姓名'),
            array('mobile','手机号码'),
            array('status','状态'),
            array('user_id','用户id'),
            array('parent_id','推荐人id'),
            // array('people','支持人数'),
            array('act_id','活动id'),
            array('poster_id','宣传海报id'),
            array('last_follow_unfollow_time','关注/取消时间'),
            array('complete_time','完成时间'),
            array('sign_time','填表时间'),
            array('get_time','领取时间'),
            array('create_time','创建记录时间'),
        );
        // $xlsData = Db::table('fans_record')->where('act_id',$id)
        //     ->field('id,custname,mobile,status,user_id,parent_id,act_id,poster_id,last_follow_unfollow_time,complete_time,sign_time,get_time,create_time')
        //     ->order("id DESC")
        //     ->chunk(100, function(){
        //     }, 'id')
        //     ->select();
        $xlsData = Db::table('fans_record')->chunk(100, function($data) {
            // 处理结果集...
            foreach ($data as $item) {
                var_dump($item);
            }
        });
        // foreach ($xlsData as $key => $value) {
        //     $xlsData[$key]['people'] = Db::table('fans_record')->where("parent_id", $value['user_id'])->count();
        //     $xlsData[$key]['last_follow_unfollow_time'] = timeFormat($value['last_follow_unfollow_time'], "Y-m-d H:i:s");
        //     $xlsData[$key]['complete_time'] = timeFormat($value['complete_time'], "Y-m-d H:i:s");
        //     $xlsData[$key]['sign_time'] = timeFormat($value['sign_time'], "Y-m-d H:i:s");
        //     $xlsData[$key]['get_time'] = timeFormat($value['get_time'], "Y-m-d H:i:s");
        //     $xlsData[$key]['create_time'] = timeFormat($value['create_time'], "Y-m-d H:i:s");
        // }

        // ExcelService::exportExcel($xlsName,$xlsCell,$xlsData);
    }

    /**
     * 检查这条图片资源是否存在__通过 id
     * 存在返回uid，不存在返回0
     */
    public static function getById($id)
    {
        $images = FansRecord::where('id', '=', $id)->find();
        return $images;
    }

    /**
     * 检查这条记录是否存在__通过 
     * 存在返回uid，不存在返回0
     * @param $uid      用户id
     * @param $act_id   所属活动id
     */
    public static function getByUserId($uid, $act_id)
    {
        $userInfo = FansRecord::where([
            'user_id' =>  $uid,
            'act_id' =>  $act_id
        ])->find();
        return $userInfo;
    }

    /**
     * 检查用户状态
     * @param int   $act_id    活动id
     */
    public static function getUserStatu($act_id){
        $uid = Token::getCurrentUid();
        $user = FansRecord::where([
            'user_id' => $uid,
            'act_id' => $act_id
        ])->field('open_id', true)->find();
        if(!$user){
            throw new Exception('用户不存在');
        }else {
            return $user;
        }
    }
}
