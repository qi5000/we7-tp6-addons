<?php

// +---------------------------------------------------------
// | 文件存放在七牛云
// +---------------------------------------------------------

namespace app\common\lib\storage;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

/**
 * 七牛云对象存储 Kodo
 * 
 * composer require qiniu/php-sdk
 */
class Kodo extends Base
{
    /**
     * 构造方法
     *
     * @param array $config 配置信息
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * 图片上传到七牛云 Kodo
     *
     * @param string $name  字段域
     * @param string $scene 验证场景
     */
    public function upload(string $name, string $scene)
    {
        // 七牛云上传所需配置项
        $bucket    = $this->config['bucket'];
        $domain    = $this->config['domain'];
        $accessKey = $this->config['accessKey'];
        $secretKey = $this->config['secretKey'];
        // 判断是否有文件上传
        $file = $this->checkUpload($name, $scene);
        if (!is_array($file)) {
            // 单文件上传
            if (!$file instanceof \think\file\UploadedFile) return $file;
        }
        // 将文件上传到七牛云
        try {
            // 初始化鉴权对象
            $auth      = new Auth($accessKey, $secretKey);
            // 生成上传Token
            $token     = $auth->uploadToken($bucket);
            // 上传管理类 构建UplaodManager对象
            $uploadMgr = new UploadManager();
            if (is_array($file)) {
                $uploads = [];
                foreach ($file['success'] as $value) {
                    // 文件在存储空间中的存放位置
                    $path = $this->buildSaveName($value);
                    $info = $uploadMgr->putFile($token, $path, $value->getRealPath());
                    // 文件URL地址
                    $url = $domain . '/' . $info[0]['key'];
                    $uploads[] = $url;
                }
                return $this->data($uploads, $file['error']);
            } else {
                // 文件在存储空间中的存放位置
                $path = $this->buildSaveName($file);
                // 执行文件上传到七牛云
                $info = $uploadMgr->putFile($token, $path, $file->getRealPath());
                // 文件URL地址
                $url = $domain . '/' . $info[0]['key'];
            }
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
        return $this->msg($url);
    }
}
