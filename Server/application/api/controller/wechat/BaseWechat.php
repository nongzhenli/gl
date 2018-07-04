<?php
/*
 * @Author: big黑钦
 * @Date: 2018-05-22 12:02:38
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-07-04 16:50:19
 */
namespace app\api\controller\wechat;

class BaseWechat
{
    public static function passport_encrypt($txt, $key = 'www.glagbn.com')
    {
        srand((double) microtime() * 1000000);
        $encrypt_key = md5(rand(0, 32000));
        $ctr = 0;
        $tmp = '';
        for ($i = 0; $i < strlen($txt); $i++) {
            $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
            $tmp .= $encrypt_key[$ctr] . ($txt[$i] ^ $encrypt_key[$ctr++]);
        }
        return urlencode(base64_encode(self::passport_key($tmp, $key)));
    }

    public static function passport_decrypt($txt, $key = 'www.glagbn.com')
    {
        $txt = self::passport_key(base64_decode(urldecode($txt)), $key);
        $tmp = '';
        for ($i = 0; $i < strlen($txt); $i++) {
            $md5 = $txt[$i];
            $tmp .= $txt[++$i] ^ $md5;
        }
        return $tmp;
    }

    public static function passport_key($txt, $encrypt_key)
    {
        $encrypt_key = md5($encrypt_key);
        $ctr = 0;
        $tmp = '';
        for ($i = 0; $i < strlen($txt); $i++) {
            $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
            $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
        }
        return $tmp;
    }
}
