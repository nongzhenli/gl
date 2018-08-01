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
     * create by xiong
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
            // 还是很慢，网络查询得知，使用file_get_contents 导致速度很慢???????? 推荐替换curl 
            // 参考文章：https://blog.csdn.net/shu102ming/article/details/70787836?utm_source=itdadao&utm_medium=referral
            //          https://blog.csdn.net/gaoxuaiguoyi/article/details/47973229
            // 或替换掉 gd库，使用imagick库
            $createType = imagecreatefromstring(file_get_contents($png));
            return $createType;
        }
        switch (strtolower($imgType['extension'])) {
            case 'jpg':
            case 'jpeg':
                // ImageCreateFromJpeg 由文件或 URL 创建一个新图象
                $createType = @ImageCreateFromJpeg($png);
                if (!$createType) {
                    // imagecreatefromstring() 从字符串中的图像流新建一图像
                    $createType = imagecreatefromstring(file_get_contents($png));
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
                    // imagecreatefromstring() 从字符串中的图像流新建一图像。 file_get_contents() 将整个文件读入一个字符串
                    $createType = imagecreatefromstring(file_get_contents($png));
                }
                break;
        }
        return $createType;
    }

    /**
     *
     * $pngArr = array(
     * array(
     * 'start_x'=>0,//图片摆放横坐标
     * 'start_y' =>0,//纵坐标
     * 'path'=>'image/png.png',//路径
     * ),
     * );
     * create by xiong
     * @param array $pngArr
     * 这方法是用来合成多张图片
     */
    public function combineImg($pngArr = array())
    {
        foreach ($pngArr as $png) {
            $resource = $this->getExt($png['path']);
            $png['start_y'] = $png['start_y'] < 0 ? $png['height'] - $png['start_y'] : $png['start_y'];
            imagecopyresized($this->background, $resource, $png['start_x'], $png['start_y'], 0, 0, $png['width'], $png['height'], imagesx($resource), imagesy($resource));
            imagedestroy($resource);
        }
    }

    /**
     * array(
     * 'str'=>'ni',
     *  'fontPath'=>'/font.ttf',
     *  'x'=>200,
     *  'y'=>100,
     *  'size'=>20,
     *  'angle'=>0,
     *  'color'=>''
     * )
     * create by xiong
     * @param $str
     * @param $fontPath
     * 这方法是用来生成文字到图片上
     */

    public function createString($strarr = array())
    {
        foreach ($strarr as $str) {
            // 将字体合成
            $color = imagecolorallocate($this->background, $str['color_r'], $str['color_g'], $str['color_b']); //设置字体颜色
            imagefttext($this->background, $str['size'], $str['angle'], $str['x'], $str['y'], $color, $str['fontPath'], $str['str']);
        }

        //array imagefttext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text [, array $extrainfo ] )
        // 用 col 颜色将size大小，旋转角度为angle，字体为font的字符串 s 画到 image 所代表的图像的x,y坐标；
        //$x，$y 被绘制字符串的第一个字符的基线点。单位是像素。这里涉及到字体设计的基本知识--基线。这个点绝对不是左上角，而具体是什么取决于所使用的字体是如何设计的

    }

    /**
     * create by xiong
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

    public function show()
    {
        header("Content-type: image/jpg");
        imagejpeg($this->background);
    }

    public function save($dest_path, $type)
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
        if ($imagesave($this->background, $dest_path)) {
            imagedestroy($this->background);
            return $dest_path;
        }
        exit('图片保存错误');
    }
}
