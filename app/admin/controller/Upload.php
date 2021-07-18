<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\common\logic\Upload as UploadLogic;

/**
 * 上传文件
 */
class Upload
{
    /**
     * 上传图片(带域名)
     */
    public function image()
    {
        return UploadLogic::image('file');
    }

    /**
     * 上传图片
     * 
     * 返回绝对路径、URL访问的图片地址
     */
    public function root()
    {
        return UploadLogic::root('file');
    }

    /**
     * 上传商户证书文件
     */
    public function cert()
    {
        return UploadLogic::cert('file');
    }
}
