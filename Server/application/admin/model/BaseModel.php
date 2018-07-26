<?php
/*
 * @Author: big黑钦
 * @Date: 2018-05-22 12:02:38
 * @Last Modified by:   big黑钦
 * @Last Modified time: 2018-05-22 12:02:38
 */
namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class BaseModel extends Model
{
    // 软删除，设置后在查询时要特别注意whereOr
    // 使用whereOr会将设置了软删除的记录也查询出来
    // 可以对比下SQL语句，看看whereOr的SQL
    use SoftDelete;

    protected $hidden = ['delete_time'];

    protected function prefixImgUrl($value, $data)
    {
        $finalUrl = $value;
        if ($data['from'] == 1) {
            $finalUrl = config('setting.img_prefix') . $value;
        }
        return $finalUrl;
    }
}
