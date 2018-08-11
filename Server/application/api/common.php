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
            'Content-Type: application/json',
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
            'Content-Type: text',
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

function getRandChar($length)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) - 1;

    for ($i = 0;
        $i < $length;
        $i++) {
        $str .= $strPol[rand(0, $max)];
    }

    return $str;
}

function fromArrayToModel($m, $array)
{
    foreach ($array as $key => $value) {
        $m[$key] = $value;
    }
    return $m;
}

/**
 * 生成宣传海报
 * @param array  参数,包括图片和文字
 * @param string  $filename 生成海报文件名,不传此参数则不生成文件,直接输出图片
 * @return [type] [description]
 */
function createPoster($config = array(), $filename = '')
{
    // 如果要看报什么错，可以先注释调这个header
    if (empty($filename)) {
        header('Content-Type:image/jpg');
    }
    $background = $config['background']; //海报最底层得背景
    // 初始化
    $imageRes = new PictureSDK($background);
    // 合成图片
    $imageRes->combineImg($config['image']);
    // 合成文字
    $imageRes->createString($config['text']);

    //生成图片
    if (!empty($filename)) {
        $result = $imageRes->save($filename, 'jpg', 75); // 保存到本地
        if (!$result) {
            return false;
        }
        return $filename;
    } else {
        // 直接输出显示
        $imageRes->show();
    }
    exit();
}

/**
 * 把用户输入的文本转义（主要针对特殊符号和emoji表情）
 */
function userTextEncode($str)
{
    if (!is_string($str)) {
        return $str;
    }

    if (!$str || $str == 'undefined') {
        return '';
    }

    $text = json_encode($str); //暴露出unicode
    $text = preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i", function ($str) {
        return addslashes($str[0]);
    }, $text); //将emoji的unicode留下，其他不动，这里的正则比原答案增加了d，因为我发现我很多emoji实际上是\ud开头的，反而暂时没发现有\ue开头。
    return json_decode($text);
}
/**
 * 解码上面的转义
 */
function userTextDecode($str)
{
    $text = json_encode($str); //暴露出unicode
    $text = preg_replace_callback('/\\\\\\\\/i', function ($str) {
        return '\\';
    }, $text); //将两条斜杠变成一条，其他不动
    // return $text;
    return json_decode($text);
}


function encode($str){
    $str = json_encode($str);
    $parse = preg_replace_callback("/(\\\ue[0-9a-f]{3})/",function($str){
        $s =  ltrim($str[1],"\\");
        return "[em:{$s}]";
    },$str);
	$parse = json_decode($parse);
	return $parse;
}
function decode($str){
    return preg_replace_callback("/\[em\:(.*)\]/",function($str){
        $s = json_encode($str[1]);
        $s = str_replace($str[1],"\\".$str[1],$s);
        return json_decode($s);
    },$str);
}