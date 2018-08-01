<?php

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
function createPoster($config = array(), $filename = "")
{
    // 如果要看报什么错，可以先注释调这个header
    if (empty($filename)) {
        header('Content-Type:image/jpg');
    }

    $imageDefault = array(
        'left' => 0,
        'top' => 0,
        'right' => 0,
        'bottom' => 0,
        'width' => 100,
        'height' => 100,
        'opacity' => 100,
        'circ' => false
    );
    $textDefault = array(
        'text' => '',
        'left' => 0,
        'top' => 0,
        'fontSize' => 32, //字号
        'fontColor' => '255,255,255', //字体颜色
        'angle' => 0,
    );

    $background = $config['background']; //海报最底层得背景
    //背景方法
    $backgroundInfo = getimagesize($background);
    $backgroundFun = 'imagecreatefrom' . image_type_to_extension($backgroundInfo[2], false);
    $background = $backgroundFun($background);
    $backgroundWidth = imagesx($background); //背景宽度
    $backgroundHeight = imagesy($background); //背景高度
    $imageRes = imageCreatetruecolor($backgroundWidth, $backgroundHeight);

    // 原来的解决方案【但是无效，待研究】
    // $color = imagecolorallocate($imageRes, 0, 0, 0);
    // imageColorTransparent($imageRes, $color);  //颜色透明

    // 【简单暴力，设置相似颜色】
    $color = imagecolorallocatealpha($imageRes, 222, 248, 221, 127);
    imagefill($imageRes, 0, 0, $color);
    imagecopyresampled($imageRes, $background, 0, 0, 0, 0, imagesx($background), imagesy($background), imagesx($background), imagesy($background));
    //处理了图片
    if (!empty($config['image'])) {
        foreach ($config['image'] as $key => $val) {
            $val = array_merge($imageDefault, $val);
            $info = getimagesize($val['url']);
            $function = 'imagecreatefrom' . image_type_to_extension($info[2], false);
            if ($val['stream']) { //如果传的是字符串图像流
                $info = getimagesizefromstring($val['url']);
                $function = 'imagecreatefromstring';
            }
            $res = $function($val['url']);
            // 是否裁剪成圆形（建议微信头像适用）
            if ($val['circ'] == true) {
                $res = circImages($val['url']);
            }
            $resWidth = $info[0];
            $resHeight = $info[1];
            //建立画板 ，缩放图片至指定尺寸
            $canvas = imagecreatetruecolor($val['width'], $val['height']);
            imagefill($canvas, 0, 0, $color);
            //关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
            imagecopyresampled($canvas, $res, 0, 0, 0, 0, $val['width'], $val['height'], $resWidth, $resHeight);
            $val['left'] = $val['left'] < 0 ? $backgroundWidth - abs($val['left']) - $val['width'] : $val['left'];
            $val['top'] = $val['top'] < 0 ? $backgroundHeight - abs($val['top']) - $val['height'] : $val['top'];
            //放置图像
            imagecopymerge($imageRes, $canvas, $val['left'], $val['top'], $val['right'], $val['bottom'], $val['width'], $val['height'], $val['opacity']); //左，上，右，下，宽度，高度，透明度
        }
    }

    //处理文字
    if (!empty($config['text'])) {
        foreach ($config['text'] as $key => $val) {
            $val = array_merge($textDefault, $val);
            list($R, $G, $B) = explode(',', $val['fontColor']);
            $fontColor = imagecolorallocate($imageRes, $R, $G, $B);
            $val['left'] = $val['left'] < 0 ? $backgroundWidth - abs($val['left']) : $val['left'];
            $val['top'] = $val['top'] < 0 ? $backgroundHeight - abs($val['top']) : $val['top'];
            imagettftext($imageRes, $val['fontSize'], $val['angle'], $val['left'], $val['top'], $fontColor, $val['fontPath'], $val['text']);
        }
    }
    //生成图片
    if (!empty($filename)) {
        $res = imagejpeg($imageRes, $filename, 90); //保存到本地
        imagedestroy($imageRes);
        if (!$res) {
            return false;
        }

        return $filename;
    } else {
        // 图像输出乱码问题：
        // imagejpeg()函数浏览器显示必须不能带有 html.body等标签
        // php中常见解决，调用的时候不要echo retrun
        imagejpeg($imageRes); //在浏览器上显示
        imagedestroy($imageRes);
    }
}

/**
 * 海报生成业务处理
 * @param config|array  海报合成资源（文字、图片、背景图）
 */
function posterImages($config = array(), $filename = '')
{
    createPoster($config, $filename);
    exit();
}

/**
 * 生成圆形图片
 * @param $imgpath  图片地址/支持微信、QQ头像等没有后缀的网络图
 * @param $saveName string 保存文件名，默认空。
 * @return resource 返回图片资源或保存文件
 */
function circImages($imgpath, $saveName = '')
{
    $src_img = imagecreatefromstring(file_get_contents($imgpath));
    $w = imagesx($src_img);
    $h = imagesy($src_img);
    $w = $h = min($w, $h);

    $img = imagecreatetruecolor($w, $h);
    //这一句一定要有
    imagesavealpha($img, true);
    //拾取一个完全透明的颜色,最后一个参数127为全透明
    $bg = imagecolorallocatealpha($img, 255, 255, 255, 127);
    imagefill($img, 0, 0, $bg);
    $r = $w / 2; //圆半径
    for ($x = 0; $x < $w; $x++) {
        for ($y = 0; $y < $h; $y++) {
            $rgbColor = imagecolorat($src_img, $x, $y);
            if (((($x - $r) * ($x - $r) + ($y - $r) * ($y - $r)) < ($r * $r))) {
                imagesetpixel($img, $x, $y, $rgbColor);
            }
        }
    }

    //返回资源
    if (!$saveName) {
        return $img;
    }

    //输出图片到文件
    imagepng($img, $saveName);
    //释放空间
    imagedestroy($src_img);
    imagedestroy($img);
}
