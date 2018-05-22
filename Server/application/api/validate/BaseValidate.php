<?php

namespace app\api\validate;

use think\Request;
use think\Validate;
use app\lib\exception\ParameterException;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        // 1.获取http 传入的参数
        // 2.对这些参数进行检验
        $request = Request::instance(); // 拿到所有的http传来的参数
        $params = $request->param();

        // extends Validate 所有在 Validate里面，$this指向Validate本身
        $result = $this->batch()->check($params);
        if (!$result) {
            // 参数异常返回函数，并做 _construct构造函数变更返回信息（传参可选）
            $e = new ParameterException([
                'msg' => $this->error
            ]);
            // $e->msg = $this->error;  // 可直接对信息进行变更赋值，但是推荐使用构造函数进行变更
            throw $e;
            // var_dump($validate->getError());
            // 原理同上，只是因为是Validate中，所有提供了erroe属性获取报错信息
            // $error = $this->error;
            // tp5内置的异常抛出
            // throw new Exception($error);
        } else {
            return true;
        }
    }
}
