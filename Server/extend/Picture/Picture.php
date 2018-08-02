<?php
/* picture 图片处理拓展
 * @Author: big黑钦
 * @Date: 2018-08-01 16:32:43
 * @Last Modified by: big黑钦
 * @Last Modified time: 2018-08-01 17:06:28
 */
namespace picture;

class Picture
{
    //定义常用必须路径
    private $sourcePath; //图片源路径
    private $savePath; //保存路径
    private $nums; //合成图片数量
    private $imgArr = array(); //图片路径关联数组

    private $background; //背景图
    private $bg_w; // 背景图片宽度
    private $bg_h; // 背景图片高度
    private $createType;
    private  $imageDefault = array( // 图像默认参数
        'circ' => false
    );
    private  $textDefault = array(  // 字体默认参数
        'fontSize' =>  14,
        'fontColor' => '255,255,255',
        'angle' => 0,
    );

    //g构造函数创建画布背景
    public function __construct($backgroup)
    {
        // list() 用于一次给一组变量赋值
        list($imgWidth, $imgHight) = getimagesize($backgroup);
        $resource = $this->getExt($backgroup);
        // imagecreatetruecolor() 创建一个真彩色图像，返回一个黑色图像。imagesx()取得图像的宽度，imagesy()取得图像的高度
        $this->background = imagecreatetruecolor(imagesx($resource), imagesy($resource)); // 背景图片
        $color = imagecolorallocate($this->background, 202, 201, 201); // 为真彩色画布创建白色背景，再设置为透明
        imagefill($this->background, 0, 0, $color); // 创建画布
        imageColorTransparent($this->background, $color);
        imagecopyresized($this->background, $resource, 0, 0, 0, 0, $imgWidth, $imgHight, imagesx($resource), imagesy($resource));
        imagedestroy($resource);

    }

    /**
     * @param string $url get请求地址
     * @param int $httpCode 返回状态码
     * @return mixed
     */
    public function curl_get($url, &$httpCode = 0)
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
    /*
     *功能：php完美实现下载远程图片保存到本地
     *参数：文件url,保存文件目录,保存文件名称，使用的下载方式
     *当保存文件名称为空时则使用远程文件原来的名称
     */
    public function getImage($url, $save_dir = '', $type = 0)
    {
        if (trim($url) == '') {
            return 0;
        }

        //获取远程文件所采用的方法
        if ($type) {
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $img = curl_exec($ch);
            curl_close($ch);
        } else {
            ob_start();
            readfile($url);
            $img = ob_get_contents();
            ob_end_clean();
        }
        //$size=strlen($img);
        //文件大小
        file_put_contents($save_dir, $img);

        $src = imagecreatefromstring($img);
        $w = imagesx($src);
        $h = imagesy($src);
        $newpic = imagecreatetruecolor($w, $h);
        imagealphablending($newpic, false);
        $transparent = imagecolorallocatealpha($newpic, 0, 0, 0, 127);
        $r = $w / 2;
        for ($x = 0; $x < $w; $x++) {
            for ($y = 0; $y < $h; $y++) {
                $c = imagecolorat($src, $x, $y);
                $_x = $x - $w / 2;
                $_y = $y - $h / 2;
                if ((($_x * $_x) + ($_y * $_y)) < ($r * $r)) {
                    imagesetpixel($newpic, $x, $y, $c);
                } else {
                    imagesetpixel($newpic, $x, $y, $transparent);
                }
            }
        }

        imagesavealpha($newpic, true);
        if (imagepng($newpic, $save_dir)) {
            imagedestroy($newpic);
            unset($img, $url);
            return 1;
        }
    }

