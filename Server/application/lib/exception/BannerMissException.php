<?php
namespace app\lib\exception;

use app\lib\exception\BaseException;

class BannerMissException extends BaseException
{

    /** 
     * 错误编码自定义规划
     */
    
    public $code = 400;
    public $msg = '请求banner不存在';
    public $errorCode = 40000;

}
