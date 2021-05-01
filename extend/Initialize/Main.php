<?php

// +---------------------------------------------------------
// | 初始化图片
// +---------------------------------------------------------
// | app(\Initialize\Main::class)->init('favicon.ico');
// +---------------------------------------------------------

namespace Initialize;

class Main
{   
    /**
     * 构造方法
     */
    public function __construct()
    {
        // 默认图片存放目录
        $this->default = 'extend/Initialize/images';
    }

    /**
     * 初始化图片
     */
    public function init($name, $type = 3)
    {
        $image    = implode('/', [$this->getW7RandName(), $this->getRandName($name)]);
        $path     = ATTACHMENT_ROOT . $image;//文件绝对路径
        $this->createDir($path);//路径中的目录不存在就创建
        copy(app()->getRootPath() . $this->default .'/' . $name, $path);//将拷贝文件到微擎资源目录
        switch ($type) {
            case 1://相对路径
                $result = $image;
                break;
            case 2://绝对路径
                $result = $path;
                break;
            case 3://带域名的URL地址
                $result = $this->meImgPrefix($image);
                break;
        }
        return $result;
    }

    // +---------------------------------------------------------
    // | 功能方法
    // +---------------------------------------------------------

    /**
     * 拼接微擎图片前缀
     */
    private function getW7RandName()
    {
        global $_W;
        return implode('/', ['images', $_W['current_module']['name'], $_W['uniacid'], 'initialize', date('Ymd')]);
    }

    /**
     * 拼接微擎图片前缀
     */
    private function meImgPrefix(string $name)
    {
        if (function_exists('tomedia')) return tomedia($name);
        return substr($name, 0, 4) === 'http' ? $name : request()->domain() . '/attachment/' . $name;
    }

    /**
     * 生成随机文件名
     */
    private function getRandName($file)
    {
        return md5(microtime(true) . mt_rand(1, 1e9)) . '.' . pathinfo($file, PATHINFO_EXTENSION);
    }

    /**
     * 路径中的目录不存在就创建目录
     */
    private function createDir($path)
    {
        if (!file_exists(dirname($path))) mkdir(dirname($path), 0777, true);
    }
}