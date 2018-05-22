<?php

namespace app\sample\controller;

use think\Request;
class Test
{
    public function hello(){
        /* 获取url参数的三种方式：
         1.Request::instance()
         2.方法名(Request $request)    => $request->param()
         3.input('param.')
         */

        // 1、获取URL指定参数
        // $id = Request::instance()->get('id');
        // $name = Request::instance()->get('name');
        // $age = Request::instance()->get('age');

        // echo "id：".$id;
        // echo "<br>";
        // echo "name：".$name;
        // echo "<br>";
        // echo "age：".$age;

        // 默认返回所有参数
        // $url_arry = Request::instance()->param();
        /* 
         Request::instance()->get() 默然获取url?后所有的参数，例如：hello/123?name=big&age=18 => name、age
         Request::instance()->route() 获取第一个键值，例如：hello/123?name=big&age=18 => 123
         
         ++++++++++++++++++++++
         + post 同理..
         + param 表示所有请求
         ++++++++++++++++++++++
         */

        // 2、助手函数
        $url_arry = input('get.');
        /* 
         input('param.')    默认获取所有请求参数，不区分类型，同Request::instance()->param()
         input('get.')      默认获取所有ger请求参数，同Request::instance()->get()
         input('post.')     同上...

         input('param.id')  不区分请求类型，获取所有参数id值  
         */

        print_r($url_arry);
        
    }
    
}
