<?php

declare(strict_types=1);

namespace app\common\lib;

class Filesystem
{
    /**
     * 获取本地文件访问前缀
     *
     * @param string $scene 场景值,目录名
     */
    public static function getLocalStorageAccess(string $scene = '')
    {
        return \think\facade\Filesystem::getDiskConfig('w7', 'url') . $scene;
    }

    /**
     * 获取本地存储文件存储路径
     *
     * @param string $scene 场景值,目录名
     */
    public static function getLocalStoragePath(string $scene = '')
    {
        $scene = $scene ? '/' . $scene : '';
        return \think\facade\Filesystem::getDiskConfig('w7', 'root') . $scene;
    }
}
