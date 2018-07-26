<?php
/* CommonImages 活动图片资源表
 * @Author: big黑钦
 * @Date: 2018-06-04 13:44:19
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-06-16 11:19:08
 */
namespace app\admin\model;
use think\Model;

class CommonImages extends BaseModel
{

    /**
     * 活动图片资源入库
     * @param int       $act_id     活动id
     * @param int       $user_id  创建人id
     * @param string    $images_url 活动id
     * @param int       $url_type   图片资源类型，默认1,
     * @param int       $media_id   媒体id，非必填
     * @param string    $name       图片名称
     * @return array                返回一条新记录id
     */
    public static function insertCommonImages($act_id= 2, $user_id = 1, $images_url = '', $media_id = NULL, $url_type = 1, $name = NULL)
    {
        if(!$media_id){
            $media_expire_time = null;
        }else {
            // 临时素材媒体id 最大有效期3天
            $media_expire_time = time() + 259200;
        }
        $images = CommonImages::create([
            'act_id' => $act_id,
            'user_id' => $user_id,
            'name' => $name,
            'images_url' => $images_url,
            'url_type' => $url_type,
            'media_id' => $media_id,
            'media_expire_time' => $media_expire_time,
            'create_time' => time(),
        ]);
        
        return $images;
    }


    /**
     * 检查这条图片资源是否存在__通过 id
     * 存在返回uid，不存在返回0
     */
    public static function getById($id)
    {
        $images = CommonImages::where('id', '=', $id)->find();
        return $images;
    }

    /**
     * 检查这条图片资源是否存在__通过 user_id
     * 存在返回uid，不存在返回0
     */
    public static function getByUserId($uid)
    {
        $images = CommonImages::where('uid', '=', $uid)->find();
        return $images;
    }


}
