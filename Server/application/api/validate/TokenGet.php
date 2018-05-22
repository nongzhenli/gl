<?php
namespace app\api\validate;

use app\api\validate\BaseValidate;

/*
 * @Author: big黑钦
 * @Date: 2018-05-22 11:19:52
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-05-22 16:12:58
 */
class TokenGet extends BaseValidate
{

    protected $rule = [
        'code' => 'require|isNotEmpty',
    ];

    protected $message = [
        'code' => 'code错误',
    ];
}
