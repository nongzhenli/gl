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
        var_dump(getimagesize($backgroup));
        var_dump($imgWidth);
        var_dump($imgHight);
        exit();
        $resource = $this->getExt($backgroup);
        $this->background = imagecreatetruecolor(imagesx($resource), imagesy($resource)); // 背景图片
        $color = imagecolorallocate($this->background, 202, 201, 201); // 为真彩色画布创建白色背景，再设置为透明
        imagefill($this->background, 0, 0, $color);
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
        switch (strtolower($imgType['extension'])) {

            case 'jpg':
            case 'jpeg':
                $createType = @ImageCreateFromJpeg($png);
                if (!$createType) {
                    $createType = imagecreatefromstring(file_get_contents($png));
                }
                // $createType    = imagecreatefromjpeg($png);
                break;
            case 'png':
                $createType = imagecreatefrompng($png);
                break;
            case 'gif':

            default:
                $png = base64_decode($png);
                $createType = imagecreatefromstring($png);
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
            //  list($pic_w,$pic_h)=getimagesize($png['path']);
            imagecopyresized($this->background, $resource, $png['start_x'], $png['start_y'], 0, 0, $png['width'], $png['height'], imagesx($resource), imagesy($resource));
            imagedestroy($resource);
            //合成图片
            //imagecopyresized( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h )---拷贝并合并图像的一部分，将 src_im 图像中坐标从 src_x，src_y 开始，宽度为 src_w，高度为 src_h 的一部分拷贝到 dst_im 图像中坐标为 dst_x 和 dst_y 的位置上。
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
