<?php

declare(strict_types=1);

namespace app\api\controller;

use app\common\lib\storage\UploadFactory;

class Upload
{
    /**
     * 上传图片
     */
    public function img()
    {
        return UploadFactory::upload('file', 'image');
    }

    /**
     * 上传商户证书
     *
     * @return void
     */
    public function cert()
    {
        return UploadFactory::upload('file', 'cert');
    }
}
