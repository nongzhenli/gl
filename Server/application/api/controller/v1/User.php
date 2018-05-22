<?php
namespace app\api\controller\v1;

use app\api\model\User as UserModel;

class User
{
    public function login()
    {
        // /**
        //  * 获取指定的banner信息
        //  * @url   /banner/:id
        //  * @http  GET
        //  * @id    banner的id号
        //  */

        // // 自定义验证规则，校验如果返回false，则此处被拦截，之后的代码都不被执行
        // (new IDMustBePostiveINT())->goCheck();
        // /**
        //  * 模型：（查询结果返回一个对象，而不是一个数组）
        //  * 1.默认{模型名}对照{数据库表名}进行了操作
        //  * 2.关联模型
        //  */
        // $banner = BannerModel::getBannerByID($id);
        // // $banner = BannerModel::get($id);
        // if(!$banner){
        //     throw new BannerMissException();
        //     // throw new Exception ('内部错误');
        // }
        // return json($banner);

        $token = UserModel::getToken();
        var_dump($token);

        $uname = input('post.uname');
        $upassword = input('post.upassword');

        var_dump($uname, $upassword);
    }
}
