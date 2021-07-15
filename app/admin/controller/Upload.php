<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\common\logic\Upload as UploadLogic;

class Upload
{
    /**
     * 上传图片
     */
    public function image()
    {
        return UploadLogic::image('file');
    }

    /**
     * 上传商户证书文件
     */
    public function cert()
    {
        return UploadLogic::cert('file');
    }
}
