<?php

namespace Initialize;

class Main
{
    /**
     * 初始化图片
     */
    public static function imgInit($img, $rootPath = false)
    {
        $dir      = 'images/initialize/' . date('Ymd');
        $ext      = pathinfo($img, PATHINFO_EXTENSION);
        $filename = md5(microtime(true) . mt_rand(1, 1e9)) . '.' . $ext;
        $path     = ATTACHMENT_ROOT . $dir . '/' . $filename;
        if (!file_exists(dirname($path))) mkdir(dirname($path), 0777, true);
        $res = copy(app()->getRootPath() . '/extend/Initialize/image/' . $img, $path);
        if ($rootPath === true) return $path;
        return $res ? ($dir . '/' . $filename) : '';
    }
}