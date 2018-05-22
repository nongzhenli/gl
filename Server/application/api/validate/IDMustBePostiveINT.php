<?php

namespace app\api\validate;

use app\api\validate\BaseValidate;

class IDMustBePostiveINT extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPostiveInteger',
        'num' => 'in:1,2,3'
    ];

    /**
     * 自定义验证规则
     * $value   被检验的值
     * $rule
     * $data    传输过来的$data
     * $field   检验的key
     */
    protected function isPostiveInteger($value, $rule = '', $data = '', $field = '')
    {
        /**
         * is_numeric   检测变量是否为数字或数字字符串
         * is_int       检测变量是否是整数，参数仅接收数字字面量。本例子中：($value + 0) 是为了转换成数字字面量
         */
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return $field . '必须是正整数';
        }
    }
}
