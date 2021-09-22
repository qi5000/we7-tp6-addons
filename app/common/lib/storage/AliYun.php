<?php

// +---------------------------------------------------------
// | 文件存放在阿里云OSS
// +---------------------------------------------------------

namespace app\common\lib\storage;

use OSS\OssClient;
use OSS\Core\OssException;

/**
 * 阿里云对象存储 OSS
 * 
 * composer require aliyuncs/oss-sdk-php
 */
class AliYun extends Base
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
     * 文件上传到阿里云对象存储 OSS
     *
     * @param string $name  字段域
     * @param string $scene 验证场景
     */
    public function upload(string $name, string $scene)
    {
        // 配置参数
        $bucket    = $this->config['bucket'];
        $domain    = $this->config['domain'];
        $endpoint  = $this->config['endpoint'];
        $accessKey = $this->config['accessKey'];
        $secretKey = $this->config['secretKey'];
        // 判断是否有文件上传
        $file = $this->checkUpload($name, $scene);
        if (!is_array($file)) {
            // 单文件上传
            if (!$file instanceof \think\file\UploadedFile) return $file;
        }
        // 将文件上传到阿里云
        try {
            // 实例化对象
            $ossClient = new OssClient($accessKey, $secretKey, $endpoint);
            if (is_array($file)) {
                $uploads = [];
                foreach ($file['success'] as $value) {
                    // 文件在存储空间中的存放位置
                    $path = $this->buildSaveName($value);
                    //执行上传: (bucket名称, 上传的目录, 临时文件路径)
                    $result = $ossClient->uploadFile($bucket, $path, $value->getRealPath());
                    // 配置了自有域名使用则自有域名
                    // 否则使用阿里云OSS提供的默认域名
                    if (empty($domain)) {
                        $url = $result['info']['url'];
                    } else {
                        $url = $domain . '/' . $path;
                    }
                    $uploads[] = $url;
                }
                return $this->data($uploads, $file['error']);
            } else {
                // 文件在存储空间中的存放位置
                $path = $this->buildSaveName($file);
                //执行上传: (bucket名称, 上传的目录, 临时文件路径)
                $result = $ossClient->uploadFile($bucket, $path, $file->getRealPath());
                // 配置了自有域名使用则自有域名
                // 否则使用阿里云OSS提供的默认域名
                if (empty($domain)) {
                    $url = $result['info']['url'];
                } else {
                    $url = $domain . '/' . $path;
                }
            }
        } catch (OssException $e) {
            return $this->fail($e->getMessage());
        }
        return $this->msg($url);
    }
}
