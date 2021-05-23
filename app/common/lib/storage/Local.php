<?php

// +---------------------------------------------------------
// | 文件存放在本地服务器
// +---------------------------------------------------------

namespace app\common\lib\storage;

use think\facade\Filesystem;

/**
 * 本地存储
 */
class Local extends Base
{
    /**
     * 文件存储在本地服务器
     */
    public function upload(string $name, string $scene)
    {
        // 判断是否有文件上传
        $file = $this->checkUpload($name, $scene);
        if (!$file instanceof \think\file\UploadedFile) return $file;
        // 执行文件上传
        $savename = Filesystem::disk('w7')->putFile('images', $file);
        // 返回带域名的文件地址
        return $this->msg(Filesystem::getDiskConfig('w7', 'url') . str_replace('\\', '/', $savename));
    }
}
