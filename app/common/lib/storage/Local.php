<?php

// +---------------------------------------------------------
// | 文件存放在本地服务器
// +---------------------------------------------------------

namespace app\common\lib\storage;

use think\facade\Filesystem;

/**
 * 本地存储
 * 
 * @author  liang 23426945@qq.com
 */
class Local extends Base
{
    /**
     * 文件存储在本地服务器
     */
    public function upload(string $name, string $scene, bool $isFullPath = false)
    {
        // 判断是否有文件上传
        $file = $this->checkUpload($name, $scene);
        if (!is_array($file)) {
            // 单文件上传
            if (!$file instanceof \think\file\UploadedFile) return $file;
        }
        if (is_array($file)) {
            $uploads = [];
            foreach ($file['success'] as $value) {
                $savename = Filesystem::disk('w7')->putFile($scene, $value);
                if ($isFullPath === true) {
                    // 绝对路径地址
                    $url = Filesystem::getDiskConfig('w7', 'root') . '/' . str_replace('\\', '/', $savename);
                } else {
                    // 带域名的文件地址
                    $url = Filesystem::getDiskConfig('w7', 'url') . str_replace('\\', '/', $savename);
                }
                $uploads[] = $url;
            }
            return $this->data($uploads, $file['error']);
        } else {
            // 执行文件上传
            $savename = Filesystem::disk('w7')->putFile($scene, $file);
            if ($isFullPath === true) {
                // 返回绝对路径文件地址
                return $this->msg(Filesystem::getDiskConfig('w7', 'root') . '/' . str_replace('\\', '/', $savename));
            } else {
                // 返回带域名的文件地址
                return $this->msg(Filesystem::getDiskConfig('w7', 'url') . str_replace('\\', '/', $savename));
            }
        }
    }
}
