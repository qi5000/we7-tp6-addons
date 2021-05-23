<?php

// +----------------------------------------------------------------------
// | 文件存储封装类
// +----------------------------------------------------------------------
// | Author: liang <23426945@qq.com>
// +----------------------------------------------------------------------
// | composer require qiniu/php-sdk
// +----------------------------------------------------------------------
// | composer require aliyuncs/oss-sdk-php
// +----------------------------------------------------------------------
// | composer require qcloud/cos-sdk-v5
// +----------------------------------------------------------------------

namespace app\common\lib\storage;

use app\common\model\Storage as StorageModel;

/**
 * 本地存储
 */
class UploadFactory
{
    /**
     * 文件上传统一方法
     *
     * @param string $name  文件字段域
     * @param string $scene 上传场景名称 image 图片
     */
    public static function upload(string $name, string $scene = 'image')
    {
        $config = StorageModel::where('in_use', 1)->findOrEmpty();
        $config->isEmpty() && fault('未查询到文件存储配置');
        $config = $config->toArray();
        switch ($config['type']) {
            case 0:
                $object = new Local;
                break;
            case 1:
                $object = new Kodo($config);
                break;
            case 2:
                $object = new AliYun($config);
                break;
            case 3:
                $object = new Tencent($config);
                break;
        }
        return $object->upload($name, $scene);
    }
}