    /**
     * 生成圆形图片
     * @param $imgpath  图片地址/支持微信、QQ头像等没有后缀的网络图
     * @param $saveName string 保存文件名，默认空。
     * @return resource 返回图片资源或保存文件
     */
    public function circImages($imgpath, $saveName = '')
    {
        // 使用curl 替换 file_get_contents 速度提升惊人 18s -> 0.3s
        $src_img = imagecreatefromstring($this->curl_get($imgpath));
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

    /**
     * @param $png
     * @return bool|string
     * 这方法是用来获取图片后缀
     */
    public function getExt($png)
    {
        // list($imgWidth, $imgHight, $imgType) = getimagesize($png);
        $imgType = pathinfo($png);
        //  微信头像图像信息不存在extension
        if (!array_key_exists('extension', $imgType)) {
            // 还是很慢，网络查询得知，使用file_get_contents 导致速度很慢???????? 推荐替换curl 【替换curl速度很快】
            // 参考文章：https://blog.csdn.net/shu102ming/article/details/70787836?utm_source=itdadao&utm_medium=referral
            //          https://blog.csdn.net/gaoxuaiguoyi/article/details/47973229
            // 或替换掉 gd库，使用imagick库
            $createType = imagecreatefromstring($this->curl_get($png));
            return $createType;
        }
        switch (strtolower($imgType['extension'])) {
            case 'jpg':
            case 'jpeg':
                // ImageCreateFromJpeg 由文件或 URL 创建一个新图象
                $createType = @ImageCreateFromJpeg($png);
                if (!$createType) {
                    // imagecreatefromstring() 从字符串中的图像流新建一图像
                    $createType = imagecreatefromstring($this->curl_get($png));
                }
                // $createType    = imagecreatefromjpeg($png);
                break;
            case 'png':
                $createType = imagecreatefrompng($png);
                break;
            case 'gif':

            default:
                if (base64_decode($png)) {
                    $createType = imagecreatefromstring($png);
                } else {
                    // imagecreatefromstring() 从字符串中的图像流新建一图像。
                    $createType = imagecreatefromstring($this->curl_get($png));
                }
                break;
        }
        return $createType;
    }

    /**
     * @param array $pngArr
     * 这方法是用来合成多张图片
     */
    public function combineImg($pngArr = array())
    {
        foreach ($pngArr as $val) {
            $val = array_merge($this->imageDefault, $val);
            if ($val['circ']) { // 裁剪圆形图
                $resource = $this->circImages($val['path']);
            } else {
                $resource = $this->getExt($val['path']);
            }
            $val['start_y'] = $val['start_y'] < 0 ? $val['height'] - $val['start_y'] : $val['start_y'];
            imagecopyresized($this->background, $resource, $val['start_x'], $val['start_y'], 0, 0, $val['width'], $val['height'], imagesx($resource), imagesy($resource));
            imagedestroy($resource);
        }
    }

    /**
     * @param $str
     * @param $fontPath
     * 这方法是用来生成文字到图片上
     */

    public function createString($strarr = array())
    {
        foreach ($strarr as $val) {
            $val = array_merge($this->textDefault, $val);
            // 将字体合成
            list($R, $G, $B) = explode(',', $val['fontColor']);
            $color = imagecolorallocate($this->background, $R, $G, $B); //设置字体颜色
            imagefttext($this->background, $val['fontSize'], $val['angle'], $val['x'], $val['y'], $color, $val['fontPath'], $val['str']);
        }
        //array imagefttext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text [, array $extrainfo ] )
        // 用 col 颜色将size大小，旋转角度为angle，字体为font的字符串 s 画到 image 所代表的图像的x,y坐标；
        //$x，$y 被绘制字符串的第一个字符的基线点。单位是像素。这里涉及到字体设计的基本知识--基线。这个点绝对不是左上角，而具体是什么取决于所使用的字体是如何设计的

    }

    /**
     * @param $value
     * 这方法是用来生成二维码保存到本地或者不保存
     */
    public function createQcode($value, $path = false, $errorCorrectionLevel = 'L', $matrixPointSize = 3)
    {
        require_once 'phpqrcode.php';
        //  $errorCorrectionLevel = 'L';    //容错级别
        //生成图片大小
        $url = $path;
        $QR = \QRcode::png($value, $url, $errorCorrectionLevel, $matrixPointSize, 2.3);
    }

    // 直接展示图片
    public function show()
    {
        header("Content-type: image/jpg");
        imagejpeg($this->background);
    }

    // 保存生成图片
    public function save($dest_path, $type, $quality=75)
    {
        switch ($type) {
            case 'jpg':
            case 'jpeg':
                $imagesave = 'imagejpeg';
                break;
            case 'png':
                $imagesave = 'imagepng';
                break;

            case 'gif':
                $imagesave = 'imagegif';
                break;
        }
        if ($imagesave($this->background, $dest_path, $quality)) {
            imagedestroy($this->background);
            return $dest_path;
        }
        exit('图片保存错误');
    }
}
