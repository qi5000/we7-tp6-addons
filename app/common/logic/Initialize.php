<?php

declare(strict_types=1);

namespace app\common\logic;

use think\facade\Filesystem;

class Initialize
{
    /**
     * 初始化图片
     */
    public static function image($name, $scene = 1)
    {
        switch ($scene) {
            case 1: //带域名的URL地址
                $result = self::getAccessUrl($name);
                break;
            case 2: //绝对路径
                $result = self::getAbsolutePath($name);
                break;
            case 3: //相对路径
                $result = self::getRelativePath($name);
                break;
        }
        return $result;
    }

    // +-------------------------------------------------------------
    // | 功能封装
    // +-------------------------------------------------------------

    /**
     * 返回可以访问的图片URL地址
     *
     * @param string $name
     */
    private static function getAccessUrl(string $name)
    {
        return Filesystem::getDiskConfig('w7', 'url') . self::execute($name);
    }

    /**
     * 返回图片绝对路径
     *
     * @param string $name
     */
    private static function getAbsolutePath(string $name)
    {
        return Filesystem::getDiskConfig('w7', 'root') . '/' . self::execute($name);
    }

    /**
     * 返回不带域名的图片地址
     *
     * @param string $name
     */
    private static function getRelativePath(string $name)
    {
        return str_replace(request()->domain(), '', self::getAccessUrl($name));
    }

    /**
     * 执行拷贝文件
     *
     * @param string $name
     */
    private static function execute(string $name)
    {
        $from = public_path() . 'static/image/' . $name;
        $image = 'initialize/' . self::getRandName($name); //新的文件名
        $to = Filesystem::getDiskConfig('w7', 'root') . '/' . $image;
        if (!file_exists(dirname($to))) mkdir(dirname($to), 0777, true);
        copy($from, $to);
        return $image;
    }

    /**
     * 给文件生成新的随机文件名
     */
    private static function getRandName($file)
    {
        return md5(microtime(true) . mt_rand(1, intval(1e9))) . '.' . pathinfo($file, PATHINFO_EXTENSION);
    }
}
