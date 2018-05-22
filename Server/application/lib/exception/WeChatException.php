<?php
/*
 * @Author: big黑钦
 * @Date: 2018-05-22 13:03:09
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-05-22 13:03:32
 */

namespace app\lib\exception;

use think\Exception;

/**
 * 微信服务器异常
 */
class WeChatException extends BaseException
{
    public $code = 400;
    public $msg = 'wechat unknown error';
    public $errorCode = 999;
}
