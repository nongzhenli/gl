<?php

namespace app\lib\exception;

use think\Exception;

class BaseException extends Exception
{
    /**
     * 此类定义了一些默认的返回结果
     */
    // http请求状态码 400, 200
    public $code = 400;
    // 错误具体信息
    public $msg = '错误信息';
    // 自定义错误码
    public $errorCode = 10000;

    // 构造函数
    public function __construct($params = [])
    {
        if (!is_array($params)) {

            /**
             * 情形分析：
             * 1. return 直接返回，不做任何处理 => 没又必要对返回信息进行变更处理
             * 2. throw.. 抛出异常信息 => 必须要求是数组信息
             */

            return;
            // throw new Exception('参数必须是数组');
        }

        // 判断数组中是否存在元素code
        if (array_key_exists('code', $params)) {
            $this->msg = $params['code'];
        }

        // 判断数组中是否存在元素msg
        if (array_key_exists('msg', $params)) {
            $this->msg = $params['msg'];
        }
        
        // 判断数组中是否存在元素errorCode
        if (array_key_exists('errorCode', $params)) {
            $this->msg = $params['errorCode'];
        }
    }
}
