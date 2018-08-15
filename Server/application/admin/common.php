<?php

use Picture\Picture as PictureSDK;

/**
 * @param string $url post请求地址
 * @param array $params
 * @return mixed
 */
function curl_post($url, array $params = array())
{
    $data_string = json_encode($params);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt(
        $ch, CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json'
        )
    );
    $data = curl_exec($ch);
    curl_close($ch);
    return ($data);
}

function curl_post_raw($url, $rawData)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $rawData);
    curl_setopt(
        $ch, CURLOPT_HTTPHEADER,
        array(
            'Content-Type: text'
        )
    );
    $data = curl_exec($ch);
    curl_close($ch);
    return ($data);
}

/**
 * @param string $url get请求地址
 * @param int $httpCode 返回状态码
 * @return mixed
 */
function curl_get($url, &$httpCode = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //不做证书校验,部署在linux环境下请改为true
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $file_contents = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $file_contents;
}

/**
 * 加密
 */
function passport_encrypt($txt, $key = 'www.glagbn.com')
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

/**
 * 解密
 */
function passport_decrypt($txt, $key = 'www.glagbn.com')
{
    $txt = self::passport_key(base64_decode(urldecode($txt)), $key);
    $tmp = '';
    for ($i = 0; $i < strlen($txt); $i++) {
        $md5 = $txt[$i];
        $tmp .= $txt[++$i] ^ $md5;
    }
    return $tmp;
}

function passport_key($txt, $encrypt_key)
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

/**
 * 生成宣传海报
 * @param array  参数,包括图片和文字
 * @param string  $filename 生成海报文件名,不传此参数则不生成文件,直接输出图片
 * @return [type] [description]
 */
function createPoster($config = array(), $filename = "")
{
    // 如果要看报什么错，可以先注释调这个header
    if (empty($filename)) {
        header('Content-Type:image/jpg');
    }

    $imageDefault = array(
        'start_x' => 0,
        'start_y' => 0,
        'width' => 100,
        'height' => 100,
        'circ' => false
    );
    $textDefault = array(
        'str' => '',
        'x' => 0,
        'y' => 0,
        'fontSize' => 14, //字号
        'fontColor' => '51,51,51', //字体颜色
        'angle' => 0,
    );
    $background = $config['background']; //海报最底层得背景
    
    // 初始化
    $imageRes = new PictureSDK($background);
    // 合成图片
    $imageRes->combineImg($config['image']);
    // 合成文字
    $imageRes->createString($config['text']);

    //生成图片
    if (!empty($filename)) {
        $result = $imageRes->save($filename, 'jpg', 90);  // 保存到本地
        if (!$result) {
            return false;
        }
        return $filename;
    } else {
        // 直接输出显示
        $imageRes->show();
        exit();
    }
}

/**
 * 时间格式化
 * @param time      时间戳
 * @param format    转换格式
 */
function timeFormat($time, $format="Y-m-d H:i:s"){
    if(!empty($time)){
        return date($format, $time);
    }
    return $time;
}