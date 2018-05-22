<?php
namespace app\lib\exception;

use app\lib\exception\BaseException;
use think\Config;
use think\Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandle extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    
    // *使用php内置基类\Exception，解决api路径错误返回的不规则异常信息
    public function render(\Exception $ex)
    {
        /**
         * 两种异常的错误处理
         */
        if ($ex instanceof BaseException) {
            // 如果是自定义的异常
            $this->code = $ex->code;
            $this->msg = $ex->msg;
            $this->errorCode = $ex->errorCode;
        } else {
            // 通过读取config文件中是否开启调试模式的布置值，去做返回错误信息默认页面的开关
            $switch = Config::get('app_debug');
            if ($switch) {
                // tp5默认返回默认异常信息页面
                return parent::render($ex);
            } else {
                $this->code = 500;
                $this->msg = "服务器内部错误";
                $this->errorCode = 999;
                // 日志写入
                $this->recordErrorLog($ex);
            }

        }
        $request = Request::instance();
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'result_url' => $request->url(),
        ];
        return json($result, $this->code);
    }

    private function recordErrorLog(\Exception $ex)
    {
        // 初始化日志
        Log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error'],
        ]);

        Log::record($ex->getMessage(), 'error');
    }

}
